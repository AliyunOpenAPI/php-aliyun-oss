<?php namespace Aliyun\OSS\Result;

use Aliyun\OSS\Core\Exception;

/**
 * Class initiateMultipartUploadResult
 * @package OSS\Result
 */
class InitiateMultipartUploadResult extends Result
{

    /**
     * 结果中获取uploadId并返回
     *
     * @throws Exception
     * @return string
     */
    protected function parseDataFromResponse()
    {
        $content = $this->rawResponse->body;
        $xml     = simplexml_load_string($content);
        if (isset( $xml->UploadId )) {
            return strval($xml->UploadId);
        }
        throw new Exception("cannot get UploadId");
    }
}