<?php

declare(strict_types=1);

namespace Ciebit\Leads\Messages;

final class Message
{
    private string $body;
    private string $contentId;
    private string $id;

    public function __construct(
        string $contentId,
        string $body,
        string $id = ''
    ) {
        $this->body = $body;
        $this->contentId = $contentId;
        $this->id = $id;
    }

    public function getBody(): string
    {
        return $this->body;
    }

    public function getContentId(): string
    {
        return $this->contentId;
    }

    public function getId(): string
    {
        return $this->id;
    }
}