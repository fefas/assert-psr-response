[![Build Status](https://img.shields.io/travis/fefas/assert-psr-response/master.svg?style=flat-square)](https://travis-ci.org/fefas/assert-psr-response)

[![Latest Stable Version](https://poser.pugx.org/fefas/assert-psr-response/v/stable?format=flat-square)](https://packagist.org/packages/fefas/assert-psr-response)
[![Total Downloads](https://poser.pugx.org/fefas/assert-psr-response/downloads?format=flat-square)](https://packagist.org/packages/fefas/assert-psr-response)
[![Latest Unstable Version](https://poser.pugx.org/fefas/assert-psr-response/v/unstable?format=flat-square)](https://packagist.org/packages/fefas/assert-psr-response)
[![License](https://poser.pugx.org/bauhaus/middleware-chain/license?format=flat-square)](LICENSE)
[![composer.lock](https://poser.pugx.org/fefas/assert-psr-response/composerlock?format=flat-square)](https://packagist.org/packages/fefas/assert-psr-response)

> **Important** this package won't worry about backward compatibily for `v0.*`
> versions.

# Assert PSR Response

This composer package aims to provide an easy way to assert
[PSR-7](http://www.php-fig.org/psr/psr-7/) responses.

## Motivation

I created this package because my constant need to assert only certain values of
PSR responses during testing, for example feature APIs testing using the
[Behat](http://behat.org/en/latest/) framework.

## Installation

Install it using [Composer](https://getcomposer.org/):

```shell
$ composer require fefas/assert-psr-response
```

## Usage

The class `AssertPsrResponse` allows the assertion of certain PSR-7 response
values. That means you don't have to verify the hole PSR-7 response object,
instead you can just assert the fields which are relevants for your current
case:

```php
use Fefas\AssertPsrResponse\AssertPsrResponse;

$responseToAssert = // retrieve it from somewhere ...

// Sample 1 - positive assertion
$responseToAssert = $responseToAssert
    ->withStatus(200)
    ->withHeader('Content-Type', 'application/json');

$assertPsrResponse = new AssertPsrResponse($responseToAssert);

$assertPsrResponse->addStatusCodeToAssert(200);
$assertPsrResponse->addHeaderLineToAssert('Content-Type', 'application/json');

$assertPsrResponse->assert(); // don't throw any exception

// Sample 2 - negative assertion
$responseToAssert = $responseToAssert
    ->withStatus(500)
    ->withHeader('Content-Type', 'text/html');

$assertPsrResponse = new AssertPsrResponse($responseToAssert);

$assertPsrResponse->addStatusCodeToAssert(200);
$assertPsrResponse->addHeaderLineToAssert('Content-Type', 'application/json');

$assertPsrResponse->assert(); // throw \RuntimeException with two failed asserting messages
```

Available assertions so far:

* Status Code
* Header Line
* JSON Body Content
