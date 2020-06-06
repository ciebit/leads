<?php

declare(strict_types=1);

namespace Ciebit\Leads\Entities\Contents;

use Ciebit\Leads\Entities\Contents\Content;
use Ciebit\Leads\Entities\Contents\Status;
use Ciebit\Leads\Entities\Contributors\Collection as ContributorsCollection;
use Ciebit\Leads\Entities\DateTime\DateTime;
use Ciebit\Leads\Entities\Topics\Collection as TopicsCollection;
use DateTimeInterface;

final class Ebook implements Content
{
    public const TYPE = 'ebook';

    private ContributorsCollection $authors;
    private string $content;
    private string $coverId;
    private DateTime $dateTime;
    private string $description;
    private string $externalShareCoverId;
    private string $id;
    private string $slug;
    private Status $status;
    private string $title;
    private TopicsCollection $topics;

    public function __construct(
        string $title,
        string $slug,
        string $description,
        string $content,
        DateTime $dateTime,
        TopicsCollection $topics,
        ContributorsCollection $authors,
        string $coverId,
        string $externalShareCoverId = '',
        Status $status,
        string $formLink,
        string $id = ''
    ) {
        $this->authors = $authors;
        $this->content = $content;
        $this->coverId = $coverId;
        $this->dateTime = $dateTime;
        $this->description = $description;
        $this->externalShareCoverId = $externalShareCoverId;
        $this->formLink = $formLink;
        $this->id = $id;
        $this->slug = $slug;
        $this->status = $status;
        $this->title = $title;
        $this->topics = $topics;
    }

    public function getAuthors(): ContributorsCollection
    {
        return clone $this->authors;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getCoverId(): string
    {
        return $this->coverId;
    }

    public function getDateTime(): DateTime
    {
        return clone $this->dateTime;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getExternalShareCoverId(): string
    {
        return $this->externalShareCoverId;
    }

    public function getFormLink(): string
    {
        return $this->formLink;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function getStatus(): Status
    {
        return $this->status;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getTopics(): TopicsCollection
    {
        return clone $this->topics;
    }

    public function getType(): string
    {
        return self::TYPE;
    }

    public function jsonSerialize(): array
    {
        return [
            'authors' => $this->getAuthors(),
            'content' => $this->getContent(),
            'coverId' => $this->getCoverId(),
            'dateTime' => $this->getDateTime()->format(DateTimeInterface::W3C),
            'description' => $this->getDescription(),
            'externalShareCoverId' => $this->getExternalShareCoverId(),
            'formLink' => $this->getFormLink(),
            'id' => $this->getId(),
            'slug' => $this->getSlug(),
            'status' => $this->getStatus()->getValue(),
            'title' => $this->getTitle(),
            'topics' => $this->getTopics(),
        ];
    }
}
