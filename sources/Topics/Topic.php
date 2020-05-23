<?php

declare(strict_types=1);

namespace Ciebit\Leads\Topics;

final class Topic
{
    private string $title;

    public function __construct(string $title)
    {
        $this->title = $title;
    }

    public function getTitle(): string
    {
        return $this->title;
    }
}
