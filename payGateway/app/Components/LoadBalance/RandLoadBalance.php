<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/6/8 0008
 * Time: 下午 4:08
 */

namespace App\Components\LoadBalance;


class RandLoadBalance implements LoadBalanceInterface
{
    /**
     * 加权随机
     * @param array $serviceList
     * @return array
     */
    public static function select(array $serviceList): array
    {
//        var_dump($serviceList);
        $sum = 0; //总的权重值
        $weightList = [];
        foreach ($serviceList as $key => $value){
            $sum+=$value['weight'];
            $weightList[$key] = $sum;
        }

        $rand = mt_rand(0,$sum);
        foreach ($weightList  as $k => $v){
            if($rand <= $v ){
                return $serviceList[$k];
            }
        }
    }
}