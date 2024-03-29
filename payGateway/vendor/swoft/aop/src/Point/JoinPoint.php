<?php declare(strict_types=1);


namespace Swoft\Aop\Point;

use Swoft\Aop\AspectHandler;
use Swoft\Aop\Contract\JoinPointInterface;
use Throwable;

/**
 * Class JoinPoint
 *
 * @since 2.0
 */
class JoinPoint implements JoinPointInterface
{
    /**
     * @var array
     */
    protected $args = [];

    /**
     * @var object
     */
    protected $target;

    /**
     * @var mixed
     */
    protected $return;

    /**
     * @var string
     */
    protected $method;

    /**
     * @var Throwable
     */
    protected $catch;

    /**
     * @var AspectHandler
     */
    protected $handler;

    /**
     * JoinPoint constructor.
     *
     * @param object $target the object of origin
     * @param string $method the method of origin
     * @param array  $args   the params of method
     */
    public function __construct($target, string $method, array $args)
    {
        $this->args   = $args;
        $this->target = $target;
        $this->method = $method;
    }

    /**
     * @return array
     */
    public function getArgs(): array
    {
        return $this->args;
    }

    /**
     * @return object
     */
    public function getTarget()
    {
        return $this->target;
    }

    /**
     * @return mixed
     */
    public function getReturn()
    {
        return $this->return;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @return Throwable
     */
    public function getCatch(): Throwable
    {
        return $this->catch;
    }

    /**
     * @param mixed $return
     */
    public function setReturn($return): void
    {
        $this->return = $return;
    }

    /**
     * @param Throwable $catch
     */
    public function setCatch(Throwable $catch): void
    {
        $this->catch = $catch;
    }

    /**
     * @param AspectHandler $handler
     */
    public function setHandler(AspectHandler $handler): void
    {
        $this->handler = $handler;
    }
}