<?php

declare(strict_types=1);

namespace Ciebit\Leads\Builders\Contents;

use Ciebit\Leads\Builders\Contents\Data;
use Ciebit\Leads\Builders\Contents\Strategy;
use Ciebit\Leads\Entities\Contents\Ebook as EbookEntitie;
use Ciebit\Leads\Entities\Contents\Content;

final class Ebook implements Strategy
{
    public const TYPE = EbookEntitie::TYPE;

    public function build(Data $data): Content
    {
        return new EbookEntitie(
            $data->title,
            $data->slug,
            $data->description,
            $data->content,
            $data->dateTime,
            $data->topics,
            $data->authors,
            $data->coverId,
            $data->externalShareCoverId,
            $data->status,
            $data->formLink,
            $data->id
        );
    }
}
