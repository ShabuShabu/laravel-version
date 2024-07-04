<?php

declare(strict_types=1);

namespace ShabuShabu\Version;

use ShabuShabu\Version\Actions\Contracts\GetsVersion;

function version(bool $fresh = false): GetsVersion
{
    return resolve(GetsVersion::class)($fresh);
}
