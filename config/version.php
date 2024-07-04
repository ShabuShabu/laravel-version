<?php

declare(strict_types=1);

return [
    'cache_hours' => (int) env('VERSION_CACHE_HOURS', 4),

    'git_binary' => env('VERSION_GIT_BINARY', '/opt/homebrew/bin/git'),
];
