<?php

declare(strict_types=1);

namespace Ciebit\Leads\Contributors;

final class Contributor
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
}