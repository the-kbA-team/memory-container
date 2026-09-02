# AGENTS.md

## Project scope
- This repository is a tiny PHP library: an in-memory PSR-11 container with optional singleton access.
- The entire implementation lives in `src/`; behavior is defined almost completely by `src/Container.php` and `tests/ContainerTest.php`.

## Architecture at a glance
- `src/Container.php` is the only stateful component. It stores entries in a private `array $storage` and exposes `get($id)`, `has($id)`, `set($id, $value)`, and `singleton()`.
- IDs are normalized centrally through `validateId()` in `src/Container.php`: IDs are trimmed and must not become an empty string. `" foo "` and `"foo"` address the same entry.
- Missing entries raise `kbATeam\MemoryContainer\NotFoundException`; invalid IDs raise `InvalidArgumentException`.
- Exception structure follows PSR-11 exactly:
  - `src/ContainerException.php` implements `Psr\Container\ContainerExceptionInterface`
  - `src/NotFoundException.php` extends `ContainerException` and implements `Psr\Container\NotFoundExceptionInterface`
- `singleton()` uses a static local instance inside `Container::singleton()`. There is no factory layer, service provider system, lazy resolution, or autowiring.

## API details that matter when editing
- The mutator method is `set()`. `tests/ContainerTest.php` and the usage example in `README.md` both exercise `set()/has()/get()`.
- Values are stored as-is. The container does not invoke closures or construct objects for callers.
- `has()` uses `array_key_exists(...)`, so stored `null` values still count as present.
- `get()` calls `has()` after validating the ID, then returns the raw stored value.

## Testing and verification workflow
- Prefer the `Makefile`; it is the documented developer entry point in `README.md`.
- Most targets require `PHP_VERSION`, for example:
  - `make install PHP_VERSION=8.1`
  - `make test PHP_VERSION=8.1`
  - `make lint PHP_VERSION=8.1`
  - `make beautify PHP_VERSION=8.1`
  - `make sniff PHP_VERSION=8.1`
- All build/test/style commands run in Docker containers from the `Makefile`; do not assume a local PHP runtime.
- `make install` switches to `composer update --prefer-lowest` when `DEPENDENCIES_LOWEST=1` is set. Preserve that behavior if you touch dependency workflows.
- Proxy and certificate passthrough are already built into `Makefile` (`HTTP_PROXY`, `HTTPS_PROXY`, `NO_PROXY`, optional `CA_CERT_FILE`). Keep those environment hooks intact.

## Conventions visible in the codebase
- PHP 8.1+ only (`composer.json`), `declare(strict_types=1);` in every source and test file.
- Namespace layout is direct PSR-4:
  - production: `kbATeam\MemoryContainer\` -> `src/`
  - tests: `Tests\kbATeam\MemoryContainer\` -> `tests/`
- Coding style is PSR-12 via `phpcs.xml`, limited to `src/` and `tests/`.
- PHPUnit configuration in `phpunit.xml` bootstraps `vendor/autoload.php` and includes coverage only for `src/`.
- Tests are example-driven and compact. `tests/ContainerTest.php` uses one data provider (`invalidIds`) to enforce identical validation behavior across `has()`, `get()`, and `set()`.

## Safe change strategy for agents
- Keep this library minimal; new abstractions are usually unnecessary unless they are required by PSR-11 behavior.
- If you change ID validation, exception messages, or singleton behavior, update `tests/ContainerTest.php` in the same change because those behaviors are asserted directly.
- If you touch public API examples or naming, reconcile `README.md` with the actual implementation so docs and tests stop drifting.

