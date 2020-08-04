<?php

declare(strict_types=1);

namespace Ciebit\Leads\Storages\Records;

use Ciebit\Leads\Entities\Records\Collection;
use Ciebit\Leads\Entities\Records\Record;

interface Storage
{
    public function addFilterByContentId(string $id): self;

    public function addFilterById(string $id): self;

    public function addOrderBy(string $column, string $order = 'ASC'): self;

    public function find(): Collection;

    public function setOffset(int $offset): self;

    public function setLimit(int $total): self;

    public function store(Record $record): Record;
}
