<?php

declare(strict_types=1);

namespace Ciebit\Leads\Tests\Storages\Contents\Database;

use Ciebit\Leads\Entities\Contents\Collection;
use Ciebit\Leads\Storages\Contents\Database\Sql;
use Ciebit\Leads\Tests\Factories\Pdo as PdoFactory;
use PHPUnit\Framework\TestCase;

class SqlTest extends TestCase
{
    public function testFind(): void
    {
        $storage = $this->getStorage();
        $collection = $storage->find();
        $this->assertInstanceOf(Collection::class, $collection);
    }

    public function testFindBySlug(): void
    {
        $storage = $this->getStorage();
        $storage->addFilterBySlug('slug-02');
        $collection = $storage->find();
        $content = $collection->getArrayObject()->offsetGet(0);
        
        $this->assertCount(1, $collection);
        $this->assertEquals('slug-02', $content->getSlug());
        $this->assertEquals('2', $content->getId());
    }

    private function getStorage(): Sql
    {
        $pdoFactory = new PdoFactory();

        return new Sql(
            $pdoFactory->create()
        );
    }
}