<?php

declare(strict_types=1);

namespace Ciebit\Leads\Tests\Entities\Records;

use Ciebit\Leads\Entities\Records\Record;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

class RecordTest extends TestCase
{
    public function testBasic(): void
    {
        $id = '3';
        $name = 'Name';
        $email = 'contact@mail.com';
        $phone = '88123451234';
        $profileId = 2;
        $dateTime = new DateTimeImmutable();
        $record = new Record($id, $name, $email, $phone, $profileId, $dateTime, $id);

        $this->assertEquals($id, $record->getId());
        $this->assertEquals($name, $record->getName());
        $this->assertEquals($email, $record->getEmail());
        $this->assertEquals($phone, $record->getPhone());
        $this->assertEquals($profileId, $record->getProfileId());
    }
}
