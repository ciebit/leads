<?php

declare(strict_types=1);

namespace Ciebit\Leads\Storages\Messages;

use Ciebit\Leads\Entities\Messages\Collection;

interface Storage
{
    public function addFilterByContentId(string $id): self;

    public function find(): Collection;
}
