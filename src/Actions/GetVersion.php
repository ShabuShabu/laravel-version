<?php

declare(strict_types=1);

namespace ShabuShabu\Version\Actions;

use Carbon\CarbonInterface;
use DateTimeZone;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Process;
use ShabuShabu\Version\Actions\Contracts\GetsVersion;
use Throwable;

class GetVersion implements GetsVersion
{
    protected array $version = [];

    public function __invoke(bool $fresh = false): static
    {
        if ($fresh) {
            Cache::forget('app:version');
        }

        $this->version = Cache::remember(
            'app:version',
            now()->addHours((int) config('version.cache_hours', 4)),
            fn () => collect(config('version.commands'))->map(
                fn (string $command) => $this->run($command)
            )->toArray()
        );

        return $this;
    }

    protected function run(string $command): string
    {
        try {
            $result = Process::timeout(30)->run(
                sprintf('%s %s', config('version.git_binary'), $command)
            );

            return $result->successful() ? trim($result->output()) : '';
        } catch (Throwable) {
            return '';
        }
    }

    public function long(string $format = 'Y-m-d'): string
    {
        if (($short = $this->short()) === '') {
            return '';
        }

        if (! $date = $this->date()) {
            return $short;
        }

        return sprintf('%s (%s)', $short, $date->format($format));
    }

    public function short(): string
    {
        if (! ($tag = $this->tag()) || ! ($hash = $this->hash())) {
            return '';
        }

        return sprintf('%s-%s', $tag, $hash);
    }

    public function tag(): ?string
    {
        return isset($this->version['tag']) ? trim($this->version['tag']) : null;
    }

    public function hash(): ?string
    {
        return isset($this->version['hash']) ? trim($this->version['hash']) : null;
    }

    public function date(): ?CarbonInterface
    {
        if (! isset($this->version['date'])) {
            return null;
        }

        try {
            return Date::parse(trim($this->version['date']))->setTimezone(
                new DateTimeZone('UTC')
            );
        } catch (Throwable) {
            return null;
        }
    }
}
