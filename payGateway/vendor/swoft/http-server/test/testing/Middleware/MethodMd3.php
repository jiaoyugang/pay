<?php declare(strict_types=1);


namespace SwoftTest\Http\Server\Testing\Middleware;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Swoft\Bean\Annotation\Mapping\Bean;
use Swoft\Http\Server\Contract\MiddlewareInterface;

/**
 * Class MethodMd3
 *
 * @since 2.0
 *
 * @Bean()
 */
class MethodMd3 implements MiddlewareInterface
{
    /**
     * @param ServerRequestInterface  $request
     * @param RequestHandlerInterface $handler
     *
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $response = $handler->handle($request)->withAddedHeader('Method-md3', 'ok');
        return $response;
    }
}