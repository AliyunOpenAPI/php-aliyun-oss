<?php namespace Aliyun\OSS\Test;

use Aliyun\OSS\Core\OSSException;

class OSSExceptionTest extends \PHPUnit_Framework_TestCase
{

    public function testOSS_exception()
    {
        try {
            throw new OSSException("ERR");
            $this->assertTrue(false);
        } catch (OSSException $e) {
            $this->assertNotNull($e);
            $this->assertEquals($e->getMessage(), "ERR");
        }
    }
}
