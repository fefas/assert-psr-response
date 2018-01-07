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

## Available Assertions

Here is all available assertions so far:

* Status Code: `addStatusCodeToAssert(int $expectedStatusCode)`
* Header Line: `addHeaderLineToAssert(string $headerName, $expectedHeaderLine)`
* JSON Body: `addJsonBodyToAssert(string $expectedJsonBody)`

## Usage

The class `AssertPsrResponse` allows the assertion of certain PSR-7 response
values. That means you don't have to verify the hole PSR-7 response object,
instead you can just assert the fields which are relevants for your current
case. See the samples bellow:

1. Assert Status Code that matches the expected:

   ```php
   <?php

   use Fefas\AssertPsrResponse\AssertPsrResponse;

   $psrResponse = // retrieve it from somewhere ...
   $psrResponse = $psrResponse->withStatus(200);

   $assertPsrResponse = new AssertPsrResponse($psrResponse);
   $assertPsrResponse->addStatusCodeToAssert(200);

   $assertPsrResponse->assert();
   // return true and don't throw any exception
   ```

2. Assert Status Code that doesn't match the expected

   ```php
   <?php

   use Fefas\AssertPsrResponse\AssertPsrResponse;

   $psrResponse = // retrieve it from somewhere ...
   $psrResponse = $psrResponse->withStatus(500);

   $assertPsrResponse = new AssertPsrResponse($psrResponse);
   $assertPsrResponse->addStatusCodeToAssert(200);

   $assertPsrResponse->assert();
   // throw RuntimeException with message:
   // Failed asserting response status code '500' to the expected '200'
   ```

3. Assert Status Code and Header Line that match partly the expected

   ```php
   <?php

   use Fefas\AssertPsrResponse\AssertPsrResponse;

   $psrResponse = // retrieve it from somewhere ...
   $psrResponse = $psrResponse
     ->withStatus(200)
     ->withHeader('Content-Type', 'application/json');

   $assertPsrResponse = new AssertPsrResponse($psrResponse);
   $assertPsrResponse->addStatusCodeToAssert(200);
   $assertPsrResponse->addHeaderLineToAssert('Content-Type', 'text/html');

   $assertPsrResponse->assert();
   // throw RuntimeException with message:
   // Failed asserting response header line 'Content-Type' 'application/json' to the expected 'text/html'
   ```

4. Assert Status Code and Header Line that don't match the expected

   ```php
   <?php

   use Fefas\AssertPsrResponse\AssertPsrResponse;

   $psrResponse = // retrieve it from somewhere ...
   $psrResponse = $psrResponse
     ->withStatus(500)
     ->withHeader('Content-Type', 'text/html');

   $assertPsrResponse = new AssertPsrResponse($psrResponse);
   $assertPsrResponse->addStatusCodeToAssert(200);
   $assertPsrResponse->addHeaderLineToAssert('Content-Type', 'application/json');

   $assertPsrResponse->assert();
   // throw RuntimeException with message:
   // Failed asserting response status code '500' to the expected '200'
   // Failed asserting response header line 'Content-Type' 'text/html' to the expected 'application/json'
   ```

## Contribution

There is two ways to contribute with this project. The first one is by opening
an issue [here](https://github.com/fefas/assert-psr-response/issues). The second
one is by coding:

1. Fork this project and clone it on your local dev environment
2. Install dependencies throught the command: `composer install`
3. Run the locally tests before ubmiting a pull request:
  * To test code standards: `composer run test:cs`
  * To run unit tests: `composer run test:unit`
