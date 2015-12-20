<?php namespace Aliyun\OSS\Test;

use Aliyun\OSS\Core\OSSException;
use Aliyun\OSS\Http\ResponseCore;
use Aliyun\OSS\Result\PutSetDeleteResult;

class ResultTest extends \PHPUnit_Framework_TestCase
{

    public function testNullResponse()
    {
        $response = null;
        try {
            new PutSetDeleteResult($response);
            $this->assertFalse(true);
        } catch (OSSException $e) {
            $this->assertEquals('raw response is null', $e->getMessage());
        }
    }


    public function testOkResponse()
    {
        $response = new ResponseCore(array(), "", 200);
        $result   = new PutSetDeleteResult($response);
        $this->assertTrue($result->isOK());
        $this->assertNull($result->getData());
        $this->assertNotNull($result->getRawResponse());
    }


    public function testFailResponse()
    {
        $response = new ResponseCore(array(), "", 301);
        try {
            new PutSetDeleteResult($response);
            $this->assertFalse(true);
        } catch (OSSException $e) {

        }
    }


    public function setUp()
    {

    }


    public function tearDown()
    {

    }
}
