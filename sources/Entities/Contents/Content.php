<?php

declare(strict_types=1);

namespace Ciebit\Leads\Entities\Contents;

use Ciebit\Leads\Entities\Contents\Status;
use Ciebit\Leads\Entities\Contributors\Collection as ContributorsCollection;
use Ciebit\Leads\Entities\Topics\Collection as TopicsCollection;

interface Content
{
    public function getAuthors(): ContributorsCollection;

    public function getContent(): string;

    public function getDescription(): string;

    public function getId(): string;

    public function getStatus(): Status;
    
    public function getTitle(): string;

    public function getType(): string;
    
    public function getTopics(): TopicsCollection;
}