<?php declare(strict_types=1);


namespace SwoftTest\Http\Server\Unit;


use Swoft\Http\Message\ContentType;

/**
 * Class ContentTypeTest
 *
 * @since 2.0
 */
class ContentTypeTest extends TestCase
{
    public function testUserCt()
    {
        $headers = [
            'accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3',
        ];

        $response = $this->mockServer->request('POST', '/ct/userCt', [], $headers);

        $response->assertEqualHeader(ContentType::KEY, $response->getHeaderKey(ContentType::KEY));
        $response->assertEqualContent('imag data content');
    }

    public function testUserCt2()
    {
        $headers = [
            'accept' => ContentType::XML,
        ];

        $response = $this->mockServer->request('POST', '/ct/userCt2', [], $headers);

        $response->assertEqualHeader(ContentType::KEY, $response->getHeaderKey(ContentType::KEY));
        $response->assertEqualContent('xml data content');

        $headers = [

        ];
    }

    public function testUserCt3()
    {
        $headers = [
            'accept' => ContentType::XML,
        ];

        $response = $this->mockServer->request('POST', '/ct/userCt3', [], $headers);

        $response->assertEqualHeader(ContentType::KEY, $response->getHeaderKey(ContentType::KEY));
        $response->assertEqualContent("<xml><key><![CDATA[data]]></key></xml>");


        $headers = [
        ];

        $response = $this->mockServer->request('POST', '/ct/userCt3', [], $headers);

        $response->assertEqualHeader(ContentType::KEY, $response->getHeaderKey(ContentType::KEY));
        $response->assertEqualJson(['key' => 'data']);
    }
}