<?php namespace Aliyun\OSS\Test;

use Aliyun\OSS\Core\Exception;
use Aliyun\OSS\Model\LoggingConfig;

class OSSClientBucketLoggingTest extends TestOSSClientBase
{

    public function testBucket()
    {
        $loggingConfig = new LoggingConfig($this->bucket, 'prefix');
        try {
            $this->ossClient->putBucketLogging($this->bucket, $this->bucket, 'prefix');
        } catch (Exception $e) {
            var_dump($e->getMessage());
            $this->assertTrue(false);
        }
        try {
            sleep(2);
            $loggingConfig2 = $this->ossClient->getBucketLogging($this->bucket);
            $this->assertEquals($loggingConfig->serializeToXml(), $loggingConfig2->serializeToXml());
        } catch (Exception $e) {
            $this->assertTrue(false);
        }
        try {
            $this->ossClient->deleteBucketLogging($this->bucket);
        } catch (Exception $e) {
            $this->assertTrue(false);
        }
        try {
            sleep(3);
            $loggingConfig3 = $this->ossClient->getBucketLogging($this->bucket);
            $this->assertNotEquals($loggingConfig->serializeToXml(), $loggingConfig3->serializeToXml());
        } catch (Exception $e) {
            $this->assertTrue(false);
        }
    }
}
