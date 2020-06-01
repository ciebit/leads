<?php

declare(strict_types=1);

namespace Ciebit\Leads\Tests\Storages\Records\Database;

use Ciebit\Leads\Entities\Records\Record;
use Ciebit\Leads\Storages\Records\Database\Sql;
use Ciebit\Leads\Tests\Factories\Pdo as PdoFactory;
use PHPUnit\Framework\TestCase;

class SqlTest extends TestCase
{
    public function testFind(): void
    {
        $storage = $this->getStorage();
        $collection = $storage->find();

        $this->assertCount(3, $collection);
    }

    public function testStore(): void
    {
        $record = new Record('1', 'Name', 'name@mail.com', '8812341234', 2);
        $storage = $this->getStorage();
        $recordStored = $storage->store($record);

        $this->assertEquals('4', $recordStored->getId());
    }

    protected function setUp(): void
    {
        $this->setDefaultDatabase();
    }

    private function getStorage(): Sql
    {
        $pdoFactory = new PdoFactory();

        return new Sql(
            $pdoFactory->create()
        );
    }

    private function setDefaultDatabase(): void
    {
        $pdoFactory = new PdoFactory();
        $pdo = $pdoFactory->create();
        $pdo->exec('TRUNCATE TABLE `leads_records`');
        $pdo->exec(file_get_contents(__DIR__ . '/../../../../data/records.sql'));
    }
}
