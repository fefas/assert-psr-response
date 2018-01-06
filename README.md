[![Build Status](https://img.shields.io/travis/fefas/assert-psr-response/master.svg?style=flat-square)](https://travis-ci.org/fefas/assert-psr-response)

[![Latest Stable Version](https://poser.pugx.org/fefas/assert-psr-response/v/stable?format=flat-square)](https://packagist.org/packages/fefas/assert-psr-response)
[![Total Downloads](https://poser.pugx.org/fefas/assert-psr-response/downloads?format=flat-square)](https://packagist.org/packages/fefas/assert-psr-response)
[![Latest Unstable Version](https://poser.pugx.org/fefas/assert-psr-response/v/unstable?format=flat-square)](https://packagist.org/packages/fefas/assert-psr-response)
[![License](https://poser.pugx.org/bauhaus/middleware-chain/license?format=flat-square)](LICENSE)
[![composer.lock](https://poser.pugx.org/fefas/assert-psr-response/composerlock?format=flat-square)](https://packagist.org/packages/fefas/assert-psr-response)

# Assert PSR Response

This composer package aims to provide an easy way to assert
[PSR-7](http://www.php-fig.org/psr/psr-7/) responses.

> I created it because my constant need to assert certain values of PSR
> responses during feature testing of APIs using the
> [Behat](http://behat.org/en/latest/) framework.

## Installation

Install it using [Composer](https://getcomposer.org/):

```shell
$ composer require fefas/assert-psr-response
```

## Usage

The class `AssertPsrResponse` allows the assertion of certain fields of a
response. That means you don't need to verify the hole response object, instead
you can just assert that fields that are relevants for your current workflow:

```php
use Fefas\AssertPsrResponse\AssertPsrResponse;

$responseToAssert = // retrieve it from somewhere ...

// Sample 1 - positive assertion
$responseToAssert = $responseToAssert
    ->withStatus(200)
    ->withHeader('Content-Type', 'application/json');

$assertPsrResponse = new AssertPsrResponse($responseToAssert);

$assertPsrResponse->statusCodeToAssert(200);
$assertPsrResponse->headerLineToAssert('Content-Type', 'application/json');

$assertPsrResponse->assert(); // don't throw any exception

// Sample 2 - negative assertion
$responseToAssert = $responseToAssert
    ->withStatus(500)
    ->withHeader('Content-Type', 'text/html');

$assertPsrResponse = new AssertPsrResponse($responseToAssert);

$assertPsrResponse->statusCodeToAssert(200);
$assertPsrResponse->headerLineToAssert('Content-Type', 'application/json');

$assertPsrResponse->assert(); // throw \RuntimeException with two failed asserting messages
```

Available assertions so far:

* Status Code
* Header Line
* [WIP] JSON Body Content
