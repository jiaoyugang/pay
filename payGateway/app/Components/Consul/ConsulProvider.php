<?php declare(strict_types=1);

namespace App\Components\Consul;

class ConsulProvider
{


    const  REGISTER_PATH    =   '/v1/agent/service/register'; //consul服务注册地址:put

    const HEALTH_PATH       =   '/v1/health/service/'; //获取健康服务:get


    //获取服务列表:get
    const LIST_PATH         =   '/v1/agent/services';

    //consul服务状态
    const SERVER_STATE      =   '/v1/agent/checks';

    /**
     * 注册consul服务
     * @param    array   $config
     * */
    public function registerServer($config)
    {
        //env配置文件
        if(env('AUTOLOAD_REGISTER')){
//            echo 'http://'.$config['address'].':'.$config['port'].self::REGISTER_PATH.PHP_EOL;
//            echo json_encode($config['register']).PHP_EOL;
            //注册地址
            curl_request('http://'.$config['address'].':'.$config['port'].self::REGISTER_PATH , 'PUT' ,json_encode($config['register']));
            //打印log信息
            output()->writeln("<success>Rpc service Register success by consul tcp=" . $config['address'] . ":" . $config['port'] . "</success>");

        }
    }


    /**
     * 获取某个服务的列表
     * @param $serviceName
     * @param $config
     * @return array
     */
    public function getServerList($serviceName ,$config)
    {
//        echo 'http://'.$config['address'].':'.$config['port'].self::HEALTH_PATH.$serviceName.PHP_EOL;
        $serviceList = curl_request('http://'.$config['address'].':'.$config['port'].self::HEALTH_PATH.$serviceName , 'GET' );

        $serverAddr = [];
        $test = [];
        if($serviceList && is_array($serviceList)){
            $serviceList = json_decode($serviceList ,true);
            //组装活跃的服务的IP:port
            foreach ($serviceList as $k=>$v){
                //判断当前的服务是否是活跃的,并且是当前想要去查询服务
                $test[$k]['address']=$v['Service']['Address'].":".$v['Service']['Port'];
                $test[$k]['weight']=$v['Service']['Weights']['Passing'];
                foreach ($v['Checks'] as $c){
                    if($c['ServiceName']==$serviceName && $c['Status']=="passing"){
                        $serverAddr[$k]['address']=$v['Service']['Address'].":".$v['Service']['Port'];
                        $serverAddr[$k]['weight']=$v['Service']['Weights']['Passing'];
                    }
                }
            }
        }

//        var_dump('地址',$serverAddr);
        return $serverAddr;
    }


}