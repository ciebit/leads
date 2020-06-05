<?php

declare(strict_types=1);

namespace Ciebit\Leads\Entities\DateTime;

use Ciebit\Leads\Entities\DateTime\DateTime;
use DateTimeImmutable;

final class Defined implements DateTime
{
    private DateTimeImmutable $dateTime;

    public function __construct(string $dateTime)
    {
        $this->dateTime = new DateTimeImmutable($dateTime);
    }

    public function format(string $format): string
    {
        return $this->dateTime->format($format);
    }

    public function getTimestamp(): int
    {
        return $this->dateTime->getTimestamp();
    }
}
