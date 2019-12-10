<?php

namespace App\Core\Database;

use PDO;

/**
 * Class QueryBuilder
 * @package App\Core\Database
 */
class QueryBuilder
{

    /**
     * @var
     */
    private $from;

    /**
     * @var string
     */
    private $alias;

    /**
     * @var array
     */
    private $order = [];

    /**
     * @var
     */
    private $limit;

    /**
     * @var
     */
    private $offset;

    /**
     * @var
     */
    private $where;

    /**
     * @var array
     */
    private $andWhere = [];

    /**
     * @var array
     */
    private $fields = ["*"];

    /**
     * @var array
     */
    private $params = [];

    /**
     * @var string
     */
    private $sql;

    /**
     * @var \PDOStatement
     */
    private $query;

    /**
     * @var PDO
     */
    private $pdo;

    public function __construct()
    {
        $this->pdo = Connection::instance();
    }

    /**
     * @param string $table
     * @param string|null $alias
     * @return $this
     */
    public function from(string $table, string $alias = null): self
    {
        $this->from = $alias === null ? $table : "$table $alias";
        $this->alias = $alias;
        return $this;
    }

    /**
     * @param string $key
     * @param string $direction
     * @return $this
     */
    public function orderBy(string $key, string $direction): self
    {
        $direction = strtoupper($direction);
        if (!in_array($direction, ['ASC', 'DESC'])) {
            $this->order[] = $key;
        } else {
            $this->order[] = "$key $direction";
        }
        return $this;
    }

    /**
     * @param int $limit
     * @return $this
     */
    public function limit(int $limit): self
    {
        $this->limit = $limit;
        return $this;
    }

    /**
     * @param int $offset
     * @return $this
     */
    public function offset(int $offset): self
    {
        $this->offset = $offset;
        return $this;
    }

    /**
     * @param int $page
     * @return $this
     */
    public function page(int $page): self
    {
        return $this->offset($this->limit * ($page - 1));
    }

    /**
     * @param string $where
     * @return $this
     */
    public function where(string $where): self
    {
        $this->where = "$where";
        return $this;
    }

    /**
     * @param string $where
     * @return $this
     */
    public function andWhere(string $where): self
    {
        $this->andWhere[] = $where;
        return $this;
    }

    /**
     * @param string $key
     * @param $value
     * @return $this
     */
    public function setParam(string $key, $value): self
    {
        $this->params[$key] = $value;
        return $this;
    }

    /**
     * @param mixed ...$fields
     * @return $this
     */
    public function select(...$fields): self
    {
        if (is_array($fields[0])) {
            $fields = $fields[0];
        }
        if ($this->fields === ['*']) {
            $this->fields = $fields;
        } else {
            $this->fields = array_merge($this->fields, $fields);
        }
        return $this;
    }

    /**
     * @return void
     */
    public function toSQL(): string
    {
        $fields = implode(', ', $this->fields);
        $this->sql = "SELECT $fields FROM {$this->from}";
        if ($this->where) {
            $this->sql .= " WHERE " . $this->where;
        }

        if (count($this->andWhere) > 0) {
            foreach ($this->andWhere as $selector) {
                $this->sql .= " AND " . $selector;
            }
        }

        if (!empty($this->order)) {
            $this->sql .= " ORDER BY " . implode(', ', $this->order);
        }
        if ($this->limit > 0) {
            $this->sql .= " LIMIT " . $this->limit;
        }
        if ($this->offset !== null) {
            $this->sql .= " OFFSET " . $this->offset;
        }

        return $this->sql;
    }

    /**
     * @param string $field
     * @return string|null
     */
    public function fetch(string $field): ?string
    {
        $query = $this->pdo->prepare($this->toSQL());
        $query->execute($this->params);

        $result = $query->fetch();
        if ($result === false) {
            return null;
        }
        return $result[$field] ?? null;
    }

    /**
     * @return array|null
     */
    public function fetchAll(): ?array
    {
        $query = $this->pdo->prepare($this->toSQL());
        $query->execute($this->params);
        $result = $query->fetchAll();
        if ($result === false) {
            return null;
        }
        return $result ?? null;
    }

    /**
     * @param PDO $pdo
     * @return int
     */
    public function count(): int
    {
        return (int)(clone $this)->select('COUNT(id) count')->fetch('count');
    }

}