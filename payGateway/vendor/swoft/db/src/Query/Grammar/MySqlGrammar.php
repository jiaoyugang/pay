<?php declare(strict_types=1);


namespace Swoft\Db\Query\Grammar;

use ReflectionException;
use Swoft\Bean\Annotation\Mapping\Bean;
use Swoft\Bean\Exception\ContainerException;
use Swoft\Db\Eloquent\Collection;
use Swoft\Db\Query\Builder;
use Swoft\Db\Query\JsonExpression;
use Swoft\Stdlib\Helper\Arr;
use Swoft\Stdlib\Helper\Str;

/**
 * Class MySqlGrammar
 *
 * @since 2.0
 *
 * @Bean(scope=Bean::PROTOTYPE)
 */
class MySqlGrammar extends Grammar
{
    /**
     * The grammar specific operators.
     *
     * @var array
     */
    protected $operators = ['sounds like'];

    /**
     * The components that make up a select clause.
     *
     * @var array
     */
    protected $selectComponents = [
        'aggregate',
        'columns',
        'from',
        'joins',
        'wheres',
        'groups',
        'havings',
        'orders',
        'limit',
        'offset',
        'lock',
    ];

    /**
     * Compile a select query into SQL.
     *
     * @param Builder $query
     *
     * @return string
     */
    public function compileSelect(Builder $query)
    {
        if ($query->unions && $query->aggregate) {
            return $this->compileUnionAggregate($query);
        }

        $sql = parent::compileSelect($query);

        if ($query->unions) {
            $sql = '(' . $sql . ') ' . $this->compileUnions($query);
        }

        return $sql;
    }

    /**
     * Compile a "JSON contains" statement into SQL.
     *
     * @param string $column
     * @param string $value
     *
     * @return string
     */
    protected function compileJsonContains($column, $value)
    {
        return 'json_contains(' . $this->wrap($column) . ', ' . $value . ')';
    }

    /**
     * Compile a "JSON length" statement into SQL.
     *
     * @param string $column
     * @param string $operator
     * @param string $value
     *
     * @return string
     */
    protected function compileJsonLength($column, $operator, $value)
    {
        [$field, $path] = $this->wrapJsonFieldAndPath($column);

        return 'json_length(' . $field . $path . ') ' . $operator . ' ' . $value;
    }

    /**
     * Compile a single union statement.
     *
     * @param array $union
     *
     * @return string
     */
    protected function compileUnion(array $union)
    {
        $conjunction = $union['all'] ? ' union all ' : ' union ';

        return $conjunction . '(' . $union['query']->toSql() . ')';
    }

    /**
     * Compile the random statement into SQL.
     *
     * @param string $seed
     *
     * @return string
     */
    public function compileRandom($seed)
    {
        return 'RAND(' . $seed . ')';
    }

    /**
     * Compile the lock into SQL.
     *
     * @param Builder     $query
     * @param bool|string $value
     *
     * @return string
     */
    protected function compileLock(Builder $query, $value)
    {
        if (!is_string($value)) {
            return $value ? 'for update' : 'lock in share mode';
        }

        return $value;
    }

    /**
     * Compile an update statement into SQL.
     *
     * @param Builder $query
     * @param array   $values
     *
     * @return string
     * @throws ContainerException
     * @throws ReflectionException
     */
    public function compileUpdate(Builder $query, $values)
    {
        $table = $this->wrapTable($query->from);

        // Each one of the columns in the update statements needs to be wrapped in the
        // keyword identifiers, also a place-holder needs to be created for each of
        // the values in the list of bindings so we can make the sets statements.
        $columns = $this->compileUpdateColumns($values);

        // If the query has any "join" clauses, we will setup the joins on the builder
        // and compile them so we can attach them to this update, as update queries
        // can get join statements to attach to other tables when they're needed.
        $joins = '';

        if (isset($query->joins)) {
            $joins = ' ' . $this->compileJoins($query, $query->joins);
        }

        // Of course, update queries may also be constrained by where clauses so we'll
        // need to compile the where clauses and attach it to the query so only the
        // intended records are updated by the SQL statements we generate to run.
        $where = $this->compileWheres($query);

        $sql = rtrim("update {$table}{$joins} set $columns $where");

        // If the query has an order by clause we will compile it since MySQL supports
        // order bys on update statements. We'll compile them using the typical way
        // of compiling order bys. Then they will be appended to the SQL queries.
        if (!empty($query->orders)) {
            $sql .= ' ' . $this->compileOrders($query, $query->orders);
        }

        // Updates on MySQL also supports "limits", which allow you to easily update a
        // single record very easily. This is not supported by all database engines
        // so we have customized this update compiler here in order to add it in.
        if (isset($query->limit)) {
            $sql .= ' ' . $this->compileLimit($query, $query->limit);
        }

        return rtrim($sql);
    }

    /**
     * Compile all of the columns for an update statement.
     *
     * @param array $values
     *
     * @return string
     *
     * @throws ContainerException
     * @throws ReflectionException
     */
    protected function compileUpdateColumns($values)
    {
        return Collection::new($values)->map(function ($value, $key) {
            if ($this->isJsonSelector($key)) {
                return $this->compileJsonUpdateColumn($key, JsonExpression::new($value));
            }

            return $this->wrap($key) . ' = ' . $this->parameter($value);
        })->implode(', ');
    }

    /**
     * Prepares a JSON column being updated using the JSON_SET function.
     *
     * @param string         $key
     * @param JsonExpression $value
     *
     * @return string
     */
    protected function compileJsonUpdateColumn($key, JsonExpression $value)
    {
        [$field, $path] = $this->wrapJsonFieldAndPath($key);

        return "{$field} = json_set({$field}{$path}, {$value->getValue()})";
    }

    /**
     * Prepare the bindings for an update statement.
     *
     * Booleans, integers, and doubles are inserted into JSON updates as raw values.
     *
     * @param array $bindings
     * @param array $values
     *
     * @return array
     * @throws ContainerException
     * @throws ReflectionException
     */
    public function prepareBindingsForUpdate(array $bindings, array $values)
    {
        $values = Collection::new($values)->reject(function ($value, $column) {
            return $this->isJsonSelector($column) && is_bool($value);
        })->all();

        return parent::prepareBindingsForUpdate($bindings, $values);
    }

    /**
     * Compile a delete statement into SQL.
     *
     * @param Builder $query
     *
     * @return string
     * @throws ContainerException
     * @throws ReflectionException
     */
    public function compileDelete(Builder $query)
    {
        $table = $this->wrapTable($query->from);

        $where = is_array($query->wheres) ? $this->compileWheres($query) : '';

        return isset($query->joins)
            ? $this->compileDeleteWithJoins($query, $table, $where)
            : $this->compileDeleteWithoutJoins($query, $table, $where);
    }

    /**
     * Prepare the bindings for a delete statement.
     *
     * @param array $bindings
     *
     * @return array
     */
    public function prepareBindingsForDelete(array $bindings)
    {
        $cleanBindings = Arr::except($bindings, ['join', 'select']);

        return array_values(
            array_merge($bindings['join'], Arr::flatten($cleanBindings))
        );
    }

    /**
     * Compile a delete query that does not use joins.
     *
     * @param Builder $query
     * @param string  $table
     * @param string  $where
     *
     * @return string
     */
    protected function compileDeleteWithoutJoins($query, $table, $where)
    {
        $sql = trim("delete from {$table} {$where}");

        // When using MySQL, delete statements may contain order by statements and limits
        // so we will compile both of those here. Once we have finished compiling this
        // we will return the completed SQL statement so it will be executed for us.
        if (!empty($query->orders)) {
            $sql .= ' ' . $this->compileOrders($query, $query->orders);
        }

        if (isset($query->limit)) {
            $sql .= ' ' . $this->compileLimit($query, $query->limit);
        }

        return $sql;
    }

    /**
     * Compile a delete query that uses joins.
     *
     * @param Builder $query
     * @param string  $table
     * @param string  $where
     *
     * @return string
     * @throws ContainerException
     * @throws ReflectionException
     */
    protected function compileDeleteWithJoins($query, $table, $where)
    {
        $joins = ' ' . $this->compileJoins($query, $query->joins);

        $alias = stripos($table, ' as ') !== false
            ? explode(' as ', $table)[1] : $table;

        return trim("delete {$alias} from {$table}{$joins} {$where}");
    }

    /**
     * Wrap a single string in keyword identifiers.
     *
     * @param string $value
     *
     * @return string
     */
    protected function wrapValue($value)
    {
        return $value === '*' ? $value : '`' . str_replace('`', '``', $value) . '`';
    }

    /**
     * Wrap the given JSON selector.
     *
     * @param string $value
     *
     * @return string
     * @throws ContainerException
     * @throws ReflectionException
     */
    protected function wrapJsonSelector($value)
    {
        $delimiter = Str::contains($value, '->>')
            ? '->>'
            : '->';

        $path = explode($delimiter, $value);

        $field = $this->wrapSegments(explode('.', array_shift($path)));

        return sprintf('%s' . $delimiter . '\'$.%s\'', $field, Collection::new($path)->map(function ($part) {
            return '"' . $part . '"';
        })->implode('.'));
    }
}
