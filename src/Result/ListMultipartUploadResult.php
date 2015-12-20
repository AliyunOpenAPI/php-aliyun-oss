<?php namespace Aliyun\OSS\Result;

use Aliyun\OSS\Core\Util;
use Aliyun\OSS\Model\ListMultipartUploadInfo;
use Aliyun\OSS\Model\UploadInfo;

/**
 * Class ListMultipartUploadResult
 * @package OSS\Result
 */
class ListMultipartUploadResult extends Result
{

    /**
     * 解析从ListMultipartUpload接口的返回数据
     *
     * @return ListMultipartUploadInfo
     */
    protected function parseDataFromResponse()
    {
        $content = $this->rawResponse->body;
        $xml     = simplexml_load_string($content);

        $encodingType       = isset( $xml->EncodingType ) ? strval($xml->EncodingType) : "";
        $bucket             = isset( $xml->Bucket ) ? strval($xml->Bucket) : "";
        $keyMarker          = isset( $xml->KeyMarker ) ? strval($xml->KeyMarker) : "";
        $keyMarker          = Util::decodeKey($keyMarker, $encodingType);
        $uploadIdMarker     = isset( $xml->UploadIdMarker ) ? strval($xml->UploadIdMarker) : "";
        $nextKeyMarker      = isset( $xml->NextKeyMarker ) ? strval($xml->NextKeyMarker) : "";
        $nextKeyMarker      = Util::decodeKey($nextKeyMarker, $encodingType);
        $nextUploadIdMarker = isset( $xml->NextUploadIdMarker ) ? strval($xml->NextUploadIdMarker) : "";
        $delimiter          = isset( $xml->Delimiter ) ? strval($xml->Delimiter) : "";
        $delimiter          = Util::decodeKey($delimiter, $encodingType);
        $prefix             = isset( $xml->Prefix ) ? strval($xml->Prefix) : "";
        $prefix             = Util::decodeKey($prefix, $encodingType);
        $maxUploads         = isset( $xml->MaxUploads ) ? intval($xml->MaxUploads) : 0;
        $isTruncated        = isset( $xml->IsTruncated ) ? strval($xml->IsTruncated) : "";
        $listUpload         = array();

        if (isset( $xml->Upload )) {
            foreach ($xml->Upload as $upload) {
                $key          = isset( $upload->Key ) ? strval($upload->Key) : "";
                $key          = Util::decodeKey($key, $encodingType);
                $uploadId     = isset( $upload->UploadId ) ? strval($upload->UploadId) : "";
                $initiated    = isset( $upload->Initiated ) ? strval($upload->Initiated) : "";
                $listUpload[] = new UploadInfo($key, $uploadId, $initiated);
            }
        }

        return new ListMultipartUploadInfo($bucket, $keyMarker, $uploadIdMarker, $nextKeyMarker, $nextUploadIdMarker, $delimiter, $prefix, $maxUploads, $isTruncated, $listUpload);
    }
}