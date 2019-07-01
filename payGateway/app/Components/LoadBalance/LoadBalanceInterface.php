<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/6/8 0008
 * Time: 下午 8:48
 */

namespace App\Components\LoadBalance;


interface LoadBalanceInterface
{
    public static function select(array $serviceList):array ;
}