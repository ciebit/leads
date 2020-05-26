<?php

declare(strict_types=1);

namespace Ciebit\Leads\Tests\Entities\Contributors;

use Ciebit\Leads\Entities\Contributors\Collection;
use Ciebit\Leads\Entities\Contributors\Contributor;
use PHPUnit\Framework\TestCase;

class CollectionTest extends TestCase
{
    public function testBasic(): void
    {
        $contributor1 = new Contributor('2', 'Subject 1', '1');
        $contributor2 = new Contributor('3', 'Subject 2', '2');
        $contributor3 = new Contributor('4', 'Subject 3', '3');
        $contributor4 = new Contributor('5', 'Subject 4', '4');
        $contributor5 = new Contributor('6', 'Subject 5', '5');

        $collection = new Collection($contributor1, $contributor2);
        $collection->add($contributor3);
        $collection->add($contributor4, $contributor5);

        $this->assertCount(5, $collection);
    }

    public function testJsonSerealize(): void
    {
        $collection = new Collection();
        $data = [
            [
                'personId' => '1',
                'subject' => 'Subject 1',
                'id' => '2'
            ],
            [
                'personId' => '3',
                'subject' => 'Subject 2',
                'id' => '5'
            ],
            [
                'personId' => '4',
                'subject' => 'Subject 3',
                'id' => '5'
            ]
        ];

        foreach($data as $contributorData) {
            $contributor = new Contributor(
                $contributorData['personId'],
                $contributorData['subject'],
                $contributorData['id']
            );
            $collection->add($contributor);
        }

        $this->assertJsonStringEqualsJsonString(
            json_encode($data),
            json_encode($collection)
        );
    }
}
