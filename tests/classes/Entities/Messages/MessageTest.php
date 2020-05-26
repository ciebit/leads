<?php

declare(strict_types=1);

namespace Ciebit\Leads\Tests\Entities\Records;

use Ciebit\Leads\Entities\Messages\Message;
use PHPUnit\Framework\TestCase;

class MessageTest extends TestCase
{
    public function testBasic(): void
    {
        $id = '3';
        $body = '<p>Mensagem</p>';
        $contentId = '4';
        $message = new Message(
            $contentId,
            $body,
            $id
        );

        $this->assertEquals($body, $message->getBody());
        $this->assertEquals($contentId, $message->getContentId());
        $this->assertEquals($id, $message->getId());
    }

    public function testJsonSerealize(): void
    {
        $data = [
            'id' => '3',
            'body' => '<p>Mensagem</p>',
            'contentId' => '4',
        ];

        $message = new Message(
            $data['contentId'],
            $data['body'],
            $data['id']
        );

        $this->assertJsonStringEqualsJsonString(
            json_encode($data),
            json_encode($message)
        );
    }
}
