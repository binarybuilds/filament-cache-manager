# filament-cache-manager

**Filament Cache Manager** is a FilamentPHP plugin that allows you to easily clear your Laravel application cache 
directly from the Filament admin panel.

[![Latest Version on Packagist](https://img.shields.io/packagist/v/binarybuilds/filament-cache-manager.svg?style=flat-square)](https://packagist.org/packages/binarybuilds/filament-cache-manager)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/binarybuilds/filament-cache-manager/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/binarybuilds/filament-cache-manager/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/binarybuilds/filament-cache-manager/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/binarybuilds/filament-cache-manager/actions?query=workflow%3A"Fix+PHP+code+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/binarybuilds/filament-cache-manager.svg?style=flat-square)](https://packagist.org/packages/binarybuilds/filament-cache-manager)

---

![Filament cache manager](/resources/screenshots/filament-cache-manager.png)

## 📦 Installation

Install via Composer:

```bash
composer require binarybuilds/filament-cache-manager
```

Register the plugin in your panel service provider:
```php
use BinaryBuilds\FilamentCacheManager\FilamentCacheManagerPlugin;

$panel->plugin(FilamentCacheManagerPlugin::make());
```

## 🔐 Access Control

Restrict who can access the plugin:
```php
FilamentCacheManagerPlugin::make()
    ->canAccessPlugin(fn () => Auth::user()->role === 'Admin');
```
Restrict who can use the Forget Key action:
```php
FilamentCacheManagerPlugin::make()
    ->canForgetKey(fn () => Auth::user()->role === 'Admin');
```
Restrict who can use the Flush Cache action:
```php
FilamentCacheManagerPlugin::make()
    ->canFlushCache(fn () => false);
```

## ⚙️ Customization
Change navigation label:
```php
FilamentCacheManagerPlugin::make()
    ->navigationLabel('Cache');
```
Change navigation icon:
```php
use Filament\Support\Icons\Heroiconl;

FilamentCacheManagerPlugin::make()
    ->navigationIcon(Heroicon::CpuChip);
```
Change navigation group:
```php
FilamentCacheManagerPlugin::make()
    ->navigationGroup('Settings');
```

## 🧩 Predefined Cache Keys

Display common cache keys as cards with title, description, and optional status color:

```php
FilamentCacheManagerPlugin::make()
    ->addCacheKey(
        'homepage',
        'Homepage Cache',
        'Clear this cache if the content on the homepage is out of date.'
    )
    ->addCacheKey(
        'layout',
        'Layout Cache',
        'Clear this cache if you recently made changes to menu items. Beware! this might cause a temporary slowness to the application.',
        'danger'
    )
    ->addCacheKey(
        'settings',
        'Settings Cache',
        'Clear this cache if you recently updated site settings'
    )
    ->addCacheKey(
        'articles',
        'Articles Cache',
        'Clear this cache if you added or updated articles and your changes are not reflecting on the site.'
    );
```

## 🧱 Card Layout Columns

Control the number of columns used to display the predefined cache key cards:

```php
FilamentCacheManagerPlugin::make()
    ->columns(3);
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Srinath Reddy Dudi](https://github.com/srinathreddydudi)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
