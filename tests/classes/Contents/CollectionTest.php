<?php

declare(strict_types=1);

namespace Ciebit\Leads\Tests\Contents;

use Ciebit\Leads\Contents\Collection;
use Ciebit\Leads\Contents\Status;
use Ciebit\Leads\Contents\Webinar;
use Ciebit\Leads\Topics\Collection as TopicsCollection;
use Ciebit\Leads\Contributors\Collection as ContributorsCollection;
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
}