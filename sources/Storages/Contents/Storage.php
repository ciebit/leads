<?php

declare(strict_types=1);

namespace Ciebit\Leads\Storages\Contents;

use Ciebit\Leads\Entities\Contents\Collection;

interface Storage
{
    public function addFilterBySlug(string $slug): self;

    public function find(): Collection;
}