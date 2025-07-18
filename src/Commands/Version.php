<?php

declare(strict_types=1);

namespace ShabuShabu\Version\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use ShabuShabu\Version\Actions\Contracts\GetsVersion;

use function Laravel\Prompts\select;
use function Laravel\Prompts\text;

class Version extends Command
{
    protected $signature = 'app:version {action? : The action to perform, either show or clear}
                                        {--date-format= : The date format, defaults to `Y-m-d H:i:s`}';

    protected $description = 'Manages the application version';

    public function __invoke(GetsVersion $getVersion): int
    {
        $action = $this->argument('action') ?? select(
            label: 'What would you like to do?',
            options: ['show', 'clear'],
            default: 'show',
        );

        return match ($action) {
            'show' => $this->show($getVersion),
            'clear' => $this->clear(),
            default => static::FAILURE
        };
    }

    protected function show(GetsVersion $getVersion): int
    {
        $format = $this->option('date-format') ?? text(
            label: 'Which date format would you like to use?',
            default: 'Y-m-d H:i:s',
            required: true,
        );

        $version = $getVersion();

        $this->table(
            headers: ['Tag', 'Hash', 'Date'],
            rows: [[
                'Tag' => $version->tag() ?? 'N/A',
                'Hash' => $version->hash() ?? 'N/A',
                'Date' => $version->date()?->format($format) ?? 'N/A',
            ]],
            tableStyle: 'box',
        );

        return self::SUCCESS;
    }

    protected function clear(): int
    {
        Cache::forget('app:version');

        $this->components->info('Application version has been cleared!');

        return self::SUCCESS;
    }
}
