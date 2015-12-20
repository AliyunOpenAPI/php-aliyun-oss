<?php namespace Aliyun\OSS\Test;

use Aliyun\OSS\Core\OssException;
use Aliyun\OSS\Model\LifecycleAction;
use Aliyun\OSS\Model\LifecycleConfig;
use Aliyun\OSS\Model\LifecycleRule;

require_once __DIR__ . DIRECTORY_SEPARATOR . 'TestOssClientBase.php';

class OssClientBucketLifecycleTest extends TestOssClientBase
{

    public function testBucket()
    {
        $lifecycleConfig = new LifecycleConfig();
        $actions         = array();
        $actions[]       = new LifecycleAction("Expiration", "Days", 3);
        $lifecycleRule   = new LifecycleRule("delete obsoleted files", "obsoleted/", "Enabled", $actions);
        $lifecycleConfig->addRule($lifecycleRule);
        $actions       = array();
        $actions[]     = new LifecycleAction("Expiration", "Date", '2022-10-12T00:00:00.000Z');
        $lifecycleRule = new LifecycleRule("delete temporary files", "temporary/", "Enabled", $actions);
        $lifecycleConfig->addRule($lifecycleRule);

        try {
            $this->ossClient->putBucketLifecycle($this->bucket, $lifecycleConfig);
        } catch (OssException $e) {
            $this->assertTrue(false);
        }

        try {
            sleep(5);
            $lifecycleConfig2 = $this->ossClient->getBucketLifecycle($this->bucket);
            $this->assertEquals($lifecycleConfig->serializeToXml(), $lifecycleConfig2->serializeToXml());
        } catch (OssException $e) {
            $this->assertTrue(false);
        }

        try {
            $this->ossClient->deleteBucketLifecycle($this->bucket);
        } catch (OssException $e) {
            $this->assertTrue(false);
        }

        try {
            sleep(3);
            $lifecycleConfig3 = $this->ossClient->getBucketLifecycle($this->bucket);
            $this->assertNotEquals($lifecycleConfig->serializeToXml(), $lifecycleConfig3->serializeToXml());
        } catch (OssException $e) {
            $this->assertTrue(false);
        }

    }
}
