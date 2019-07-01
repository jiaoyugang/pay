<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/6/15 0015
 * Time: 下午 11:30
 */

namespace Six\Rpc\Client;


class Route
{
    

    private static $routeList = [];

    /**
     * @param $fallback
     * @param $version
     * @param $method_name
     * @param $className
     */
    public static function registerRoute($fallback,$version,$method_name,$className)
    {
//        var_dump($fallback,$version,$method_name,$className);
        self::$routeList[$fallback][$version][$method_name] = $className;
    }

    /**
     * @param $fallback
     * @param $version
     * @param $method_name
     * @param $className
     * @return mixed
     */
    public static function matchRoute($fallback,$version,$method_name)
    {
        return self::$routeList[$fallback][$version][$method_name] ??'';
    }
}