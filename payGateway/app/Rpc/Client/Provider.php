<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/5/29 0029
 * Time: 下午 9:29
 */

namespace App\Rpc\Client;


use App\Components\LoadBalance\RandLoadBalance;
use Six\Rpc\Client\Contract\ProviderInterface;#引入自己的client提供者

//use Swoft\Rpc\Client\Contract\ProviderInterface;

class Provider implements ProviderInterface
{
    protected $serviceName;

    public function __construct($serviceName)
    {
        $this->serviceName = $serviceName;
    }


    /**
     * 继承自rpc框架client
     * 自定义服务提供者
     * 重写rpc客户端服务：\swoft\vendor\swoft\rpc-client\src
     * */
    public function getList(): array
    {

        $config = bean('config')->get('provider.consul');
        //注册consul配置
        $address = bean('consulProvider')->getServerList($this->serviceName , $config);
        //consul服务为空时，请求本地
//        var_dump($address);
        if(empty($address)){

            //rcp 请求地址
            return [config('rpc')['service'] ,config('rpc')['address']];
        }
        //负载均衡（加权随机）
        $address = RandLoadBalance::select((array)array_values($address))['address'];


        //写死地址；可以从consul中读取
        return [$address];
    }
}