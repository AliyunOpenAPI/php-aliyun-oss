<?php namespace Aliyun\OSS\Test;

use Aliyun\OSS\Core\Exception;
use Aliyun\OSS\OSSClient;

class OSSClientBucketTest extends TestOSSClientBase
{

    public function testBucketWithInvalidName()
    {
        try {
            $this->ossClient->createBucket("s");
            $this->assertFalse(true);
        } catch (Exception $e) {
            $this->assertEquals('"s"bucket name is invalid', $e->getMessage());
        }
    }


    public function testBucketWithInvalidACL()
    {
        try {
            $this->ossClient->createBucket($this->bucket, "invalid");
            $this->assertFalse(true);
        } catch (Exception $e) {
            $this->assertEquals('invalid:acl is invalid(private,public-read,public-read-write)', $e->getMessage());
        }
    }


    public function testBucket()
    {
        $this->ossClient->createBucket($this->bucket, OSSClient::OSS_ACL_TYPE_PUBLIC_READ_WRITE);

        $bucketListInfo = $this->ossClient->listBuckets();
        $this->assertNotNull($bucketListInfo);
        $bucketList = $bucketListInfo->getBucketList();
        $this->assertTrue(is_array($bucketList));
        $this->assertGreaterThan(0, count($bucketList));
        $this->ossClient->putBucketAcl($this->bucket, OSSClient::OSS_ACL_TYPE_PUBLIC_READ_WRITE);
        $this->assertEquals($this->ossClient->getBucketAcl($this->bucket), OSSClient::OSS_ACL_TYPE_PUBLIC_READ_WRITE);

        $this->assertTrue($this->ossClient->doesBucketExist($this->bucket));
        $this->assertFalse($this->ossClient->doesBucketExist($this->bucket . '-notexist'));

        try {
            $this->ossClient->deleteBucket($this->bucket);
        } catch (Exception $e) {
            $this->assertEquals("BucketNotEmpty", $e->getErrorCode());
            $this->assertEquals("409", $e->getHTTPStatus());
        }


    }
}
