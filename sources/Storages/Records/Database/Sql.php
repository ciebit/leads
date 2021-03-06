<?php

declare(strict_types=1);

namespace Ciebit\Leads\Storages\Records\Database;

use Ciebit\Leads\Entities\Records\Builder;
use Ciebit\Leads\Entities\Records\Collection;
use Ciebit\Leads\Entities\Records\Record;
use Ciebit\Leads\Exceptions\Storage as ExceptionStorage;
use Ciebit\Leads\Storages\Records\Database\Database;
use DateTimeImmutable;
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

    private string $filterContentId;
    private string $filterId;
    private int $limit;
    private int $offset;
    private array $order;
    private PDO $pdo;
    private string $table;

    public function __construct(PDO $pdo)
    {
        $this->filterContentId = '';
        $this->filterId = '';
        $this->limit = 30;
        $this->offset = 0;
        $this->order = [];
        $this->pdo = $pdo;
        $this->table = 'leads_records';
    }

    public function addFilterByContentId(string $id): self
    {
        $this->filterContentId = $id;
        return $this;
    }

    public function addFilterById(string $id): self
    {
        $this->filterId = $id;
        return $this;
    }

    public function addOrderBy(string $column, string $order = 'ASC'): self
    {
        $this->order[] = [$column, $order];
        return $this;
    }

    public function find(): Collection
    {
        $filters = [];
        $sqlWhere = '1';
        $sqlOrder = '';

        if ($this->filterContentId != '') {
            $column = self::COLUMN_CONTENT_ID;
            $filters[] = "`{$this->table}`.`{$column}` = :content_id";
        }

        if ($this->filterId != '') {
            $column = self::COLUMN_ID;
            $filters[] = "`{$this->table}`.`{$column}` = :id";
        }

        if (empty($filters) == false) {
            $sqlWhere = implode(' AND ', $filters);
        }

        if (count($this->order) > 0) {
            $order = array_map(fn($orderItem) => implode(' ', $orderItem), $this->order);
            $sqlOrder = "ORDER BY ". implode(',', $order);
        }

        $querySql = "SELECT `{$this->table}`.*
            FROM `{$this->table}`
            WHERE {$sqlWhere}
            {$sqlOrder}
            LIMIT {$this->offset}, {$this->limit}";

        $statement = $this->pdo->prepare($querySql);

        if ($statement === false) {
            throw new ExceptionStorage(self::EXCEPTION_PREFIX . '.sintaxe-error', 1);
        }

        /** @var \PDOStatement $statement */

        if ($this->filterContentId != '') {
            $statement->bindValue(':content_id', $this->filterContentId, PDO::PARAM_INT);
        }

        if ($this->filterId != '') {
            $statement->bindValue(':id', $this->filterId, PDO::PARAM_INT);
        }

        if ($statement->execute() === false) {
            if (isset($statement->errorInfo()[2])) {
                error_log($statement->errorInfo()[2]);
            }
            throw new ExceptionStorage(self::EXCEPTION_PREFIX . '.execute-error', 2);
        }

        $data = $statement->fetchAll(PDO::FETCH_ASSOC);

        if (!is_array($data)) {
            error_log('Fetch error: ' . $querySql);
            throw new ExceptionStorage(self::EXCEPTION_PREFIX . '.fetch-error', 3);
        }

        return $this->build($data);
    }

    public function setLimit(int $limit): self
    {
        $this->limit = $limit;
        return $this;
    }

    public function setOffset(int $offset): self
    {
        $this->offset = $offset;
        return $this;
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

    private function build(array $data): Collection
    {
        $collection = new Collection();

        foreach($data as $recordData) {
            $record = $this->buildRecord($recordData);
            $collection->add($record);
        }

        return $collection;
    }

    private function buildRecord(array $recordData): Record
    {
        $builder = new Builder();

        $builder
            ->setId($recordData[self::COLUMN_ID])
            ->setContentId($recordData[self::COLUMN_CONTENT_ID])
            ->setEmail($recordData[self::COLUMN_EMAIL])
            ->setName($recordData[self::COLUMN_NAME])
            ->setPhone($recordData[self::COLUMN_PHONE])
            ->setProfileId((int) $recordData[self::COLUMN_PROFILE_ID])
            ->setDateTime(new DateTimeImmutable($recordData[self::COLUMN_DATE_TIME]));
        
        return $builder->build();
    }
}
