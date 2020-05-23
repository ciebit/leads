<?php

declare(strict_types=1);

namespace Ciebit\Leads\Entities\Contents;

use Ciebit\Leads\Entities\Contents\Content;
use ArrayIterator;
use ArrayObject;
use Countable;
use IteratorAggregate;
use JsonSerializable;

final class Collection implements Countable, IteratorAggregate, JsonSerializable
{
    private ArrayObject $items;

    public function __construct(Content ...$contents)
    {
        $this->items = new ArrayObject();
        $this->add(...$contents);
    }

    public function __clone()
    {
        $this->items = clone $this->items;
    }

    public function add(Content ...$contentList): self
    {
        foreach ($contentList as $content) {
            $this->items->append($content);
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
