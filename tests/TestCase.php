<?php

declare(strict_types=1);

namespace ShabuShabu\Version\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use ShabuShabu\Version\VersionServiceProvider;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app)
    {
        return [
            VersionServiceProvider::class,
        ];
    }
}
