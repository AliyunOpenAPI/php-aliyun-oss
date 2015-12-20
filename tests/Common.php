<?php namespace Aliyun\OSS\Test;

use Aliyun\OSS\Core\OSSException;
use Aliyun\OSS\OSSClient;

/**
 * Class Common
 *
 * 示例程序【Samples/*.php】 的Common类，用于获取OSSClient实例和其他公用方法
 */
class Common
{

    const endpoint = Config::OSS_ENDPOINT;
    const accessKeyId = Config::OSS_ACCESS_ID;
    const accessKeySecret = Config::OSS_ACCESS_KEY;
    const bucket = Config::OSS_TEST_BUCKET;


    /**
     * 工具方法，创建一个bucket
     */
    public static function createBucket()
    {
        $ossClient = self::getOSSClient();
        if (is_null($ossClient)) {
            exit( 1 );
        }
        $bucket = self::getBucketName();
        $acl    = OSSClient::OSS_ACL_TYPE_PUBLIC_READ;
        try {
            $ossClient->createBucket($bucket, $acl);
        } catch (OSSException $e) {
            printf(__FUNCTION__ . ": FAILED\n");
            printf($e->getMessage() . "\n");

            return;
        }
        print( __FUNCTION__ . ": OK" . "\n" );
    }


    /**
     * 根据Config配置，得到一个OSSClient实例
     *
     * @return OSSClient 一个OSSClient实例
     */
    public static function getOSSClient()
    {
        try {
            $ossClient = new OSSClient(self::accessKeyId, self::accessKeySecret, self::endpoint, false);
        } catch (OSSException $e) {
            printf(__FUNCTION__ . "creating OSSClient instance: FAILED\n");
            printf($e->getMessage() . "\n");

            return null;
        }

        return $ossClient;
    }


    public static function getBucketName()
    {
        return self::bucket;
    }
}
