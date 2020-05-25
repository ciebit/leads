<?php

declare(strict_types=1);

namespace Ciebit\Leads\Storages\Messages\Database;

use Ciebit\Leads\Entities\Messages\Collection;
use Ciebit\Leads\Entities\Messages\Message;
use Ciebit\Leads\Exceptions\Storage as ExceptionStorage;
use Ciebit\Leads\Storages\Messages\Database\Database;
use PDO;

final class Sql implements Database
{
    private const COLUMN_CONTENT_ID = 'content_id';
    private const COLUMN_BODY = 'body';
    private const COLUMN_ID = 'id';
    private const EXCEPTION_PREFIX = 'app.storages.leads.messages';

    private string $filterContentById;
    private PDO $pdo;
    private string $table;

    public function __construct(PDO $pdo)
    {
        $this->filterContentById = '';
        $this->pdo = $pdo;
        $this->table = 'leads_messages';
    }

    public function addFilterByContentId(string $id): self
    {
        $this->filterContentById = $id;
        return $this;
    }

    private function bind(array $data): Collection
    {
        $collection = new Collection();

        foreach($data as $item) {
            $collection->add(
                new Message(
                    $item[self::COLUMN_CONTENT_ID],
                    $item[self::COLUMN_BODY],
                    $item[self::COLUMN_ID]
                )
            );
        }

        return $collection;
    }

    public function find(): Collection
    {
        $sqlWhere = '1';

        if ($this->filterContentById != '') {
            $column = self::COLUMN_CONTENT_ID;
            $sqlWhere = "`{$this->table}`.`{$column}` = :contentId";
        }

        $querySql = "SELECT `{$this->table}`.*
            FROM `{$this->table}`
            WHERE {$sqlWhere}";

        $statement = $this->pdo->prepare($querySql);

        if ($statement === false) {
            throw new ExceptionStorage(self::EXCEPTION_PREFIX . '.sintaxe-error', 1);
        }

        /** @var \PDOStatement $statement */

        if ($this->filterContentById != '') {
            $statement->bindValue(':contentId', $this->filterContentById, PDO::PARAM_STR);
        }

        if ($statement->execute() === false) {
            error_log($statement->errorInfo()[2]);
            throw new ExceptionStorage(self::EXCEPTION_PREFIX . '.execute-error', 2);
        }

        $data = $statement->fetchAll(PDO::FETCH_ASSOC);

        if (is_array($data) == false) {
            error_log('Fetch error: ' . $querySql);
            throw new ExceptionStorage(self::EXCEPTION_PREFIX . '.fetch-error', 3);
        }

        return $this->bind($data);
    }
}
