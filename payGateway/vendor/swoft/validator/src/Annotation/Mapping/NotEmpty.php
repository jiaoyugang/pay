<?php declare(strict_types=1);


namespace Swoft\Validator\Annotation\Mapping;

use Doctrine\Common\Annotations\Annotation\Attribute;
use Doctrine\Common\Annotations\Annotation\Attributes;
use Doctrine\Common\Annotations\Annotation\Target;

/**
 * Class NotEmpty
 *
 * @since 2.0
 *
 * @Annotation
 * @Target("PROPERTY")
 * @Attributes({
 *     @Attribute("message", type="string")
 * })
 */
class NotEmpty
{
    /**
     * @var string
     */
    private $message = '';

    /**
     * NotEmpty constructor.
     *
     * @param array $values
     */
    public function __construct(array $values)
    {
        if (isset($values['value'])) {
            $this->message = $values['value'];
        }
        if (isset($values['message'])) {
            $this->message = $values['message'];
        }
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }
}