<?php

declare(strict_types=1);

namespace Ciebit\Leads\Entities\DateTime;

use Ciebit\Leads\Entities\DateTime\DateTime;

final class Undefined implements DateTime
{
    public function format($format): string
    {
        return '';
    }

    public function getTimestamp(): int
    {
        return 0;
    }
}
