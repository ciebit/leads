<?php

declare(strict_types=1);

namespace Ciebit\Leads\Tests\Entities\Topics;

use Ciebit\Leads\Entities\Topics\Collection;
use Ciebit\Leads\Entities\Topics\Topic;
use PHPUnit\Framework\TestCase;

class CollectionTest extends TestCase
{
    public function testBasic(): void
    {
        $topic1 = new Topic('Title 01');
        $topic2 = new Topic('Title 02');
        $topic3 = new Topic('Title 03');
        $topic4 = new Topic('Title 04');
        $topic5 = new Topic('Title 05');
        $collection = new Collection($topic1, $topic2);
        $collection->add($topic3);
        $collection->add($topic4, $topic5);

        $this->assertCount(5, $collection);
        $this->assertEquals($topic1, $collection->getArrayObject()->offsetGet(0));
        $this->assertEquals($topic2, $collection->getArrayObject()->offsetGet(1));
        $this->assertEquals($topic3, $collection->getArrayObject()->offsetGet(2));
        $this->assertEquals($topic4, $collection->getArrayObject()->offsetGet(3));
        $this->assertEquals($topic5, $collection->getArrayObject()->offsetGet(4));
    }

    public function testCreateEmpty(): void
    {
        $collection = new Collection();
        $this->assertCount(0, $collection);
    }

    public function testJsonSerialize(): void
    {
        $topic1 = new Topic('Title 01');
        $topic2 = new Topic('Title 02');
        $collection = new Collection($topic1, $topic2);

        $this->assertJsonStringEqualsJsonString(
            json_encode([
                ['title' => 'Title 01'], 
                ['title' => 'Title 02']
            ]),
            json_encode($collection)
        );
    }
}