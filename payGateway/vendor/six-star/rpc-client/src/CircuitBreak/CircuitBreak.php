<?php
namespace Six\Rpc\Client;

use phpDocumentor\Reflection\Types\Self_;
use Swoft\Bean\Annotation\Mapping\Inject;
use Swoft\Redis\Redis;

class CircuitBreak
{

    const FailKey       =   'circuit';  #记录服务失败次数的key
    const OpenBreaker    =   'circuit_open';  #服务开启熔断
    const FailCount     =   3; #允许失败的次数
    const SuccessCount  =   3; #成功次数后
    const StateOpen     =   1; #熔断器开启
    const StateHalfOpen =   2; #熔断器半开
    const StateClose    =   3; #熔断器关闭
    const OpenTimer     =   5; #多久时间切换到半开的时间
    /**
     * @Inject("redis.pool")
     * @var \Swoft\Redis\Pool
     * */
    public $redis;

    /**
     * 记录服务失败次数，并返回失败的次数
     * @param $address       服务：ip:port
     * @param null $count
     * @return float|int
     */
    public function add($address,$count=null)
    {
        if($count!=null){
            return Redis::zAdd(self::FailKey, [$count, $address]);
        }
        return Redis::zIncrBy(self::FailKey, 1, $address);
    }


    /**
     * 获取服务状态
     * @param $address     服务：ip:port
     * @return float
     */
    public function getState($address)
    {
        $score =  Redis::zScore(self::FailKey , $address);
        var_dump($score."成绩");
        #服务记录失败次数大于设定的次数，开启熔断服务
        if($score >= self::FailCount) return self::StateOpen; #返回开启状态
        #服务失败次数小于0，半开器熔断服务
        if($score < 0) return self::StateHalfOpen; #返回半开启状态
        #服务失败次数： 0<= 服务失败次数 < self::FailCount
        return self::StateClose;  #返回的是关闭状态
    }

    /**
     * 开启熔断器
     * @param $address      服务：ip:port
     * @return int
     */
    public function openBreaker($address)
    {
        #zAdd(key,score,member)
        return Redis::zAdd(self::OpenBreaker ,[(time()+self::OpenTimer) => $address] );
    }
}