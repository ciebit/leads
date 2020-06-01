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
        $contentId = '2';
        $id = '3';
        $name = 'Name';
        $email = 'contact@mail.com';
        $phone = '88123451234';
        $profileId = 2;
        $dateTime = new DateTimeImmutable();
        $record = new Record($contentId, $name, $email, $phone, $profileId, $dateTime, $id);

        $this->assertEquals($id, $record->getId());
        $this->assertEquals($contentId, $record->getContentId());
        $this->assertEquals($name, $record->getName());
        $this->assertEquals($email, $record->getEmail());
        $this->assertEquals($phone, $record->getPhone());
        $this->assertEquals($profileId, $record->getProfileId());
    }

    public function testJsonSerealize(): void
    {
        $data = [
            'contentId' => '4',
            'id' => '1',
            'name' => 'Name',
            'email' => 'contact@mail.com',
            'phone' => '0012341234',
            'profileId' => 3,
            'dateTime' => '2020-05-26T16:20:22-03:00'
        ];

        $record = new Record(
            $data['contentId'], 
            $data['name'], 
            $data['email'], 
            $data['phone'], 
            $data['profileId'], 
            new DateTimeImmutable($data['dateTime']), 
            $data['id']
        );

        $this->assertJsonStringEqualsJsonString(
            json_encode($data),
            json_encode($record)
        );
    }
}
