<?php

use Swoft\Http\Server\HttpServer;
use Swoft\Task\Swoole\TaskListener;
use Swoft\Task\Swoole\FinishListener;
use Swoft\Rpc\Client\Client as ServiceClient;
use Swoft\Rpc\Client\Pool as ServicePool;
use Swoft\Rpc\Server\ServiceServer;
use Swoft\Http\Server\Swoole\RequestListener;
use Swoft\WebSocket\Server\WebSocketServer;
use Swoft\Server\Swoole\SwooleEvent;
use Swoft\Db\Database;
use Swoft\Redis\RedisDb;

return [
    'logger'     => [
        'flushRequest' => true,
        'enable'       => false,
        'json'         => false,
    ],
    'httpServer' => [
        'class'    => HttpServer::class,
        'port'     => 9501,
        'listener' => [
            'rpc' => bean('rpcServer')
        ],
        'on'       => [
            SwooleEvent::TASK   => bean(TaskListener::class),  // Enable task must task and finish event
            SwooleEvent::FINISH => bean(FinishListener::class)
        ],
        /* @see HttpServer::$setting */
        'setting'  => [
            'task_worker_num'       => 12,
            'task_enable_coroutine' => true
        ]
    ],
    'db'         => [
        'class'    => Database::class,
        'dsn'      => 'mysql:dbname=test;host=172.17.0.3',
        'username' => 'root',
        'password' => 'swoft123456',
    ],
    'redis'      => [
        'class'    => RedisDb::class,
        'host'     => '127.0.0.1',
        'port'     => 6379,
        'database' => 0,
    ],
    'user'       => [
        'class'   => ServiceClient::class,
        'host'    => '127.0.0.1',
        'port'    => 9503,
        'serviceName' => 'user-php',
        'setting' => [
            'timeout'         => 0.5,
            'connect_timeout' => 1.0,
            'write_timeout'   => 10.0,
            'read_timeout'    => 0.5,
        ],
        'packet'  => bean('rpcClientPacket')
    ],
    'user.pool'  => [
        'class'  => ServicePool::class,
        'client' => bean('user')
    ],
    'pay'       => [
        'class'   => \App\Rpc\Client\Client::class,  //选取调用的客户端\App\Rpc\Client\Client::class
        'host'    => '127.0.0.1',
        'port'    => 9503,
        'serviceName' => 'pay-php',
        'setting' => [
            'timeout'         => 0.5,
            'connect_timeout' => 1.0,
            'write_timeout'   => 10.0,
            'read_timeout'    => 0.5,

        ],
        'packet'  => bean('rpcClientPacket')
    ],
    'pay.pool'  => [
        'class'  => \Six\Rpc\Client\Pool::class,  #引用自定义的client池
        'client' => bean('pay'),
        'minActive'   => 10,
        'maxActive'   => 20,
        'maxWait'     => 0,
        'maxWaitTime' => 0,
        'maxIdleTime' => 40,
    ],
    'rpcServer'  => [
        'class' => ServiceServer::class,
        'port'    => 9503,
    ],
    'wsServer'   => [
        'class'   => WebSocketServer::class,
        'on'      => [
            // Enable http handle
            SwooleEvent::REQUEST => bean(RequestListener::class),
        ],
        'debug' => env('SWOFT_DEBUG', 0),
        /* @see WebSocketServer::$setting */
        'setting' => [
            'log_file' => alias('@runtime/swoole.log'),
        ],
    ],
    'consulProvider' => [ //自定义consul服务发现提供者

        'class' => \App\Components\Consul\ConsulProvider::class,
    ],
];
