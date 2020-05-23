<?php

declare(strict_types=1);

namespace Ciebit\Leads\Records;

use Ciebit\Leads\Records\Record;
use DateTimeImmutable;

final class Builder
{
    private string $contentId;
    private DateTimeImmutable $dateTime;
    private string $email;
    private string $id;
    private string $name;
    private string $phone;
    private int $profileId;

    public function __construct() {
        $this->contentId = '';
        $this->dateTime = new DateTimeImmutable();
        $this->name = '';
        $this->email = '';
        $this->id = '';
        $this->phone = '';
        $this->profileId = 0;
    }

    public function build(): Record
    {
        return new Record(
            $this->contentId,
            $this->name,
            $this->email,
            $this->phone,
            $this->profileId,
            $this->dateTime,
            $this->id
        );
    }

    public function copy(Record $record): self
    {
        $this->id = $record->getId();
        $this->name = $record->getName();
        $this->email = $record->getEmail();
        $this->phone = $record->getPhone();
        $this->profileId = $record->getProfileId();
        $this->contentId = $record->getContentId();
        $this->dateTime = $record->getDateTime();
        
        return $this;
    }

    public function setContentId(string $value): self
    {
        $this->contentId = $value;
        return $this;
    }

    public function setDateTime(DateTimeImmutable $dateTime): self
    {
        $this->dateTime = $dateTime;
        return $this;
    }

    public function setEmail(string $value): self
    {
        $this->email = $value;
        return $this;
    }

    public function setId(string $value): self
    {
        $this->id = $value;
        return $this;
    }

    public function setName(string $value): self
    {
        $this->name = $value;
        return $this;
    }

    public function setPhone(string $value): self
    {
        $this->phone = $value;
        return $this;
    }

    public function setProfileId(int $value): self
    {
        $this->profileId = $value;
        return $this;
    }
}
