<?php

declare(strict_types=1);

namespace ShabuShabu\Version;

use ShabuShabu\Version\Actions\Contracts\GetsVersion;
use ShabuShabu\Version\Actions\GetVersion;
use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class VersionServiceProvider extends PackageServiceProvider
{
    public array $bindings = [
        GetsVersion::class => GetVersion::class,
    ];

    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-version')
            ->hasConfigFile()
            ->hasInstallCommand(function (InstallCommand $command) {
                $command
                    ->publishConfigFile()
                    ->askToStarRepoOnGitHub('ShabuShabu/laravel-version');
            });
    }
}
