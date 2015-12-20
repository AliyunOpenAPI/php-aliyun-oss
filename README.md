Aliyun OSS SDK for PHP
======================

阿里云对象存储（Object Storage Service，简称OSS），是阿里云对外提供的海量、安全、低成本、高可靠的云存储服务。用户可以通过调用API，在任何应用、任何时间、任何地点上传和下载数据，也可以通过用户Web控制台对数据进行简单的管理。OSS适合存放任意文件类型，适合各种网站、开发企业及开发者使用。


## Installation

``` bash
$ composer require aliyuncs/oss-sdk-php
```

## Usage

``` php

$accessKeyId = "<your_access_key_id>"; ;
$accessKeySecret = "<your_access_key_secret>";
$endpoint = "http://oss-cn-hangzhou.aliyuncs.com";

$client = new OSSClient($accessKeyId, $accessKeySecret, $endpoint);

$bucket = "<your_bucket_name>";
$object = "doc/dest_demo_01.txt";
$content = "Hello, OSS!";

$client->putObject($bucket, $object, $content);
```

### Result

* Put，Delete类接口，接口返回null，如果没有Exception，即可认为操作成功
* Get，List类接口，接口返回对应的数据，如果没有Exception，即可认为操作成功


### Testing
```
composer test
```

## Contact

- [阿里云OSS官方网站](http://oss.aliyun.com)
- [阿里云OSS官方论坛](http://bbs.aliyun.com)
- [阿里云OSS官方文档中心](http://www.aliyun.com/product/oss#Docs)
- [阿里云官方技术支持](https://workorder.console.aliyun.com/#/ticket/createIndex)

[releases-page]: https://github.com/aliyun/aliyun-oss-php-sdk/releases
