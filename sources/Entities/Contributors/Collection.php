<?php

declare(strict_types=1);

namespace Ciebit\Leads\Entities\Contributors;

use Ciebit\Leads\Entities\Contributors\Contributor;
use ArrayIterator;
use ArrayObject;
use Countable;
use Exception;
use IteratorAggregate;
use JsonSerializable;

final class Collection implements Countable, IteratorAggregate, JsonSerializable
{
    private ArrayObject $items;

    public function __construct(Contributor ...$contributors)
    {
        $this->items = new ArrayObject();
        $this->add(...$contributors);
    }

    public function __clone()
    {
        $this->items = clone $this->items;
    }

    public function add(Contributor ...$contributorList): self
    {
        foreach ($contributorList as $contributor) {
            $this->items->append($contributor);
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

    /**
     * @throws Exception
     */
    public function getById(string $id): Contributor
    {
        /** @var Contributor $contributor */
        foreach ($this->getIterator() as $contributor) {
            if ($contributor->getId() == $id) {
                return $contributor;
            }
        }

        throw new Exception('app.leads.contributors.collection.not-found', 1);
    }

    public function getIterator(): ArrayIterator
    {
        return $this->items->getIterator();
    }

    public function hasWithId(string $id): bool
    {
        /** @var Contributor $contributor */
        foreach ($this->getIterator() as $contributor) {
            if ($contributor->getId() == $id) {
                return true;
            }
        }

        return false;
    }

    public function jsonSerialize(): array
    {
        return $this->getArrayObject()->getArrayCopy();
    }
}
