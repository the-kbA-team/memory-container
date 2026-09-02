# Memory container

[![License: MIT][license-mit]](LICENSE)

[PSR-11] container storing its values in memory and offering a singleton access.

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

Container::singleton()->set('hello', function ($what) {
    return sprintf('Hello %s!', $what);
});
// ...
$example = new Greeter(Container::singleton()->get('hello'));
```

## Development

All development commands (install, test, lint, beautify, sniff, audit,
validate) run via Docker through the `Makefile`, so no local PHP installation is
needed. Run `make help` to list all targets. Most targets require `PHP_VERSION`,
e.g.:

```sh
make install PHP_VERSION=8.1
```

[license-mit]: https://img.shields.io/badge/license-MIT-blue.svg
[PSR-11]: https://www.php-fig.org/psr/psr-11/ "PSR-11: Container interface"
