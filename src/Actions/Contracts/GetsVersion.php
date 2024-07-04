<?php

declare(strict_types=1);

namespace ShabuShabu\Version\Actions\Contracts;

use Carbon\CarbonInterface;

interface GetsVersion
{
    public function __invoke(bool $fresh = false): static;

    public function tag(): ?string;

    public function hash(): ?string;

    public function date(): ?CarbonInterface;

    public function short(): string;

    public function long(string $format = 'Y-m-d'): string;
}
