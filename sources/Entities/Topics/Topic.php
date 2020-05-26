<?php

declare(strict_types=1);

namespace Ciebit\Leads\Entities\Topics;

use JsonSerializable;

final class Topic implements JsonSerializable
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

    public function jsonSerialize(): array
    {
        return [
            'title' => $this->getTitle()
        ];
    }
}
