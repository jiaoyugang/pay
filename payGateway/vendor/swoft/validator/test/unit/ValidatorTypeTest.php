<?php declare(strict_types=1);


namespace SwoftTest\Validator\Unit;


use PHPUnit\Framework\TestCase;
use Swoft\Bean\Exception\ContainerException;
use Swoft\Validator\Validator;
use SwoftTest\Validator\Testing\ValidateDemo;
use Swoft\Validator\Exception\ValidatorException;

/**
 * Class ValidatorTypeTest
 *
 * @since 2.0
 */
class ValidatorTypeTest extends TestCase
{
    /**
     * @expectedException Swoft\Validator\Exception\ValidatorException
     * @expectedExceptionMessage array must exist!
     *
     * @throws ContainerException
     * @throws ValidatorException
     * @throws \ReflectionException
     */
    public function testArrayType()
    {
        $data = [];
        (new Validator())->validate($data, ValidateDemo::class, 'testArray');
    }

    /**
     * @expectedException Swoft\Validator\Exception\ValidatorException
     * @expectedExceptionMessage int must exist!
     *
     * @throws ValidatorException
     */
    public function testIntType()
    {
        $data = [];
        (new Validator())->validate($data, ValidateDemo::class, 'testInt');
    }

    /**
     * @expectedException Swoft\Validator\Exception\ValidatorException
     * @expectedExceptionMessage bool must exist!
     *
     * @throws ValidatorException
     */
    public function testBoolType()
    {
        $data = [];
        (new Validator())->validate($data, ValidateDemo::class, 'testBool');
    }

    /**
     * @expectedException Swoft\Validator\Exception\ValidatorException
     * @expectedExceptionMessage string must exist!
     *
     * @throws ValidatorException
     */
    public function testStringType()
    {
        $data = [];
        (new Validator())->validate($data, ValidateDemo::class, 'testString');
    }

    /**
     * @expectedException Swoft\Validator\Exception\ValidatorException
     * @expectedExceptionMessage float must exist!
     *
     * @throws ValidatorException
     */
    public function testFloatType()
    {
        $data = [];
        (new Validator())->validate($data, ValidateDemo::class, 'testFloat');
    }

    /**
     * @expectedException Swoft\Validator\Exception\ValidatorException
     * @expectedExceptionMessage array message
     *
     * @throws ValidatorException
     */
    public function testArrayTypeMessage()
    {
        $data = [];
        (new Validator())->validate($data, ValidateDemo::class, 'testArrayMessage');
    }

    /**
     * @expectedException Swoft\Validator\Exception\ValidatorException
     * @expectedExceptionMessage int message
     *
     * @throws ValidatorException
     */
    public function testIntTypeMessage()
    {
        $data = [];
        (new Validator())->validate($data, ValidateDemo::class, 'testIntMessage');
    }

    /**
     * @expectedException Swoft\Validator\Exception\ValidatorException
     * @expectedExceptionMessage bool message
     *
     * @throws ValidatorException
     */
    public function testBoolTypeMessage()
    {
        $data = [];
        (new Validator())->validate($data, ValidateDemo::class, 'testBoolMessage');
    }

    /**
     * @expectedException Swoft\Validator\Exception\ValidatorException
     * @expectedExceptionMessage string message
     *
     * @throws ValidatorException
     */
    public function testStringTypeMessage()
    {
        $data = [];
        (new Validator())->validate($data, ValidateDemo::class, 'testStringMessage');
    }

    /**
     * @expectedException Swoft\Validator\Exception\ValidatorException
     * @expectedExceptionMessage float message
     *
     * @throws ValidatorException
     */
    public function testFloatTypeMessage()
    {
        $data = [];
        (new Validator())->validate($data, ValidateDemo::class, 'testFloatMessage');
    }

    /**
     * @throws ValidatorException
     */
    public function testDefault()
    {
        $data = [];
        [$data] = (new Validator())->validate($data, ValidateDemo::class, 'testTypeDefault');

        $result = [
            'arrayDefault'  => [],
            'stringDefault' => '',
            'intDefault'    => 6,
            'boolDefault'   => false,
            'floatDefault'  => 1.0,
        ];
        $this->assertEquals($data, $result);
    }

    /**
     * @throws ValidatorException
     * @throws \ReflectionException
     * @throws ContainerException
     */
    public function testName(){
        $data = [];
        [$result] = (new Validator())->validate($data, ValidateDemo::class, 'testName');
        $this->assertEquals($result, ['swoftName' => 'swoft']);
    }

    /**
     * @expectedException Swoft\Validator\Exception\ValidatorException
     * @expectedExceptionMessage swoftName must string!
     *
     * @throws ContainerException
     * @throws ValidatorException
     * @throws \ReflectionException
     */
    public function testFailName(){
        $data = [
            'swoftName' => 12
        ];
        (new Validator())->validate($data, ValidateDemo::class, 'testName');
    }


    /**
     * @expectedException Swoft\Validator\Exception\ValidatorException
     * @expectedExceptionMessage int must exist!
     *
     * @throws ValidatorException
     */
    public function testIntTypeQuery()
    {
        $data = [
            'int' => 1,
        ];
        (new Validator())->validate($data, ValidateDemo::class, 'testIntQuery');
    }

    /**
     * @expectedException Swoft\Validator\Exception\ValidatorException
     * @expectedExceptionMessage bool must exist!
     *
     * @throws ValidatorException
     */
    public function testBoolTypeQuery()
    {
        $data = [
            'bool' => false
        ];
        (new Validator())->validate($data, ValidateDemo::class, 'testBoolQuery');
    }

    /**
     * @expectedException Swoft\Validator\Exception\ValidatorException
     * @expectedExceptionMessage string must exist!
     *
     * @throws ValidatorException
     */
    public function testStringTypeQuery()
    {
        $data = [
            'string' => 'string'
        ];
        (new Validator())->validate($data, ValidateDemo::class, 'testStringQuery');
    }

    /**
     * @expectedException Swoft\Validator\Exception\ValidatorException
     * @expectedExceptionMessage float must exist!
     *
     * @throws ValidatorException
     */
    public function testFloatTypeQuery()
    {
        $data = [
            'float' => 1.1
        ];
        (new Validator())->validate($data, ValidateDemo::class, 'testFloatQuery');
    }

    /**
     * @throws ContainerException
     * @throws ValidatorException
     * @throws \ReflectionException
     */
    public function testFloatTypeQuery2()
    {
        $query = [
            'float' => '2.2'
        ];
        [,$result] = (new Validator())->validate([], ValidateDemo::class, 'testFloatQuery', $query);

        $this->assertEquals($result, ['float' => 2.2]);
    }
}