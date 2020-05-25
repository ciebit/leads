<?php

declare(strict_types=1);

namespace Ciebit\Leads\Storages\Records;

use Ciebit\Leads\Entities\Records\Record;

interface Storage
{
    public function store(Record $record): Record;
}
