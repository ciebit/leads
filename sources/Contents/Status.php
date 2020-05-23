<?php

declare(strict_types=1);

namespace Ciebit\Leads\Contents;

use MyCLabs\Enum\Enum;

final class Status extends Enum
{
    public const ACTIVE = 3;
    public const INACTIVE = 0;
}
