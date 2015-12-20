<?php namespace Aliyun\OSS\Test;

use Aliyun\OSS\Core\OSSException;
use Aliyun\OSS\Model\WebsiteConfig;

class OSSClientBucketWebsiteTest extends TestOSSClientBase
{

    public function testBucket()
    {

        $websiteConfig = new WebsiteConfig("index.html", "error.html");

        try {
            $this->ossClient->putBucketWebsite($this->bucket, $websiteConfig);
        } catch (OSSException $e) {
            var_dump($e->getMessage());
            $this->assertTrue(false);
        }

        try {
            sleep(2);
            $websiteConfig2 = $this->ossClient->getBucketWebsite($this->bucket);
            $this->assertEquals($websiteConfig->serializeToXml(), $websiteConfig2->serializeToXml());
        } catch (OSSException $e) {
            $this->assertTrue(false);
        }
        try {
            $this->ossClient->deleteBucketWebsite($this->bucket);
        } catch (OSSException $e) {
            $this->assertTrue(false);
        }
        try {
            sleep(1);
            $websiteConfig3 = $this->ossClient->getBucketLogging($this->bucket);
            $this->assertNotEquals($websiteConfig->serializeToXml(), $websiteConfig3->serializeToXml());
        } catch (OSSException $e) {
            $this->assertTrue(false);
        }
    }
}
