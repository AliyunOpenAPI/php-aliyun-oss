<?php namespace Aliyun\OSS\Test;

use Aliyun\OSS\Core\OSSException;
use Aliyun\OSS\Core\OSSUtil;

class OSSUtilTest extends \PHPUnit_Framework_TestCase
{

    public function testIsChinese()
    {
        $this->assertEquals(OSSUtil::chkChinese("hello,world"), 0);
        $str    = '你好,这里是卖咖啡!';
        $strGBK = OSSUtil::encodePath($str);
        $this->assertEquals(OSSUtil::chkChinese($str), 1);
        $this->assertEquals(OSSUtil::chkChinese($strGBK), 1);
    }


    public function testIsGB2312()
    {
        $str = '你好,这里是卖咖啡!';
        $this->assertFalse(OSSUtil::isGb2312($str));
    }


    public function testCheckChar()
    {
        $str = '你好,这里是卖咖啡!';
        $this->assertFalse(OSSUtil::checkChar($str));
        $this->assertTrue(OSSUtil::checkChar(iconv("UTF-8", "GB2312//IGNORE", $str)));
    }


    public function testIsIpFormat()
    {
        $this->assertTrue(OSSUtil::isIPFormat("10.101.160.147"));
        $this->assertTrue(OSSUtil::isIPFormat("12.12.12.34"));
        $this->assertTrue(OSSUtil::isIPFormat("12.12.12.12"));
        $this->assertTrue(OSSUtil::isIPFormat("255.255.255.255"));
        $this->assertTrue(OSSUtil::isIPFormat("0.1.1.1"));
        $this->assertFalse(OSSUtil::isIPFormat("0.1.1.x"));
        $this->assertFalse(OSSUtil::isIPFormat("0.1.1.256"));
        $this->assertFalse(OSSUtil::isIPFormat("256.1.1.1"));
        $this->assertFalse(OSSUtil::isIPFormat("0.1.1.0.1"));
        $this->assertTrue(OSSUtil::isIPFormat("10.10.10.10:123"));
    }


    public function testToQueryString()
    {
        $option = array( "a" => "b" );
        $this->assertEquals('a=b', OSSUtil::toQueryString($option));
    }


    public function testSReplace()
    {
        $str = "<>&'\"";
        $this->assertEquals("&amp;lt;&amp;gt;&amp;&apos;&quot;", OSSUtil::sReplace($str));
    }


    public function testCheckChinese()
    {
        $str = '你好,这里是卖咖啡!';
        $this->assertEquals(OSSUtil::chkChinese($str), 1);
        $strGB = OSSUtil::encodePath($str);
        $this->assertEquals($str, iconv("GB2312", "UTF-8", $strGB));
    }


    public function testValidateOption()
    {
        $option = 'string';

        try {
            OSSUtil::validateOptions($option);
            $this->assertFalse(true);
        } catch (OSSException $e) {
            $this->assertEquals("string:option must be array", $e->getMessage());
        }

        $option = null;

        try {
            OSSUtil::validateOptions($option);
            $this->assertTrue(true);
        } catch (OSSException $e) {
            $this->assertFalse(true);
        }

    }


    public function testCreateDeleteObjectsXmlBody()
    {
        $xml = <<<BBBB
<?xml version="1.0" encoding="utf-8"?><Delete><Quiet>true</Quiet><Object><Key>obj1</Key></Object></Delete>
BBBB;
        $a   = array( 'obj1' );
        $this->assertEquals($xml, $this->cleanXml(OSSUtil::createDeleteObjectsXmlBody($a, 'true')));
    }


    private function cleanXml($xml)
    {
        return str_replace("\n", "", str_replace("\r", "", $xml));
    }


    public function testCreateCompleteMultipartUploadXmlBody()
    {
        $xml = <<<BBBB
<?xml version="1.0" encoding="utf-8"?><CompleteMultipartUpload><Part><PartNumber>2</PartNumber><ETag>xx</ETag></Part></CompleteMultipartUpload>
BBBB;
        $a   = array( array( "PartNumber" => 2, "ETag" => "xx" ) );
        $this->assertEquals($this->cleanXml(OSSUtil::createCompleteMultipartUploadXmlBody($a)), $xml);
    }


    public function testValidateBucket()
    {
        $this->assertTrue(OSSUtil::validateBucket("xxx"));
        $this->assertFalse(OSSUtil::validateBucket("XXXqwe123"));
        $this->assertFalse(OSSUtil::validateBucket("XX"));
        $this->assertFalse(OSSUtil::validateBucket("/X"));
        $this->assertFalse(OSSUtil::validateBucket(""));
    }


    public function testValidateObject()
    {
        $this->assertTrue(OSSUtil::validateObject("xxx"));
        $this->assertTrue(OSSUtil::validateObject("xxx23"));
        $this->assertTrue(OSSUtil::validateObject("12321-xxx"));
        $this->assertTrue(OSSUtil::validateObject("x"));
        $this->assertFalse(OSSUtil::validateObject("/aa"));
        $this->assertFalse(OSSUtil::validateObject("\\aa"));
        $this->assertFalse(OSSUtil::validateObject(""));
    }


    public function testStartWith()
    {
        $this->assertTrue(OSSUtil::startsWith("xxab", "xx"), true);
    }


    public function testReadDir()
    {
        $list = OSSUtil::readDir("./src", ".|..|.svn|.git", true);
        $this->assertNotNull($list);
    }


    public function testIsWin()
    {
        //$this->assertTrue(OSSUtil::isWin());
    }


    public function testGetMd5SumForFile()
    {
        $this->assertEquals(OSSUtil::getMd5SumForFile(__FILE__, 0, filesize(__FILE__) - 1), base64_encode(md5(file_get_contents(__FILE__), true)));
    }


    public function testGenerateFile()
    {
        $path = __DIR__ . DIRECTORY_SEPARATOR . "generatedFile.txt";
        OSSUtil::generateFile($path, 1024 * 1024);
        $this->assertEquals(filesize($path), 1024 * 1024);
        unlink($path);
    }


    public function testThrowOSSExceptionWithMessageIfEmpty()
    {
        $null = null;
        try {
            OSSUtil::throwOSSExceptionWithMessageIfEmpty($null, "xx");
            $this->assertTrue(false);
        } catch (OSSException $e) {
            $this->assertEquals('xx', $e->getMessage());
        }
    }


    public function testThrowOSSExceptionWithMessageIfEmpty2()
    {
        $null = "";
        try {
            OSSUtil::throwOSSExceptionWithMessageIfEmpty($null, "xx");
            $this->assertTrue(false);
        } catch (OSSException $e) {
            $this->assertEquals('xx', $e->getMessage());
        }
    }


    public function testValidContent()
    {
        $null = "";
        try {
            OSSUtil::validateContent($null);
            $this->assertTrue(false);
        } catch (OSSException $e) {
            $this->assertEquals('http body content is invalid', $e->getMessage());
        }

        $notnull = "x";
        try {
            OSSUtil::validateContent($notnull);
            $this->assertTrue(true);
        } catch (OSSException $e) {
            $this->assertEquals('http body content is invalid', $e->getMessage());
        }
    }


    public function testThrowOSSExceptionWithMessageIfEmpty3()
    {
        $null = "xx";
        try {
            OSSUtil::throwOSSExceptionWithMessageIfEmpty($null, "xx");
            $this->assertTrue(true);
        } catch (OSSException $e) {
            $this->assertTrue(false);
        }
    }
}
