<?php

declare(strict_types=1);

namespace Ciebit\Leads\Tests\Storages\Messages\Database;

use Ciebit\Leads\Entities\Messages\Collection;
use Ciebit\Leads\Storages\Messages\Database\Sql;
use Ciebit\Leads\Tests\Factories\Pdo as PdoFactory;
use PHPUnit\Framework\TestCase;

class SqlTest extends TestCase
{
    public function testFind(): void
    {
        $storage = $this->getStorage();
        $collection = $storage->find();
        $this->assertInstanceOf(Collection::class, $collection);
        $this->assertCount(3, $collection);
    }

    public function testFindByContentId(): void
    {
        $storage = $this->getStorage();
        $storage->addFilterByContentId('2');
        $collection = $storage->find();
        $content = $collection->getArrayObject()->offsetGet(0);

        $this->assertCount(1, $collection);
        $this->assertEquals('2', $content->getId());
        $this->assertEquals('<p>Olá!</p>', $content->getBody());
    }

    private function getStorage(): Sql
    {
        $pdoFactory = new PdoFactory();

        return new Sql(
            $pdoFactory->create()
        );
    }
}
