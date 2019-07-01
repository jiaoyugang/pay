<?php declare(strict_types=1);


namespace App\Rpc\Service;

use App\Rpc\Lib\PayInterface;
use Swoft\Rpc\Server\Annotation\Mapping\Service;

/**
 * Class UserService
 *
 * @since 2.0
 *
 * @Service()
 */
class PayService implements PayInterface
{
    /**
     *
     * @return array
     */
    public function pay(): array
    {
        return ['name' => ['swoft-new']];
    }

}