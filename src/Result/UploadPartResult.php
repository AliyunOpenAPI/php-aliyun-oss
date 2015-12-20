<?php namespace Aliyun\OSS\Result;

use Aliyun\OSS\Core\Exception;

/**
 * Class UploadPartResult
 * @package OSS\Result
 */
class UploadPartResult extends Result
{

    /**
     * 结果中part的ETag
     *
     * @return string
     * @throws Exception
     */
    protected function parseDataFromResponse()
    {
        $header = $this->rawResponse->header;
        if (isset( $header["etag"] )) {
            return $header["etag"];
        }
        throw new Exception("cannot get ETag");

    }
}