[![Build Status](https://img.shields.io/github/workflow/status/bauhausphp/assert-psr-response/Build?style=flat-square)](https://github.com/bauhausphp/assert-psr-response/actions?query=workflow%3ABuild)
[![Coverage](https://img.shields.io/codecov/c/github/bauhausphp/assert-psr-response?style=flat-square)](https://codecov.io/gh/bauhausphp/assert-psr-response)

[![Stable Version](https://img.shields.io/packagist/v/bauhaus/assert-psr-response?style=flat-square)](https://packagist.org/packages/bauhaus/assert-psr-response)
[![Downloads](https://img.shields.io/packagist/dt/bauhaus/assert-psr-response?style=flat-square)](https://packagist.org/packages/bauhaus/assert-psr-response)
[![PHP Version](https://img.shields.io/packagist/php-v/bauhaus/assert-psr-response?style=flat-square)](composer.json)
[![License](https://img.shields.io/github/license/bauhausphp/assert-psr-response?style=flat-square)](LICENSE)

# Assert PSR Response

This composer package aims to provide an easy way to assert
[PSR-7](http://www.php-fig.org/psr/psr-7/) responses.

## Motivation

I created this package because my constant need of asserting only certain values
of PSR responses during acceptance tests.

## Installation

Install it using [Composer](https://getcomposer.org/):

```shell
$ composer require bauhaus/assert-psr-response
```

## Usage

```php
<?php

use Bauhaus\PsrResponseAssertion\PsrResponseAssertion;
use Bauhaus\PsrResponseAssertion\Matchers\HeaderLine;
use Bauhaus\PsrResponseAssertion\Matchers\StatusCode;

$assertion = PsrResponseAssertion::with(
   StatusCode::equalTo(200),
   HeaderLine::equalTo('Content-Type', 'application/json')
);

$psrResponse = // retrieve it from somewhere ...
$psrResponse = $psrResponse
   ->withStatus(404)
   ->withHeader('Content-Type', 'text/html');

$assertion->assert($psrResponse);
// throw PsrResponseAssertionException with message:
// Actual response status code '404' is not equal to the expected '200'
// Actual response header line 'Content-Type' 'text/html' is not equal to the expected 'application/json'
```

## Available Matchers

- `StatusCode::equalTo(200)`
- `HeaderLine::equalTo('Header-Name', 'Header-Value')`
- `JsonBody::equalTo('{"field":"value"}')`

## Contribution

There is two ways to contribute with this project. The first one is by opening
an issue [here](https://github.com/bauhausphp/assert-psr-response/issues). The second
one is by coding:

1. Fork this project and clone it on your local dev environment
2. Install dependencies throught the command: `composer install`
3. Run the locally tests before ubmiting a pull request:
  * To test code standards: `composer run test:cs`
  * To run unit tests: `composer run test:unit`
  * To run all tests in a roll: `composer run tests`
