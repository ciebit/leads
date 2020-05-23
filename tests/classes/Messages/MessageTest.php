<?php

declare(strict_types=1);

namespace Ciebit\Leads\Tests\Records;

use Ciebit\Leads\Messages\Message;
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
}