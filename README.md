# Memory container

[![License: MIT][license-mit]](LICENSE)

[PSR-11] container storing its values in memory and offering a singleton access.
Requires PHP `^8.1` and implements PSR-11 version 2.

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

Development commands run through the Docker-backed `Makefile`; PHP need not be
installed locally. CI tests PHP 8.1 and 8.5 with normal and lowest dependencies,
and retains PHP 8.2–8.4 checks during the transition. Run `make help` for all
targets.

```sh
make check PHP_VERSION=8.1
make check PHP_VERSION=8.5 DEPENDENCIES_LOWEST=1
```

`check` resolves dependencies, runs lint, PHPUnit and PHPCS, then audits the
same temporary lockfile. `install` removes its temporary lockfile, so a later
standalone `audit` does not verify that earlier snapshot. `clean` removes
`vendor/` and the PHPUnit cache, not a pre-existing lockfile. Composer uses an
isolated manifest copy in the project root and does not change the checked-in
Composer configuration. The host needs `flock` to serialize install, check,
audit and clean operations sharing `vendor/`.

The Composer executable comes from `COMPOSER_IMAGE` (default `composer:2`);
Composer and QA run under the requested PHP image. The container installs
`git` and `unzip` for dependency resolution. Proxy environment variables and an
optional `CA_CERT_FILE` are forwarded, and `COMPOSER_CACHE_DIR` controls the
cache. If `config.platform.php` is present, only the isolated manifest copy
uses the actual PHP patch version; other platform settings and the checked-in
manifest remain unchanged.

Changes to `main` use pull requests and squash merges. Issue branches should be
named `<issue-number>-<title-slug>`. The force-push ruleset excludes the broader
glob `[0-9]*-*`, which also matches some names outside that convention; it does
not enforce the PR source. Main is protected separately.

[license-mit]: https://img.shields.io/badge/license-MIT-blue.svg
[PSR-11]: https://www.php-fig.org/psr/psr-11/ "PSR-11: Container interface"
