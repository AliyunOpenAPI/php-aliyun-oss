Aliyun OSS SDK for PHP
======================

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Total Downloads][ico-downloads]][link-downloads]

Aliyun OSS SDK for PHP

## Installation

``` bash
$ composer require lokielse/aliyun-oss
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

### Testing
```
composer test
```

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/lokielse/aliyun-oss.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/lokielse/aliyun-oss/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/lokielse/aliyun-oss.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/lokielse/aliyun-oss.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/lokielse/aliyun-oss.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/lokielse/aliyun-oss
[link-travis]: https://travis-ci.org/lokielse/aliyun-oss
[link-scrutinizer]: https://scrutinizer-ci.com/g/lokielse/aliyun-oss/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/lokielse/aliyun-oss
[link-downloads]: https://packagist.org/packages/lokielse/aliyun-oss
[link-author]: https://github.com/lokielse
[link-contributors]: ../../contributors
