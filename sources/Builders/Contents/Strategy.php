<?php

declare(strict_types=1);

namespace Ciebit\Leads\Builders\Contents;

use Ciebit\Leads\Entities\Contents\Content;
use Ciebit\Leads\Builders\Contents\Data;

interface Strategy
{
    public function build(Data $data): Content;
}