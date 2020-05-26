<?php

declare(strict_types=1);

namespace Ciebit\Leads\Tests\Entities\Contents;

use Ciebit\Leads\Entities\Contents\Status;
use Ciebit\Leads\Entities\Contents\Webinar;
use Ciebit\Leads\Entities\Topics\Collection as TopicsCollection;
use Ciebit\Leads\Entities\Contributors\Collection as ContributorsCollection;
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

    public function testJsonSerialize(): void
    {
        $data = [
            'id' => '2',
            'title' => 'Title',
            'slug' => 'title-slug',
            'description' => 'Description',
            'content' => 'Content',
            'dateTime' => '2020-05-26T19:20:42-03:00',
            'topics' => [],
            'authors' => [],
            'guests' => [],
            'coverId' => '5',
            'status' => Status::ACTIVE,
            'formLink' => 'http://form-link.com'
        ];

        $webinar = new Webinar(
            $data['title'],
            $data['slug'],
            $data['description'],
            $data['content'],
            new DateTime($data['dateTime']),
            new TopicsCollection(),
            new ContributorsCollection(),
            new ContributorsCollection(),
            $data['coverId'],
            new Status($data['status']),
            $data['formLink'],
            $data['id']
        );

        $this->assertJsonStringEqualsJsonString(
            json_encode($data),
            json_encode($webinar)
        );
    }
}
