# Memory container

[![License: MIT][license-mit]](LICENSE)
[![PHP Version][phpversion]][packagist]
[![Maintainability][maintainability-badge]][maintainability]
[![Test Coverage][coverage-badge]][coverage]

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

[license-mit]: https://img.shields.io/badge/license-MIT-blue.svg
[phpversion]: https://img.shields.io/packagist/php-v/kba-team/memory-container/dev-php5
[maintainability-badge]: https://api.codeclimate.com/v1/badges/21ee0b3bcc3f1fa0a03d/maintainability
[maintainability]: https://codeclimate.com/github/the-kbA-team/memory-container/maintainability
[coverage-badge]: https://api.codeclimate.com/v1/badges/21ee0b3bcc3f1fa0a03d/test_coverage
[coverage]: https://codeclimate.com/github/the-kbA-team/memory-container/test_coverage
[packagist]: https://packagist.org/packages/kba-team/memory-container
[composer]: https://getcomposer.org/ "Dependency Manager for PHP"
[psr11]: https://www.php-fig.org/psr/psr-11/ "PSR-11: Container interface"
