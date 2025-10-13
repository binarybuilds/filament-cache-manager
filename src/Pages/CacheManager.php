<?php

namespace BinaryBuilds\FilamentCacheManager\Pages;

use BackedEnum;
use BinaryBuilds\FilamentCacheManager\FilamentCacheManagerPlugin;
use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Concerns\InteractsWithInfolists;
use Filament\Infolists\Contracts\HasInfolists;
use Filament\Pages\Page;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use UnitEnum;

class CacheManager extends Page implements HasInfolists
{
    use InteractsWithInfolists;

    protected string $view = 'filament-cache-manager::pages.cache-manager';

    public static string | null | \BackedEnum $navigationIcon = Heroicon::CpuChip;

    public static string | null | \UnitEnum $navigationGroup = 'Settings';

    public static ?string $navigationLabel = 'Cache Manager';

    public static function getNavigationLabel(): string
    {
        return FilamentCacheManagerPlugin::get()->navigationLabel;
    }

    public static function getNavigationGroup(): string | UnitEnum | null
    {
        return FilamentCacheManagerPlugin::get()->navigationGroup;
    }

    public static function getNavigationIcon(): string | BackedEnum | Htmlable | null
    {
        return FilamentCacheManagerPlugin::get()->navigationIcon;
    }

    public function getHeading(): string | Htmlable
    {
        return FilamentCacheManagerPlugin::get()->navigationLabel;
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make(__('Forget Key'))
                ->visible(FilamentCacheManagerPlugin::get()->canForgetKey)
                ->schema([
                    TextInput::make('cache_key')->required(),
                ])
                ->action(function (array $data) {
                    Cache::forget($data['cache_key']);
                })
                ->successNotificationTitle(fn (array $data) => 'Cache key ' . $data['cache_key'] . ' has been cleared'),

            Action::make(__('Flush Cache'))
                ->visible(FilamentCacheManagerPlugin::get()->canFlushCache)
                ->requiresConfirmation()
                ->color('danger')
                ->modalDescription('Are you sure you want to flush entire application cache?')
                ->action(fn () => Cache::flush())
                ->successNotificationTitle('Cache flushed successfully!'),
        ];
    }

    public function infolist(Schema $schema): Schema
    {
        $actions = [];

        foreach (FilamentCacheManagerPlugin::get()->getCacheKeys() as $cacheKey) {
            $actions[] = Section::make($cacheKey['title'])
                ->description($cacheKey['description'])
                ->schema([
                    Action::make('clear_cache_' . $cacheKey['cacheKey'])
                        ->label('Clear cache')
                        ->requiresConfirmation()
                        ->color($cacheKey['color'])
                        ->modalDescription('Are you sure you want to clear ' . $this->getCacheKeyHeading($cacheKey['title']) . '?')
                        ->action(fn () => Cache::forget($cacheKey['cacheKey']))
                        ->successNotificationTitle(fn () => $this->getCacheKeyHeading($cacheKey['title']) . ' has been cleared'),
                ]);
        }

        return $schema->schema([
            Grid::make(FilamentCacheManagerPlugin::get()->getColumns())->schema($actions),
        ]);
    }

    private function getCacheKeyHeading(string $key): string
    {
        return Str::endsWith($key, 'cache') ? $key : $key . ' cache';
    }
}
