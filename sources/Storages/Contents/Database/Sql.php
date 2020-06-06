<?php

declare(strict_types=1);

namespace Ciebit\Leads\Storages\Contents\Database;

use Ciebit\Leads\Builders\Contents\Context as ContextBuilder;
use Ciebit\Leads\Builders\Contents\Data as BuilderData;
use Ciebit\Leads\Entities\Contents\Collection;
use Ciebit\Leads\Entities\Contents\Content;
use Ciebit\Leads\Entities\Contents\Status;
use Ciebit\Leads\Entities\Contributors\Contributor;
use Ciebit\Leads\Entities\Contributors\Collection as ContributorCollection;
use Ciebit\Leads\Entities\DateTime\Defined as DateTimeDefined;
use Ciebit\Leads\Entities\Topics\Collection as TopicsCollection;
use Ciebit\Leads\Entities\Topics\Topic;
use Ciebit\Leads\Exceptions\Storage as ExceptionStorage;
use Ciebit\Leads\Storages\Contents\Database\Database;
use PDO;

use function is_array;

final class Sql implements Database
{
    private const COLUMN_AUTHORS = 'authors';
    private const COLUMN_GUESTS = 'guests';
    private const COLUMN_CONTENT = 'content';
    private const COLUMN_COVER_ID = 'cover_id';
    private const COLUMN_DESCRIPTION = 'description';
    private const COLUMN_DATE_TIME = 'date_time';
    private const COLUMN_EXTERNAL_SHARE_COVER_ID = 'external_share_cover_id';
    private const COLUMN_FORM_LINK = 'form_link';
    private const COLUMN_ID = 'id';
    private const COLUMN_SLUG = 'slug';
    private const COLUMN_STATUS = 'status';
    private const COLUMN_TITLE = 'title';
    private const COLUMN_TYPE = 'type';
    private const COLUMN_TOPICS = 'topics';
    private const CONTRIBUTOR_ID = 'id';
    private const CONTRIBUTOR_PERSON_ID = 'person_id';
    private const CONTRIBUTOR_SUBJECT = 'subject';
    private const EXCEPTION_PREFIX = 'app.storages.leads.contents';
    private const TOPIC_TITLE = 'title';

    private string $filterId;
    private string $filterSlug;
    private ?Status $filterStatus;
    private string $filterType;
    private PDO $pdo;
    private string $table;

    public function __construct(PDO $pdo)
    {
        $this->filterId = '';
        $this->filterSlug = '';
        $this->filterStatus = null;
        $this->filterType = '';
        $this->pdo = $pdo;
        $this->table = 'leads_content_view';
    }

    public function addFilterById(string $id): self
    {
        $this->filterId = $id;
        return $this;
    }

    public function addFilterBySlug(string $slug): self
    {
        $this->filterSlug = $slug;
        return $this;
    }

    public function addFilterByStatus(Status $status): self
    {
        $this->filterStatus = $status;
        return $this;
    }

    public function addFilterByType(string $type): self
    {
        $this->filterType = $type;
        return $this;
    }

    private function bind(array $data): Collection
    {
        $collection = new Collection();

        foreach($data as $contentData) {
            if (is_array($contentData)) {
                $content = $this->bindContent($contentData);
                $collection->add($content);
            }
        }

        return $collection;
    }

    private function bindContent(array $data): Content
    {
        $builderData = new BuilderData();
        $builderData->id = (string) $data[self::COLUMN_ID];
        $builderData->title = (string) $data[self::COLUMN_TITLE];
        $builderData->slug = (string) $data[self::COLUMN_SLUG];
        $builderData->description = (string) $data[self::COLUMN_DESCRIPTION];
        $builderData->content = (string) $data[self::COLUMN_CONTENT];
        $builderData->coverId = (string) $data[self::COLUMN_COVER_ID];
        $builderData->externalShareCoverId = (string) $data[self::COLUMN_EXTERNAL_SHARE_COVER_ID];
        $builderData->formLink = (string) $data[self::COLUMN_FORM_LINK];
        $builderData->type = (string) $data[self::COLUMN_TYPE];
        $builderData->topics = $this->bindTopicCollection((string) $data[self::COLUMN_TOPICS]);
        $builderData->authors = $this->bindContributorCollection((string) $data[self::COLUMN_AUTHORS]);
        $builderData->guests = $this->bindContributorCollection((string) $data[self::COLUMN_GUESTS]);


        if (empty($data[self::COLUMN_DATE_TIME]) == false) {
            $builderData->dateTime = new DateTimeDefined($data[self::COLUMN_DATE_TIME]);
        }

        $status = (int) $data[self::COLUMN_STATUS];

        if (Status::isValid($status)) {
            $builderData->status = new Status($status);
        }

        $builder = new ContextBuilder();

        return $builder->build($builderData);
    }

    private function bindContributor(array $data): Contributor
    {
        $personId = (string) ($data[self::CONTRIBUTOR_PERSON_ID] ?? '');
        $subject = (string) ($data[self::CONTRIBUTOR_SUBJECT] ?? '');
        $id = (string) ($data[self::CONTRIBUTOR_ID] ?? '');

        return new Contributor($personId, $subject, $id);
    }

    private function bindContributorCollection(string $data): ContributorCollection
    {
        $collection = new ContributorCollection();

        $dataList = json_decode($data, true);

        if (! is_array($dataList)) {
            return $collection;
        }

        foreach ($dataList as $contributorData) {
            if (is_array($contributorData)) {
                $contributor = $this->bindContributor($contributorData);
                $collection->add($contributor);
            }
        }

        return $collection;
    }

    private function bindTopic(array $data): Topic
    {
        $title = (string) ($data[self::TOPIC_TITLE] ?? '');
        return new Topic($title);
    }

    private function bindTopicCollection(string $data): TopicsCollection
    {
        $collection = new TopicsCollection();

        $dataList = json_decode($data, true);

        if (!is_array($dataList)) {
            return $collection;
        }

        foreach($dataList as $topicData) {
            if (is_array($topicData)) {
                $topic = $this->bindTopic($topicData);
                $collection->add($topic);
            }
        }

        return $collection;
    }

    public function find(): Collection
    {
        $filters = [];
        $sqlWhere = '1';

        if ($this->filterSlug != '') {
            $column = self::COLUMN_SLUG;
            $filters[] = "`{$this->table}`.`{$column}` = :slug";
        }

        if ($this->filterId != '') {
            $column = self::COLUMN_ID;
            $filters[] = "`{$this->table}`.`{$column}` = :id";
        }

        if ($this->filterStatus != null) {
            $column = self::COLUMN_STATUS;
            $filters[] = "`{$this->table}`.`{$column}` = :status";
        }

        if ($this->filterType != null) {
            $column = self::COLUMN_TYPE;
            $filters[] = "`{$this->table}`.`{$column}` = :type";
        }

        if (empty($filters) == false) {
            $sqlWhere = implode(' AND ', $filters);
        }

        $querySql = "SELECT `{$this->table}`.*
            FROM `{$this->table}`
            WHERE {$sqlWhere}";

        $statement = $this->pdo->prepare($querySql);

        if ($statement === false) {
            throw new ExceptionStorage(self::EXCEPTION_PREFIX . '.sintaxe-error', 1);
        }

        /** @var \PDOStatement $statement */


        if ($this->filterSlug != '') {
            $statement->bindValue(':slug', $this->filterSlug, PDO::PARAM_STR);
        }

        if ($this->filterId != '') {
            $statement->bindValue(':id', $this->filterId, PDO::PARAM_INT);
        }

        if ($this->filterStatus != null) {
            $statement->bindValue(':status', $this->filterStatus->getValue(), PDO::PARAM_INT);
        }

        if ($this->filterType != null) {
            $statement->bindValue(':type', $this->filterType, PDO::PARAM_STR);
        }

        if ($statement->execute() === false) {
            if (isset($statement->errorInfo()[2])) {
                error_log($statement->errorInfo()[2]);
            }
            throw new ExceptionStorage(self::EXCEPTION_PREFIX . '.execute-error', 2);
        }

        $data = $statement->fetchAll(PDO::FETCH_ASSOC);

        if (! is_array($data)) {
            error_log('Fetch error: '. $querySql);
            throw new ExceptionStorage(self::EXCEPTION_PREFIX . '.fetch-error', 3);
        }

        return $this->bind($data);
    }
}
