<?php

declare(strict_types=1);

namespace Ciebit\Leads\Entities\Records;

use ArrayIterator;
use ArrayObject;
use Ciebit\Leads\Entities\Records\Record;
use Countable;
use IteratorAggregate;
use JsonSerializable;

final class Collection implements Countable, IteratorAggregate, JsonSerializable
{
    private ArrayObject $items;

    public function __construct(Record ...$records)
    {
        $this->items = new ArrayObject();
        $this->add(...$records);
    }

    public function __clone()
    {
        $this->items = clone $this->items;
    }

    public function add(Record ...$recordList): self
    {
        foreach ($recordList as $record) {
            $this->items->append($record);
        }

        return $this;
    }

    public function count(): int
    {
        return $this->items->count();
    }

    public function getArrayObject(): ArrayObject
    {
        return clone $this->items;
    }

    public function getIterator(): ArrayIterator
    {
        return $this->items->getIterator();
    }

    public function jsonSerialize(): array
    {
        return $this->getArrayObject()->getArrayCopy();
    }
}
