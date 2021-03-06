<?php

declare(strict_types=1);

namespace Ciebit\Leads\Entities\Records;

use DateTimeImmutable;
use DateTimeInterface;
use JsonSerializable;

final class Record implements JsonSerializable
{
    private string $contentId;
    private DateTimeImmutable $dateTime;
    private string $email;
    private string $id;
    private string $name;
    private string $phone;
    private int $profileId;

    public function __construct(
        string $contentId,
        string $name,
        string $email,
        string $phone,
        int $profileId,
        DateTimeImmutable $dateTime = null,
        string $id = ''
    ) {
        $this->contentId = $contentId;
        $this->dateTime = $dateTime == null 
            ? new DateTimeImmutable() 
            : $dateTime;
        $this->name = $name;
        $this->email = $email;
        $this->id = $id;
        $this->phone = $phone;
        $this->profileId = $profileId;
    }

    public function getContentId(): string
    {
        return $this->contentId;
    }

    public function getDateTime(): DateTimeImmutable
    {
        return $this->dateTime;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function getProfileId(): int
    {
        return $this->profileId;
    }

    public function jsonSerialize(): array
    {
        return [
            'contentId' => $this->getContentId(),
            'dateTime' => $this->getDateTime()->format(DateTimeInterface::W3C),
            'email' => $this->getEmail(),
            'id' => $this->getId(),
            'name' => $this->getName(),
            'phone' => $this->getPhone(),
            'profileId' => $this->getProfileId(),
        ];
    }
}
