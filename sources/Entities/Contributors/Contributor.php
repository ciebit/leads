<?php

declare(strict_types=1);

namespace Ciebit\Leads\Entities\Contributors;

use JsonSerializable;

final class Contributor implements JsonSerializable
{
    private string $id;
    private string $personId;
    private string $subject;

    public function __construct(
        string $personId,
        string $subject,
        string $id
    ) {
        $this->personId = $personId;
        $this->subject = $subject;
        $this->id = $id;
    }

    public function getId(): string
    {
        return $this->id;
    }
    
    public function getPersonId(): string
    {
        return $this->personId;
    }

    public function getSubject(): string
    {
        return $this->subject;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->getId(),
            'personId' => $this->getPersonId(),
            'subject' => $this->getSubject(),
        ];
    }
}