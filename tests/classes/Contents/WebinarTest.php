<?php

declare(strict_types=1);

namespace Ciebit\Leads\Tests\Contents;

use Ciebit\Leads\Contents\Status;
use Ciebit\Leads\Contents\Webinar;
use Ciebit\Leads\Topics\Collection as TopicsCollection;
use Ciebit\Leads\Contributors\Collection as ContributorsCollection;
use DateTime;
use PHPUnit\Framework\TestCase;

class WebinarTest extends TestCase
{
    public function testBasic(): void
    {
        $topics = new TopicsCollection();
        $authors = new ContributorsCollection();
        $guests = new ContributorsCollection();
        $dateTime = new DateTime();
        $status = new Status(Status::ACTIVE);

        $webinar = new Webinar(
            'Title',
            'title-slug',
            'Description',
            'Content',
            $dateTime,
            $topics,
            $authors,
            $guests,
            '5',
            $status,
            'http://form-link.com'
        );

        $this->assertEquals('Title', $webinar->getTitle());
        $this->assertEquals('title-slug', $webinar->getSlug());
        $this->assertEquals('Description', $webinar->getDescription());
        $this->assertEquals('Content', $webinar->getContent());
        $this->assertEquals($dateTime, $webinar->getDateTime());
        $this->assertEquals($topics, $webinar->getTopics());
        $this->assertEquals($authors, $webinar->getAuthors());
        $this->assertEquals($guests, $webinar->getGuests());
        $this->assertEquals(5, $webinar->getCoverId());
        $this->assertEquals($status, $webinar->getStatus());
        $this->assertEquals('http://form-link.com', $webinar->getFormLink());
    }
}
