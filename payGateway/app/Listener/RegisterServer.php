<?php declare(strict_types=1);


namespace App\Listener;
use Swoft\Event\Annotation\Mapping\Listener;
use Swoft\Event\EventHandlerInterface;
use Swoft\Event\EventInterface;
use Swoft\Server\ServerEvent;
/**
 * Class RegisterServer
 * @package App\Listener
 * @Listener(ServerEvent::BEFORE_START)
 */
class RegisterServer implements EventHandlerInterface
{
    /**
     * 独立的事件监听器接口，在服务启动前注册服务
     * @param EventInterface $event
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     */
    public function handle(EventInterface $event) : void
    {
        //注册consul服务
        var_dump('服务启动前consul服务中注册服务');
        //获取consul配置信息
        $config = bean('config')->get('provider.consul');
        //注册consul配置
        bean('consulProvider')->registerServer($config);
    }
}