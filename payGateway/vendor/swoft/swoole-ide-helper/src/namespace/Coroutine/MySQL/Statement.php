<?php
namespace Swoole\Coroutine\MySQL;

/**
 * @since 4.3.3
 */
class Statement
{

    public $affected_rows;
    public $insert_id;
    public $error;
    public $errno;

    /**
     * @param $params [optional]
     * @param $timeout [optional]
     * @return mixed
     */
    public function execute(array $params=null, float $timeout=null){}

    /**
     * @return mixed
     */
    public function fetch(){}

    /**
     * @return mixed
     */
    public function fetchAll(){}

    /**
     * @return mixed
     */
    public function nextResult(){}

    /**
     * @return mixed
     */
    public function __destruct(){}


}
