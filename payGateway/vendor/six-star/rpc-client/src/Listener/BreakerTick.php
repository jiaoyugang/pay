<?php declare(strict_types=1);
namespace Six\Rpc\Client\Listener;
use Six\Rpc\Client\CircuitBreak;
use Swoft\Event\Annotation\Mapping\Listener;
use Swoft\Event\EventHandlerInterface;
use Swoft\Event\EventInterface;
use Swoft\Redis\Redis;
use Swoft\Server\Swoole\SwooleEvent;
use Swoole\Timer;

/**
 * Class BreakerTick
 * @package App\Listener
 * @Listener(SwooleEvent::START)
 */
class BreakerTick implements EventHandlerInterface
{

    public function handle(EventInterface $event) : void
    {
        //注册consul服务
        swoole_timer_tick(2000,function ($timer_id){
            $service = Redis::zRangeByScore(CircuitBreak::OpenBreaker,'-inf',(string)time() ,['limit' => [0,30]]);
            //修改服务熔断状态
            if(!empty($service)){
                foreach ($service as $address){
                    //修改当前被熔断的服务score为负值
                    Redis::zAdd(CircuitBreak::FailKey ,[-CircuitBreak::FailCount => $address]);
                    //移除熔断服务状态
                    Redis::zRem(CircuitBreak::OpenBreaker , $address);
                    output()->writeln("<success>修改了:{$address}</success>");
                }
            }
        });
    }
}