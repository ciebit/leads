<?php

declare(strict_types=1);

namespace Ciebit\Leads\Tests\Entities\Contributors;

use Ciebit\Leads\Entities\Contributors\Contributor;
use PHPUnit\Framework\TestCase;

class ContributorTest extends TestCase
{
    public function testBasic(): void
    {
        $contributor = new Contributor('2', 'Subject', '1');
        $this->assertEquals('1', $contributor->getId());
        $this->assertEquals('2', $contributor->getPersonId());
        $this->assertEquals('Subject', $contributor->getSubject());
    }
}
