<?php

declare(strict_types=1);

return [
    /*
    |--------------------------------------------------------------------------
    | Cache hours
    |--------------------------------------------------------------------------
    |
    | The no of hours the version info should be cached
    |
    */

    'cache_hours' => (int) env('VERSION_CACHE_HOURS', 4),

    /*
    |--------------------------------------------------------------------------
    | Git binary
    |--------------------------------------------------------------------------
    |
    | By default, the Homebrew version is used
    |
    */

    'git_binary' => env('VERSION_GIT_BINARY', '/opt/homebrew/bin/git'),
];
