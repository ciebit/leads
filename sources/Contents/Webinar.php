<?php

declare(strict_types=1);

namespace Ciebit\Leads\Contents;

use Ciebit\Leads\Contents\Content;
use Ciebit\Leads\Contents\Status;
use Ciebit\Leads\Contributors\Collection as ContributorsCollection;
use Ciebit\Leads\Topics\Collection as TopicsCollection;
use DateTimeInterface;

final class Webinar implements Content
{
    public const TYPE = 'webinar';

    private ContributorsCollection $authors;
    private string $content;
    private string $coverId;
    private DateTimeInterface $dateTime;
    private string $description;
    private string $formLink;
    private ContributorsCollection $guests;
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
        DateTimeInterface $dateTime,
        TopicsCollection $topics,
        ContributorsCollection $authors,
        ContributorsCollection $guests,
        string $coverId,
        Status $status,
        string $formLink,
        string $id = ''
    ) {
        $this->authors = $authors;
        $this->content = $content;
        $this->coverId = $coverId;
        $this->dateTime = $dateTime;
        $this->description = $description;
        $this->formLink = $formLink;
        $this->guests = $guests;
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

    public function getDateTime(): DateTimeInterface
    {
        return clone $this->dateTime;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getFormLink(): string
    {
        return $this->formLink;
    }

    public function getGuests(): ContributorsCollection
    {
        return clone $this->guests;
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
}
