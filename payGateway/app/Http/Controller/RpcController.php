<?php declare(strict_types=1);


namespace App\Http\Controller;

use App\Rpc\Lib\PayInterface;
use App\Rpc\Lib\UserInterface;
use Exception;
use Swoft\Http\Message\Request;
use Swoft\Http\Server\Annotation\Mapping\Controller;
use Swoft\Http\Server\Annotation\Mapping\RequestMapping;
use Swoft\Rpc\Client\Annotation\Mapping\Reference;
use Swoft\Http\Server\Annotation\Mapping\RequestMethod;
/**
 * Class RpcController
 *
 * @since 2.0
 * @Controller(prefix="test")
 */
class RpcController
{
    /**
     * @Reference(pool="user.pool")
     *
     * @var UserInterface
     */
    private $userService;

    /**
     * @Reference(pool="user.pool", version="1.2")
     *
     * @var UserInterface
     */
    private $userService2;

    /**
     * 在程序初始化的时候定义好服务降级处理类
     * @\Six\Rpc\Client\Annotation\Mapping\Reference(pool="pay.pool" , fallback="payFallback")
     *
     * @var PayInterface
     */
    private $payService;

    /**
     * @RequestMapping("getList")
     *
     * @return array
     */
    public function getList(): array
    {
        $result  = $this->userService->getList(12, 'type');
        $result2 = $this->userService2->getList(12, 'type');

        return [$result, $result2];
    }


    /**
     * 路由默认支持的方法为：POST,GET
     * @RequestMapping(route="pay[/{order_id}]")
     * @RequestMapping(method={RequestMethod::POST,RequestMethod::GET})
     * @param Request $request
     * @return array
     */
    public function pay(Request $request): array
    {
        $result = $this->payService->pay();
        var_dump($request->get('order_id'));
        return [$result];
    }

    /**
     * @RequestMapping("returnBool")
     *
     * @return array
     */
    public function returnBool(): array
    {
        $result = $this->userService->delete(12);

        if (is_bool($result)) {
            return ['bool'];
        }

        return ['notBool'];
    }

    /**
     * @RequestMapping()
     *
     * @return array
     */
    public function bigString(): array
    {
        $this->userService->getBigContent();

        return ['string'];
    }

    /**
     * @RequestMapping()
     *
     * @return array
     *
     * @throws Exception
     */
    public function exception(): array
    {
        $this->userService->exception();

        return ['exception'];
    }
}