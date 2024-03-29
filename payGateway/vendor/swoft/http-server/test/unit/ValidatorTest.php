<?php declare(strict_types=1);


namespace SwoftTest\Http\Server\Unit;

use Swoft\Bean\Exception\ContainerException;
use SwoftTest\Http\Server\Testing\MockRequest;

/**
 * Class ValidatorTest
 *
 * @since 2.0
 */
class ValidatorTest extends TestCase
{
    /**
     * @throws \ReflectionException
     * @throws ContainerException
     */
    public function testDefaultValidator()
    {
        $data     = [
            'string' => 'string',
            'int'    => 1,
            'float'  => 1.2,
            'bool'   => true,
            'array'  => [
                'array'
            ]
        ];
        $response = $this->mockServer->request(MockRequest::POST, '/testValidator/defautValidator');
        $response->assertEqualJson($data);
    }

    /**
     * @throws \ReflectionException
     * @throws ContainerException
     */
    public function testFailUserValidator()
    {
        $data     = [
            'start' => 12,
            'end'   => 10
        ];
        $response = $this->mockServer->request(MockRequest::POST, '/testValidator/userValidator', $data);
        $response->assertContainContent('Start(f79408e5ca998cd53faf44af31e6eb45) must less than end');
    }

    /**
     * @throws \ReflectionException
     * @throws ContainerException
     */
    public function testUserValidator()
    {
        $data     = [
            'start'  => 12,
            'end'    => 16,
            'params' => [1, 2]
        ];
        $response = $this->mockServer->request(MockRequest::POST, '/testValidator/userValidator', $data);
        $response->assertEqualJson($data);
    }


    /**
     * @throws \ReflectionException
     * @throws ContainerException
     */
    public function testDefaultValidatorQuery()
    {
        $data     = [
            'string' => 'string',
            'int'    => 1,
            'float'  => 1.2,
            'bool'   => true,
            'array'  => [
                'array'
            ]
        ];
        $response = $this->mockServer->request(MockRequest::GET, '/testValidator/defaultValidatorQuery');
        $response->assertEqualJson($data);
    }

    /**
     * @throws \ReflectionException
     * @throws ContainerException
     */
    public function testFailUserValidatorQuery()
    {
        $data     = [
            'start' => 12,
            'end'   => 10
        ];
        $response = $this->mockServer->request(MockRequest::GET, '/testValidator/userValidatorQuery', $data);
        $response->assertContainContent('Start(f79408e5ca998cd53faf44af31e6eb45) must less than end');
    }

    /**
     * @throws \ReflectionException
     * @throws ContainerException
     */
    public function testUserValidatorQuery()
    {
        $data     = [
            'start'  => 12,
            'end'    => 16,
            'params' => [1, 2]
        ];
        $response = $this->mockServer->request(MockRequest::GET, '/testValidator/userValidatorQuery', $data);
        $response->assertEqualJson($data);
    }
}