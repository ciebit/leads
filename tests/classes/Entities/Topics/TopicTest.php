<?php

declare(strict_types=1);

namespace Ciebit\Leads\Entities\Tests\Topics;

use Ciebit\Leads\Entities\Topics\Topic;
use PHPUnit\Framework\TestCase;

class TopicTest extends TestCase
{
    public function testBasic(): void
    {
        $topic = new Topic('Title');
        $this->assertEquals('Title', $topic->getTitle());
    }

    public function testJsonSerialize(): void
    {
        $topic = new Topic('Title');
        $this->assertJsonStringEqualsJsonString(
            json_encode(['title' => 'Title']),
            json_encode($topic)
        );
    }
}