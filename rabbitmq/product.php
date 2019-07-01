<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/6/28 0028
 * Time: 下午 10:08
 */
try{
    /**
     *      'host'  => amqp.host The host to connect too. Note: Max 1024 characters.
     *      'port'  => amqp.port Port on the host.
     *      'vhost' => amqp.vhost The virtual host on the host. Note: Max 128 characters.
     *      'login' => amqp.login The login name to use. Note: Max 128 characters.
     *      'password' => amqp.password Password. Note: Max 128 characters.
     */
    $exchangeName = "tradeExchange"; #通道名称
    $routeKey = "/trade";
    $connection = new AMQPConnection(['host' => '192.168.1.11' ,'port' => '5672' ,'vhost' => '/' ,'login' => 'guest' ,'password' => 'guest']);

    $connection->connect();

    $channel = new AMQPChannel($connection); #连接创建通道
    $exchange = new AMQPExchange($channel);  #建立交换机通过通道去通讯
    $exchange->setName($exchangeName);  #设置通过名称
    $exchange->setType(AMQP_EX_TYPE_DIRECT); #声明通道，创建通道
    $exchange->declareExchange();
    //发布消息到交换机当中，并且绑定好路由关系
    var_dump($exchange->publish('我是订单任务消息:'.uniqid().time(),$routeKey));
}catch(Exception $e){
    var_dump($e->getMessage());
}