<?php

declare(strict_types=1);

namespace Ciebit\Leads\Builders\Contents;

use Ciebit\Leads\Builders\Contents\Data;
use Ciebit\Leads\Builders\Contents\Strategy;
use Ciebit\Leads\Entities\Contents\Webinar as WebinarEntitie;
use Ciebit\Leads\Entities\Contents\Content;

final class Webinar implements Strategy
{
    public const TYPE = WebinarEntitie::TYPE;

    public function build(Data $data): Content
    {
        return new WebinarEntitie(
            $data->title,
            $data->slug,
            $data->description,
            $data->content,
            $data->dateTime,
            $data->topics,
            $data->authors,
            $data->guests,
            $data->coverId,
            $data->status,
            $data->formLink,
            $data->id
        );
    }
}
