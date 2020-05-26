<?php

declare(strict_types=1);

namespace Ciebit\Leads\Tests\Entities\Contents;

use Ciebit\Leads\Entities\Contents\Collection;
use Ciebit\Leads\Entities\Contents\Status;
use Ciebit\Leads\Entities\Contents\Webinar;
use Ciebit\Leads\Entities\Topics\Collection as TopicsCollection;
use Ciebit\Leads\Entities\Contributors\Collection as ContributorsCollection;
use DateTime;
use PHPUnit\Framework\TestCase;

class CollectionTest extends TestCase
{
    public function testBasic(): void
    {
        $topics = new TopicsCollection();
        $authors = new ContributorsCollection();
        $guests = new ContributorsCollection();
        $dateTime = new DateTime();
        $status = new Status(Status::ACTIVE);

        $webinar1 = new Webinar(
            'Title 1',
            'title-slug-1',
            'Description 1',
            'Content 1',
            $dateTime,
            $topics,
            $authors,
            $guests,
            '6',
            $status,
            'http://form-link-1.com'
        );
        $webinar2 = new Webinar(
            'Title 2',
            'title-slug-2',
            'Description 2',
            'Content 2',
            $dateTime,
            $topics,
            $authors,
            $guests,
            '7',
            $status,
            'http://form-link-2.com'
        );
        $webinar3 = new Webinar(
            'Title 3',
            'title-slug-3',
            'Description 3',
            'Content 3',
            $dateTime,
            $topics,
            $authors,
            $guests,
            '8',
            $status,
            'http://form-link-3.com'
        );

        $collection = new Collection($webinar1);
        $collection->add($webinar2, $webinar3);

        $this->assertCount(3, $collection);
        $this->assertEquals($webinar1, $collection->getArrayObject()->offsetGet(0));
        $this->assertEquals($webinar2, $collection->getArrayObject()->offsetGet(1));
        $this->assertEquals($webinar3, $collection->getArrayObject()->offsetGet(2));
    }

    public function testJsonSerialize(): void
    {
        $data = [
            [
                'id' => '2',
                'title' => 'Title 01',
                'slug' => 'slug-01',
                'description' => 'Description 01',
                'content' => 'Content 01',
                'dateTime' => '2020-05-26T19:20:42-03:00',
                'topics' => [],
                'authors' => [],
                'guests' => [],
                'coverId' => '5',
                'status' => Status::ACTIVE,
                'formLink' => 'http://form-link-1.com'
            ],
            [
                'id' => '3',
                'title' => 'Title 02',
                'slug' => 'slug-02',
                'description' => 'Description 02',
                'content' => 'Content 02',
                'dateTime' => '2020-04-25T14:23:48-03:00',
                'topics' => [],
                'authors' => [],
                'guests' => [],
                'coverId' => '6',
                'status' => Status::INACTIVE,
                'formLink' => 'http://form-link-2.com'
            ]
        ];

        $collection = new Collection();

        foreach($data as $webinarData) {
            $webinar = new Webinar(
                $webinarData['title'],
                $webinarData['slug'],
                $webinarData['description'],
                $webinarData['content'],
                new DateTime($webinarData['dateTime']),
                new TopicsCollection(),
                new ContributorsCollection(),
                new ContributorsCollection(),
                $webinarData['coverId'],
                new Status($webinarData['status']),
                $webinarData['formLink'],
                $webinarData['id']
            );
            $collection->add($webinar);
        }

        $this->assertJsonStringEqualsJsonString(
            json_encode($data),
            json_encode($collection)
        );
    }
}
