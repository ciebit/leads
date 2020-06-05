<?php

declare(strict_types=1);

namespace Ciebit\Leads\Entities\DateTime;

interface DateTime
{
    public function format(string $format): string;

    public function getTimestamp(): int;
}