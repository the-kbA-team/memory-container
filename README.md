# Memory container

[![License: MIT][license-mit]](LICENSE)
[![PHP Version][phpversion]][packagist]
[![Build Status][build-status-php5]][travis-ci]

PSR-11 container storing its values in memory and offering a singleton access.

## Usage

A simple example:

```php
<?php
namespace vendor\product;

class Greeter
{
    public function __construct(\Closure $logic) {
        printf('%s%s', $logic('world'), PHP_EOL);
    }
}
```

```php
<?php

use kbATeam\MemoryContainer\Container;
use vendor\product\Greeter;

Container::singleton()->add('hello', function ($what) {
    return sprintf('Hello %s!', $what);
});
// ...
$example = new Greeter(Container::singleton()->get('hello'));
```

## Testing

Get [composer][composer], and install the dependencies.

```sh
composer install
```

Call phpunit to run the tests available.

```sh
vendor/bin/phpunit
```

## [MIT License](LICENSE)

Copyright (c) 2019 the-kbA-team

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.

[license-mit]: https://img.shields.io/badge/license-MIT-blue.svg
[phpversion]: https://img.shields.io/packagist/php-v/kba-team/memory-container/dev-php5
[packagist]: https://packagist.org/packages/kba-team/memory-container
[travis-ci]: https://travis-ci.org/the-kbA-team/memory-container "the-kbA-team/memory-container - Travis CI"
[build-status-php5]: https://api.travis-ci.org/the-kbA-team/memory-container.svg?branch=php5
[composer]: https://getcomposer.org/ "Dependency Manager for PHP"
[psr11]: https://www.php-fig.org/psr/psr-11/ "PSR-11: Container interface"
