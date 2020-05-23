<?php

declare(strict_types=1);

namespace Ciebit\Leads\Entities\Topics;

use Ciebit\Leads\Entities\Topics\Topic;
use ArrayIterator;
use ArrayObject;
use Countable;
use IteratorAggregate;
use JsonSerializable;

final class Collection implements Countable, IteratorAggregate, JsonSerializable
{
    private ArrayObject $items;

    public function __construct(Topic ...$topics)
    {
        $this->items = new ArrayObject();
        $this->add(...$topics);
    }

    public function __clone()
    {
        $this->items = clone $this->items;
    }

    public function add(Topic ...$topicList): self
    {
        foreach ($topicList as $topic) {
            $this->items->append($topic);
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
