<?php

declare(strict_types=1);

namespace Ciebit\Leads\Builders\Contents;

use Ciebit\Leads\Entities\Contents\Status;
use Ciebit\Leads\Entities\Contributors\Collection as ContributorsCollection;
use Ciebit\Leads\Entities\DateTime\DateTime;
use Ciebit\Leads\Entities\DateTime\Undefined as DateTimeUndefined;
use Ciebit\Leads\Entities\Topics\Collection as TopicsCollection;

final class Data
{
    public ContributorsCollection $authors;
    public string $content;
    public string $coverId;
    public DateTime $dateTime;
    public string $description;
    public string $formLink;
    public ContributorsCollection $guests;
    public string $id;
    public string $slug;
    public Status $status;
    public string $title;
    public string $type;
    public TopicsCollection $topics;

    public function __construct()
    {
        $this->authors = new ContributorsCollection();
        $this->content = '';
        $this->coverId = '';
        $this->dateTime = new DateTimeUndefined();
        $this->description = '';
        $this->formLink = '';
        $this->guests = new ContributorsCollection();
        $this->id = '';
        $this->slug = '';
        $this->status = new Status(Status::INACTIVE);
        $this->title = '';
        $this->type = '';
        $this->topics = new TopicsCollection();
    }
}