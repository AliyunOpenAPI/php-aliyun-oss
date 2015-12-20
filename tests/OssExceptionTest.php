<?php namespace Aliyun\OSS\Test;

use Aliyun\OSS\Core\Exception;

class OSSExceptionTest extends \PHPUnit_Framework_TestCase
{

    public function testOSS_exception()
    {
        try {
            throw new OSSException("ERR");
            $this->assertTrue(false);
        } catch (Exception $e) {
            $this->assertNotNull($e);
            $this->assertEquals($e->getMessage(), "ERR");
        }
    }
}
