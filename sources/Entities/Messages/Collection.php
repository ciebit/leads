<?php

declare(strict_types=1);

namespace Ciebit\Leads\Entities\Messages;

use Ciebit\Leads\Entities\Messages\Message;
use ArrayIterator;
use ArrayObject;
use Countable;
use IteratorAggregate;
use JsonSerializable;

final class Collection implements Countable, IteratorAggregate, JsonSerializable
{
    private ArrayObject $items;

    public function __construct(Message ...$messageList)
    {
        $this->items = new ArrayObject();
        $this->add(...$messageList);
    }

    public function __clone()
    {
        $this->items = clone $this->items;
    }

    public function add(Message ...$messageList): self
    {
        foreach ($messageList as $message) {
            $this->items->append($message);
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
