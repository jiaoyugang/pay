<?php declare(strict_types=1);

namespace Swoft\Aop\Annotation\Mapping;

use Doctrine\Common\Annotations\Annotation\Attribute;
use Doctrine\Common\Annotations\Annotation\Attributes;
use Doctrine\Common\Annotations\Annotation\Target;

/**
 * Class PointBean
 *
 * @Annotation
 * @Target("CLASS")
 * @Attributes({
 *     @Attribute("include", type="array"),
 *     @Attribute("exclude", type="array"),
 * })
 *
 * @since 2.0
 */
final class PointBean
{
    /**
     * Include beanName or alias
     *
     * @var array
     */
    private $include = [];

    /**
     * Exclude beanName or alias
     *
     * @var array
     */
    private $exclude = [];

    /**
     * PointBean constructor.
     *
     * @param array $values
     */
    public function __construct(array $values)
    {
        if (isset($values['value'])) {
            $this->include = $values['value'];
        }
        if (isset($values['include'])) {
            $this->include = $values['include'];
        }
        if (isset($values['exclude'])) {
            $this->exclude = $values['exclude'];
        }
    }

    /**
     * @return array
     */
    public function getInclude(): array
    {
        return $this->include;
    }

    /**
     * @return array
     */
    public function getExclude(): array
    {
        return $this->exclude;
    }
}