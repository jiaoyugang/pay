<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/6/28 0028
 * Time: 下午 10:08
 */
try{
    $exchangeName = "tradeExchange";
    $routeKey = "/trade";
    $queueName = "trade";
    $connection = new AMQPConnection(['host' => '192.168.1.11' , 'port' => 5672 ,'vhost' => '/' ,'login' => 'guest' ,'password' => 'guest']);

    $connection->connect();
    $channel = new AMQPChannel($connection); #连接创建通道
    $exchange = new AMQPExchange($channel);  #建立交换机通过通道去通讯
    $exchange->setName($exchangeName);  #当前使用的交换机的名称

    //声明队列，并且绑定交换机跟路由key
    $queue = new AMQPQueue($channel);
    $queue->setName($queueName);
    $queue->declareQueue();

    //绑定监听
    $queue->bind($exchangeName , $routeKey);
    $queue->consume(function($envelope ,$queue){
        $data = $envelope->getBody();
        var_dump($data);
        //阻塞监听
        $queue->ack($envelope->getDeliveryTag());
    });
}catch(Exception $e){

    var_dump($e->getMessage());
}