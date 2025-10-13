<?php

namespace BinaryBuilds\FilamentCacheManager;

use BackedEnum;
use BinaryBuilds\FilamentCacheManager\Pages\CacheManager;
use BinaryBuilds\FilamentCacheManager\Traits\AuthorizesPlugin;
use Filament\Contracts\Plugin;
use Filament\Panel;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class FilamentCacheManagerPlugin implements Plugin
{
    use AuthorizesPlugin;

    private array $cacheKeys = [];

    private int $columns = 2;

    public $canFlushCache = true;

    public $canForgetKey = true;

    public string | BackedEnum | null $navigationIcon = Heroicon::CpuChip;

    public string | UnitEnum | null $navigationGroup = 'Settings';

    public string $navigationLabel = 'Cache Manager';

    public function canForgetKey(callable | bool $canForgetKey): static
    {
        $this->canForgetKey = $canForgetKey;

        return $this;
    }

    public function canFlushCache(callable | bool $canFlushCache): static
    {
        $this->canFlushCache = $canFlushCache;

        return $this;
    }

    public function navigationLabel(string $navigationLabel): static
    {
        $this->navigationLabel = $navigationLabel;

        return $this;
    }

    public function navigationGroup(string | UnitEnum | null $navigationGroup): static
    {
        $this->navigationGroup = $navigationGroup;

        return $this;
    }

    public function navigationIcon(string | BackedEnum | null $navigationIcon): static
    {
        $this->navigationIcon = $navigationIcon;

        return $this;
    }

    public function getId(): string
    {
        return 'filament-cache-manager';
    }

    public function addCacheKey(string $cacheKey, string $title, string $description = '', string $color = 'primary'): static
    {
        $this->cacheKeys[] = [
            'cacheKey' => $cacheKey,
            'title' => $title,
            'description' => $description,
            'color' => $color,
        ];

        return $this;
    }

    public function columns(int $columns): static
    {
        $this->columns = $columns;

        return $this;
    }

    public function getColumns(): int
    {
        return $this->columns;
    }

    public function getCacheKeys(): array
    {
        return $this->cacheKeys;
    }

    public function registerIfAuthorized(Panel $panel): void
    {
        $panel->pages([
            CacheManager::class,
        ]);
    }

    public function boot(Panel $panel): void
    {
        //
    }

    public static function make(): static
    {
        return app(static::class);
    }

    public static function get(): static
    {
        /** @var static $plugin */
        $plugin = filament(app(static::class)->getId());

        return $plugin;
    }
}
