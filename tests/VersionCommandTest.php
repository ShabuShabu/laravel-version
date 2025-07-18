<?php

/** @noinspection StaticClosureCanBeUsedInspection */

declare(strict_types=1);

use Illuminate\Support\Facades\Process;

it('displays the version', function () {
    $git = config('version.git_binary');

    $tag = $git . ' ' . config('version.commands.tag');
    $hash = $git . ' ' . config('version.commands.hash');
    $date = $git . ' ' . config('version.commands.date');

    Process::fake([
        $tag => 'v0.0.18',
        $hash => '9127c86',
        $date => '2023-09-21 11:21:20 +0200',
    ]);

    /* @phpstan-ignore variable.undefined */
    $this
        ->artisan('app:version')
        ->expectsQuestion('What would you like to do?', 'show')
        ->expectsQuestion('Which date format would you like to use?', 'Y-m-d H:i')
        ->expectsTable(['Tag', 'Hash', 'Date'], [[
            'Tag' => 'v0.0.18',
            'Hash' => '9127c86',
            'Date' => '2023-09-21 09:21',
        ]], 'box')
        ->assertExitCode(0);
});
