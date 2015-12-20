<?php namespace Aliyun\OSS\Test;

use Aliyun\OSS\Core\Exception;
use Aliyun\OSS\Core\Util;

class OSSUtilTest extends \PHPUnit_Framework_TestCase
{

    public function testIsChinese()
    {
        $this->assertEquals(Util::chkChinese("hello,world"), 0);
        $str    = '你好,这里是卖咖啡!';
        $strGBK = Util::encodePath($str);
        $this->assertEquals(Util::chkChinese($str), 1);
        $this->assertEquals(Util::chkChinese($strGBK), 1);
    }


    public function testIsGB2312()
    {
        $str = '你好,这里是卖咖啡!';
        $this->assertFalse(Util::isGb2312($str));
    }


    public function testCheckChar()
    {
        $str = '你好,这里是卖咖啡!';
        $this->assertFalse(Util::checkChar($str));
        $this->assertTrue(Util::checkChar(iconv("UTF-8", "GB2312//IGNORE", $str)));
    }


    public function testIsIpFormat()
    {
        $this->assertTrue(Util::isIPFormat("10.101.160.147"));
        $this->assertTrue(Util::isIPFormat("12.12.12.34"));
        $this->assertTrue(Util::isIPFormat("12.12.12.12"));
        $this->assertTrue(Util::isIPFormat("255.255.255.255"));
        $this->assertTrue(Util::isIPFormat("0.1.1.1"));
        $this->assertFalse(Util::isIPFormat("0.1.1.x"));
        $this->assertFalse(Util::isIPFormat("0.1.1.256"));
        $this->assertFalse(Util::isIPFormat("256.1.1.1"));
        $this->assertFalse(Util::isIPFormat("0.1.1.0.1"));
        $this->assertTrue(Util::isIPFormat("10.10.10.10:123"));
    }


    public function testToQueryString()
    {
        $option = array( "a" => "b" );
        $this->assertEquals('a=b', Util::toQueryString($option));
    }


    public function testSReplace()
    {
        $str = "<>&'\"";
        $this->assertEquals("&amp;lt;&amp;gt;&amp;&apos;&quot;", Util::sReplace($str));
    }


    public function testCheckChinese()
    {
        $str = '你好,这里是卖咖啡!';
        $this->assertEquals(Util::chkChinese($str), 1);
        $strGB = Util::encodePath($str);
        $this->assertEquals($str, iconv("GB2312", "UTF-8", $strGB));
    }


    public function testValidateOption()
    {
        $option = 'string';

        try {
            Util::validateOptions($option);
            $this->assertFalse(true);
        } catch (Exception $e) {
            $this->assertEquals("string:option must be array", $e->getMessage());
        }

        $option = null;

        try {
            Util::validateOptions($option);
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->assertFalse(true);
        }

    }


    public function testCreateDeleteObjectsXmlBody()
    {
        $xml = <<<BBBB
<?xml version="1.0" encoding="utf-8"?><Delete><Quiet>true</Quiet><Object><Key>obj1</Key></Object></Delete>
BBBB;
        $a   = array( 'obj1' );
        $this->assertEquals($xml, $this->cleanXml(Util::createDeleteObjectsXmlBody($a, 'true')));
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
        $this->assertEquals($this->cleanXml(Util::createCompleteMultipartUploadXmlBody($a)), $xml);
    }


    public function testValidateBucket()
    {
        $this->assertTrue(Util::validateBucket("xxx"));
        $this->assertFalse(Util::validateBucket("XXXqwe123"));
        $this->assertFalse(Util::validateBucket("XX"));
        $this->assertFalse(Util::validateBucket("/X"));
        $this->assertFalse(Util::validateBucket(""));
    }


    public function testValidateObject()
    {
        $this->assertTrue(Util::validateObject("xxx"));
        $this->assertTrue(Util::validateObject("xxx23"));
        $this->assertTrue(Util::validateObject("12321-xxx"));
        $this->assertTrue(Util::validateObject("x"));
        $this->assertFalse(Util::validateObject("/aa"));
        $this->assertFalse(Util::validateObject("\\aa"));
        $this->assertFalse(Util::validateObject(""));
    }


    public function testStartWith()
    {
        $this->assertTrue(Util::startsWith("xxab", "xx"), true);
    }


    public function testReadDir()
    {
        $list = Util::readDir("./src", ".|..|.svn|.git", true);
        $this->assertNotNull($list);
    }


    public function testIsWin()
    {
        //$this->assertTrue(OSSUtil::isWin());
    }


    public function testGetMd5SumForFile()
    {
        $this->assertEquals(Util::getMd5SumForFile(__FILE__, 0, filesize(__FILE__) - 1), base64_encode(md5(file_get_contents(__FILE__), true)));
    }


    public function testGenerateFile()
    {
        $path = __DIR__ . DIRECTORY_SEPARATOR . "generatedFile.txt";
        Util::generateFile($path, 1024 * 1024);
        $this->assertEquals(filesize($path), 1024 * 1024);
        unlink($path);
    }


    public function testThrowOSSExceptionWithMessageIfEmpty()
    {
        $null = null;
        try {
            Util::throwOSSExceptionWithMessageIfEmpty($null, "xx");
            $this->assertTrue(false);
        } catch (Exception $e) {
            $this->assertEquals('xx', $e->getMessage());
        }
    }


    public function testThrowOSSExceptionWithMessageIfEmpty2()
    {
        $null = "";
        try {
            Util::throwOSSExceptionWithMessageIfEmpty($null, "xx");
            $this->assertTrue(false);
        } catch (Exception $e) {
            $this->assertEquals('xx', $e->getMessage());
        }
    }


    public function testValidContent()
    {
        $null = "";
        try {
            Util::validateContent($null);
            $this->assertTrue(false);
        } catch (Exception $e) {
            $this->assertEquals('http body content is invalid', $e->getMessage());
        }

        $notnull = "x";
        try {
            Util::validateContent($notnull);
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->assertEquals('http body content is invalid', $e->getMessage());
        }
    }


    public function testThrowOSSExceptionWithMessageIfEmpty3()
    {
        $null = "xx";
        try {
            Util::throwOSSExceptionWithMessageIfEmpty($null, "xx");
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->assertTrue(false);
        }
    }
}
