# Phone

Validates phone number format.

<p >
  <a href="https://travis-ci.org/laravel-validation-rules/phone">
    <img src="https://img.shields.io/travis/laravel-validation-rules/phone.svg?style=flat-square">
  </a>
  <a href="https://scrutinizer-ci.com/g/laravel-validation-rules/phone/code-structure/master/code-coverage">
    <img src="https://img.shields.io/scrutinizer/coverage/g/laravel-validation-rules/phone.svg?style=flat-square">
  </a>
  <a href="https://scrutinizer-ci.com/g/laravel-validation-rules/phone">
    <img src="https://img.shields.io/scrutinizer/g/laravel-validation-rules/phone.svg?style=flat-square">
  </a>
  <a href="https://github.com/laravel-validation-rules/phone/blob/master/LICENSE">
    <img src="https://img.shields.io/github/license/laravel-validation-rules/phone.svg?style=flat-square">
  </a>
  <a href="https://twitter.com/tylercd100">
    <img src="http://img.shields.io/badge/author-@tylercd100-blue.svg?style=flat-square">
  </a>
</p>

## Installation

```bash
composer require laravel-validation-rules/phone
```

## Usage

```php
use LVR\Phone\Phone;
use LVR\Phone\E123;
use LVR\Phone\E164;
use LVR\Phone\NANP;
use LVR\Phone\Digits;

// Test any phone number
$request->validate(['test' => '15556667777'], ['test' => new Phone]); // Pass!
$request->validate(['test' => '+15556667777'], ['test' => new Phone]); // Pass!
$request->validate(['test' => '+1 (555) 666-7777'], ['test' => new Phone]); // Pass!

// Test for E123
$request->validate(['test' => '+22 555 666 7777'], ['test' => new E123]); // Pass!

// Test for E164
$request->validate(['test' => '+15556667777'], ['test' => new E164]); // Pass!

// Test for NANP (North American Numbering Plan)
$request->validate(['test' => '+1 (555) 666-7777'], ['test' => new NANP); // Pass!

// Test for digits only
$request->validate(['test' => '15556667777'], ['test' => new Digits]); // Pass!
```
