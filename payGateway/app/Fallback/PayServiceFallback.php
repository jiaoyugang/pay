<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/6/15 0015
 * Time: 下午 9:43
 */

namespace App\Fallback;


use App\Rpc\Lib\PayInterface;
use Six\Rpc\Client\Annotation\Mapping\Fallback;

/**
 * Class PayServiceFallback
 * @package App\Fallback
 * @Fallback(name="payFallback" , version="1.0")
 */
class PayServiceFallback implements PayInterface
{
    /**
     * 支付请求失败触发
     * @return array
     */
    public function pay(): array
    {
        // TODO: Implement pay() method.
        return ['降级处理:服务开小差了,请稍后再试...'];
    }
}