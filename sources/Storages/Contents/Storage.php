<?php

declare(strict_types=1);

namespace Ciebit\Leads\Storages\Contents;

use Ciebit\Leads\Entities\Contents\Collection;
use Ciebit\Leads\Entities\Contents\Status;

interface Storage
{
    public function addFilterById(string $id): self;

    public function addFilterBySlug(string $slug): self;

    public function addFilterByType(string $type): self;

    public function addFilterByStatus(Status $status): self;

    public function addOrderBy(string $column, string $order = 'ASC'): self;

    public function find(): Collection;

    public function setLimit(int $total): self;

    public function setOffset(int $offset): self;
}