<?php

declare(strict_types=1);

namespace Ciebit\Leads\Tests\Entities\Contents;

use Ciebit\Leads\Entities\Contents\Status;
use Ciebit\Leads\Entities\Contents\Ebook;
use Ciebit\Leads\Entities\Contributors\Collection as ContributorsCollection;
use Ciebit\Leads\Entities\DateTime\Defined as DateTimeDefined;
use Ciebit\Leads\Entities\DateTime\Undefined as DateTimeUndefined;
use Ciebit\Leads\Entities\Topics\Collection as TopicsCollection;
use PHPUnit\Framework\TestCase;

class EbookTest extends TestCase
{
    public function testBasic(): void
    {
        $topics = new TopicsCollection();
        $authors = new ContributorsCollection();
        $dateTime = new DateTimeUndefined();
        $status = new Status(Status::ACTIVE);

        $ebook = new Ebook(
            'Title',
            'title-slug',
            'Description',
            'Content',
            $dateTime,
            $topics,
            $authors,
            '5',
            '55',
            $status,
            'http://form-link.com'
        );

        $this->assertEquals('Title', $ebook->getTitle());
        $this->assertEquals('title-slug', $ebook->getSlug());
        $this->assertEquals('Description', $ebook->getDescription());
        $this->assertEquals('Content', $ebook->getContent());
        $this->assertEquals($dateTime, $ebook->getDateTime());
        $this->assertEquals($topics, $ebook->getTopics());
        $this->assertEquals($authors, $ebook->getAuthors());
        $this->assertEquals(5, $ebook->getCoverId());
        $this->assertEquals($status, $ebook->getStatus());
        $this->assertEquals('http://form-link.com', $ebook->getFormLink());
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
            'coverId' => '5',
            'externalShareCoverId' => '55',
            'status' => Status::ACTIVE,
            'formLink' => 'http://form-link.com'
        ];

        $ebook = new Ebook(
            $data['title'],
            $data['slug'],
            $data['description'],
            $data['content'],
            new DateTimeDefined($data['dateTime']),
            new TopicsCollection(),
            new ContributorsCollection(),
            $data['coverId'],
            $data['externalShareCoverId'],
            new Status($data['status']),
            $data['formLink'],
            $data['id']
        );

        $this->assertJsonStringEqualsJsonString(
            json_encode($data),
            json_encode($ebook)
        );
    }
}
