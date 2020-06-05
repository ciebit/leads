<?php

declare(strict_types=1);

namespace Ciebit\Leads\Builders\Contents;

use Ciebit\Leads\Builders\Contents\Data;
use Ciebit\Leads\Builders\Contents\Ebook as EbookBuilder;
use Ciebit\Leads\Builders\Contents\Strategy;
use Ciebit\Leads\Builders\Contents\Webinar as WebinarBuilder;
use Ciebit\Leads\Entities\Contents\Content;
use Ciebit\Leads\Exceptions\Builder as ExceptionBuilder;

final class Context
{
    public function build(Data $data): Content
    {
        $strategy = $this->discoveryStrategy($data);
        return $strategy->build($data);
    }

    /**
     * @throws ExceptionBuilder
     */
    private function discoveryStrategy(Data $data): Strategy
    {
        switch($data->type) {
            case WebinarBuilder::TYPE:
                return new WebinarBuilder();
            case EbookBuilder::TYPE:
                return new EbookBuilder();
        }

        error_log('Unknow type of Content: ' . $data->type);
        throw new ExceptionBuilder('ciebit.leads.builder.content.unknow', 1);
    }
}
