<?php declare(strict_types=1);

namespace Swoft\WebSocket\Server\Annotation\Parser;

use Swoft\Annotation\Annotation\Mapping\AnnotationParser;
use Swoft\Annotation\Annotation\Parser\Parser;
use Swoft\Annotation\Exception\AnnotationException;
use Swoft\Bean\Annotation\Mapping\Bean;
use Swoft\WebSocket\Server\Annotation\Mapping\WsController;
use Swoft\WebSocket\Server\Router\RouteRegister;

/**
 * Class WebSocketParser
 *
 * @since 2.0
 *
 * @AnnotationParser(WsController::class)
 */
class WsControllerParser extends Parser
{
    /**
     * Parse object
     *
     * @param int          $type       Class or Method or Property
     * @param WsController $annotation Annotation object
     *
     * @return array
     * Return empty array is nothing to do!
     * When class type return [$beanName, $className, $scope, $alias, $size] is to inject bean
     * When property type return [$propertyValue, $isRef] is to reference value
     * @throws AnnotationException
     */
    public function parse(int $type, $annotation): array
    {
        if ($type !== self::TYPE_CLASS) {
            throw new AnnotationException('`@WsController` must be defined on class!');
        }

        $class = $this->className;

        RouteRegister::bindController($class, $annotation->getPrefix());

        return [$class, $class, Bean::SINGLETON, ''];
    }
}
