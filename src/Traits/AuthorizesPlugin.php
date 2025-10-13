<?php

namespace BinaryBuilds\FilamentCacheManager\Traits;

use Filament\Panel;

trait AuthorizesPlugin
{
    private $canAccess = true;
    public function canAccessPlugin(callable | bool $access): static
    {
        $this->canAccess = $access;
        return $this;
    }

    private function isAccessGranted(): bool
    {
        if (is_callable($this->canAccess)) {
            return ($this->canAccess)();
        }

        return $this->canAccess;
    }

    public function register(Panel $panel): void
    {
        if ($this->isAccessGranted()) {
            $this->registerIfAuthorized($panel);
        }
    }
}
