<?php namespace Aliyun\OSS\Test;

require_once __DIR__ . '/../../../autoload.php';
require_once __DIR__ . '/Config.php';

use Aliyun\OSS\Core\OssException;
use Aliyun\OSS\OSSClient;

/**
 * Class Common
 *
 * 示例程序【Samples/*.php】 的Common类，用于获取OssClient实例和其他公用方法
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
        $ossClient = self::getOssClient();
        if (is_null($ossClient)) {
            exit( 1 );
        }
        $bucket = self::getBucketName();
        $acl    = OSSClient::OSS_ACL_TYPE_PUBLIC_READ;
        try {
            $ossClient->createBucket($bucket, $acl);
        } catch (OssException $e) {
            printf(__FUNCTION__ . ": FAILED\n");
            printf($e->getMessage() . "\n");

            return;
        }
        print( __FUNCTION__ . ": OK" . "\n" );
    }


    /**
     * 根据Config配置，得到一个OssClient实例
     *
     * @return OSSClient 一个OssClient实例
     */
    public static function getOssClient()
    {
        try {
            $ossClient = new OSSClient(self::accessKeyId, self::accessKeySecret, self::endpoint, false);
        } catch (OssException $e) {
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
