<?php
/**
 * consul服务配置文件
 *
 * */

return [
    'consul' => [
        'address' => '127.0.0.1', //consul服务地址
        'port'    => 8500,  //指定consul服务的端口号
        'register' => [
            'ID'                =>'pay',
            'Name'              =>'pay-php',
            'Tags'              =>['primary'],
            'Address'           =>'192.168.2.251',  //注册服务的IP
            'Port'              =>9501, //注册服务的port
            'Check'             => [ //指定检查服务状态的相关参数
                'tcp'      => '192.168.2.251:9501',  //http形式的请求
                'interval' => '5s', //检查时间
                'timeout'  => '2s',
            ],
            'Weights' => [
                'passing' => 5,
                'warning' => 1
            ]
        ],
        'discovery' => [
            'name' => 'user',
            'dc' => 'dc'
        ]
    ],
];