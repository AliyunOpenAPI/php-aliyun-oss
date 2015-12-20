<?php namespace Aliyun\OSS\Test;

use Aliyun\OSS\Core\MimeTypes;

class MimeTypesTest extends \PHPUnit_Framework_TestCase
{

    public function testGetMimeType()
    {
        $this->assertEquals('application/xml', MimeTypes::getMimetype('file.xml'));
    }
}
