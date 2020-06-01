<?php

declare(strict_types=1);

namespace Ciebit\Leads\Storages\Records;

use Ciebit\Leads\Entities\Records\Collection;
use Ciebit\Leads\Entities\Records\Record;

interface Storage
{
    public function find(): Collection;

    public function store(Record $record): Record;
}
