<?php namespace Aliyun\OSS\Result;

use Aliyun\OSS\Core\Exception;
use Aliyun\OSS\Tests\OssExceptionTest;

/**
 * Class AclResult getBucketAcl接口返回结果类，封装了
 * 返回的xml数据的解析
 *
 * @package OSS\Result
 */
class AclResult extends Result
{

    /**
     * @return string
     * @throws Exception
     */
    protected function parseDataFromResponse()
    {
        $content = $this->rawResponse->body;
        if (empty( $content )) {
            throw new Exception("body is null");
        }
        $xml = simplexml_load_string($content);
        if (isset( $xml->AccessControlList->Grant )) {
            return strval($xml->AccessControlList->Grant);
        } else {
            throw new Exception("xml format exception");
        }
    }
}