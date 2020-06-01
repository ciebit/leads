<?php

declare(strict_types=1);

namespace Ciebit\Leads\Tests\Entities\Records;

use Ciebit\Leads\Entities\Records\Collection;
use Ciebit\Leads\Entities\Records\Record;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

class CollectionTest extends TestCase
{
    public function testBasic(): void
    {
        $record1 = new Record(
            '5',
            'Leonardo da Vince',
            'leo@art.com',
            '0012341234',
            1
        );
        $record2 = new Record(
            '5',
            'Salvador Dalí',
            'salvador@art.com',
            '0012345678',
            2
        );
        $record3 = new Record(
            '5',
            'Michelangelo',
            'michelangelo@art.com',
            '0012340123',
            3
        );

        $collection = new Collection($record1);
        $collection->add($record2, $record3);

        $this->assertCount(3, $collection);
        $this->assertEquals($record1, $collection->getArrayObject()->offsetGet(0));
        $this->assertEquals($record2, $collection->getArrayObject()->offsetGet(1));
        $this->assertEquals($record3, $collection->getArrayObject()->offsetGet(2));
    }

    public function testJsonSerialize(): void
    {
        $data = [
            [
                'contentId' => '5',
                'name' => 'Leonardo da Vince',
                'email' => 'leo@art.com',
                'phone' => '0012341234',
                'profileId' => 1,
                'dateTime' => '2020-06-01T17:14:00-03:00',
                'id' => '2'
            ],
            [
                'contentId' => '5',
                'name' => 'Michelangelo',
                'email' => 'michelangelo@art.com',
                'phone' => '0012340123',
                'profileId' => 3,
                'dateTime' => '2020-06-01T17:15:00-03:00',
                'id' => '4'
            ],

        ];

        $collection = new Collection();

        foreach($data as $recordData) {
            $record = new Record(
                $recordData['contentId'],
                $recordData['name'],
                $recordData['email'],
                $recordData['phone'],
                $recordData['profileId'],
                DateTimeImmutable::createFromFormat(
                    DateTimeImmutable::W3C, 
                    $recordData['dateTime']
                ),
                $recordData['id']
            );
            $collection->add($record);
        }

        $this->assertJsonStringEqualsJsonString(
            json_encode($data),
            json_encode($collection)
        );
    }
}
