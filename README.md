# Laravel Version

[![Latest Version on Packagist](https://img.shields.io/packagist/v/shabushabu/laravel-version.svg?style=flat-square)](https://packagist.org/packages/shabushabu/laravel-version)
[![Total Downloads](https://img.shields.io/packagist/dt/shabushabu/laravel-version.svg?style=flat-square)](https://packagist.org/packages/shabushabu/laravel-version)

A small package that gives you various version tools based on Git tags

## Installation

You can install the package via composer:

```bash
composer require shabushabu/laravel-version
```

You can then publish the config file with:

```bash
php artisan vendor:publish --tag="version-config"
```

## Usage

Can be used in site footers or user agent strings, for example.

```php
use function ShabuShabu\Version\version;

version()->date(); // CarbonInterface::class
version()->tag(); // eg: v0.18.0
version()->hash(); // eg: 9127c86
version()->short(); // eg: v0.18.0-9127c86
version()->long(format: 'Y-m-d'); // eg: v0.18.0-9127c86 (2023-09-21)
```

The info is cached using the following key: `app:version`, so you might want to clear that as part of your deployment like so:

```bash
php artisan cache:forget app:version
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Boris Glumpler](https://github.com/boris-glumpler)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
