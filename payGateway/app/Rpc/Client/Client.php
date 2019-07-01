<?php declare(strict_types=1);
/**
 * 自定义的client模块
 */
namespace App\Rpc\Client;

//use Swoft\Rpc\Client\Contract\ProviderInterface;
use Six\Rpc\Client\Contract\ProviderInterface;

class Client extends \Six\Rpc\Client\Client
{
    protected $serviceName; //服务名称
    /**
     * @return ProviderInterface
     */
    public function getProvider(): ?ProviderInterface
    {
//        var_dump('获取到的服务名称：'.$this->serviceName);
        //不能区分当前调用的那个服务
        return $this->provider = new Provider($this->serviceName);
    }

    /**
     * 返回服务名称
     * @return  string  serviceName
     * */
    public function getServiceName():string
    {
        return $this->serviceName;
    }
}