<?php

declare(strict_types=1);

namespace Ciebit\Leads\Storages\Records\Database;

use Ciebit\Leads\Entities\Records\Builder;
use Ciebit\Leads\Entities\Records\Record;
use Ciebit\Leads\Exceptions\Storage as ExceptionStorage;
use Ciebit\Leads\Storages\Records\Database\Database;
use PDO;

final class Sql implements Database
{
    private const COLUMN_CONTENT_ID = 'content_id';
    private const COLUMN_DATE_TIME = 'date_time';
    private const COLUMN_EMAIL = 'email';
    private const COLUMN_ID = 'id';
    private const COLUMN_NAME = 'name';
    private const COLUMN_PHONE = 'phone';
    private const COLUMN_PROFILE_ID = 'profile_id';
    private const EXCEPTION_PREFIX = 'app.storages.leads.records';

    private PDO $pdo;
    private string $table;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->table = 'leads_records';
    }

    public function store(Record $record): Record
    {
        $fields = implode('`,`', [
            self::COLUMN_CONTENT_ID,
            self::COLUMN_NAME,
            self::COLUMN_EMAIL,
            self::COLUMN_PHONE,
            self::COLUMN_PROFILE_ID,
            self::COLUMN_DATE_TIME,
        ]);

        $sqlQuery = "
            INSERT INTO `{$this->table}` (
                `{$fields}`
            ) VALUES (
                :content_id,
                :name,
                :email,
                :phone,
                :profile_id,
                :date_time
            )
        ";

        $statement = $this->pdo->prepare($sqlQuery);

        if ($statement === false) {
            throw new ExceptionStorage(self::EXCEPTION_PREFIX . '.sintaxe-error', 1);
        }

        /** @var \PDOStatement $statement */

        $statement->bindValue(':content_id', $record->getContentId(), PDO::PARAM_INT);
        $statement->bindValue(':name', $record->getName(), PDO::PARAM_STR);
        $statement->bindValue(':email', $record->getEmail(), PDO::PARAM_STR);
        $statement->bindValue(':phone', $record->getPhone(), PDO::PARAM_STR);
        $statement->bindValue(':profile_id', $record->getProfileId(), PDO::PARAM_INT);
        $statement->bindValue(':date_time', $record->getDateTime()->format('Y-m-d H:i:s'), PDO::PARAM_STR);

        if ($statement->execute() === false) {
            error_log($statement->errorInfo()[2]);
            throw new ExceptionStorage(self::EXCEPTION_PREFIX . '.execute-error', 2);
        }

        $id = $this->pdo->lastInsertId();

        $builder = new Builder();
        $builder->copy($record);
        $builder->setId($id);

        return $builder->build();
    }
}
