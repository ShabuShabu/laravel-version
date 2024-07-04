<?php

/** @noinspection StaticClosureCanBeUsedInspection */

declare(strict_types=1);

use Carbon\CarbonInterface;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Process;

use function ShabuShabu\Version\version;

it('gets the version', function () {
    $git = config('version.git_binary');

    $tag = $git . ' describe --tags --abbrev=0';
    $hash = $git . ' log --pretty="%h" -n1 HEAD';
    $date = $git . ' log --pretty="%ci" -n1 HEAD';

    Process::fake([
        $tag => 'v0.0.18',
        $hash => '9127c86',
        $date => '2023-09-21 11:21:20 +0200',
    ]);

    $version = version(fresh: true);

    Process::assertRanTimes($tag);
    Process::assertRanTimes($hash);
    Process::assertRanTimes($date);

    expect($version->tag())->toBe('v0.0.18')
        ->and($version->hash())->toBe('9127c86')
        ->and($version->date())->toBeInstanceOf(CarbonInterface::class)
        ->and($version->short())->toBe('v0.0.18-9127c86')
        ->and($version->long())->toBe('v0.0.18-9127c86 (2023-09-21)')
        ->and($version->long('Ymd'))->toBe('v0.0.18-9127c86 (20230921)')
        ->and(Cache::get('app:version'))->toBe([
            'tag' => 'v0.0.18',
            'hash' => '9127c86',
            'date' => '2023-09-21 11:21:20 +0200',
        ]);
});
