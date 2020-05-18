<?php

namespace App\Core\Database;

use App\Core\Helpers\StringTransformer;
use App\Entity\Lesson;

class QueryBuilder
{
    /** @var \PDO */
    protected $pdo;

    /**
     * @var string
     */
    protected $from = "";
    /**
     * @var string|null
     */
    protected $alias = "";
    /**
     * @var string
     */
    protected $method = "SELECT";

    protected $fields = ["*"];
    /**
     * @var array
     */
    protected $order = [];
    /**
     * @var int
     */
    protected $limit = null;
    /**
     * @var int
     */
    protected $offset = null;
    /**
     * @var string
     */
    protected $where = "";
    /**
     * @var array
     */
    protected $andWhere = [];
    /**
     * @var string
     */
    protected $sql = "";
    /**
     * @var array
     */
    protected $group = [];
    /**
     * @var array
     */
    protected $data = [];

    /** @var array */
    protected $params = [];

    /** @var array  */
    protected $relations = [];

    public function __construct(\PDO $pdo = null)
    {
        if (is_null($pdo)) {
            $pdo = Connection::instance();
        }
        $this->pdo = $pdo;
    }

    /**
     * @param mixed ...$fields
     * @return $this
     */
    public function select(...$fields): self
    {
        $this->method = "SELECT";

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
     * @param string $key
     * @param string $direction
     * @return $this
     */
    public function groupBy(string $field): self
    {
        $this->group[] = $field;
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
     * @return int
     */
    public function count(): int
    {
        $q = (clone $this)->select('COUNT(id) count')->fetchOrFail();

        if (is_array($q)) {
            $count = (int) $q[0]["count"];
        } else {
            $count = (int) $q->count;
        }

        return $count;
    }

    /**
     * @param string $key
     * @param  $value
     * @return $this
     */
    public function setParam(string $key, $value): self
    {
        $this->params[$key] = $value;
        return $this;
    }

    /**
     * @param  $value
     * @return $this
     */
    public function setParams(array $values): self
    {
        $this->params = array_merge($this->params, $values);
        return $this;
    }

    public function join(string $type, string $value)
    {
        $this->relations[$type][] = $value;
        return $this;
    }
    /**
     * @return string
     */
    public function toSQL(): string
    {
        if (!is_null($this->alias)) {
            $fields = $this->fields !== ["*"] ? $this->alias . "." . implode(', ' . $this->alias . ".", $this->fields) : implode(', ' . $this->alias . ".", $this->fields);
        } else {
            $fields = implode(', ', $this->fields);
        }

        $this->sql = "$this->method $fields FROM {$this->from}";

        if($this->relations){
            foreach ($this->relations as $type => $relation){
                foreach ($relation as $value){
                    $this->sql .= " $type $value";
                }
            }
        }

        if ($this->where) {
            $this->sql .= " WHERE " . $this->where;

            if (count($this->andWhere) > 0) {
                foreach ($this->andWhere as $selector) {
                    $this->sql .= " AND " . $selector;
                }
            }
        }

        if (!empty($this->order)) {
            $this->sql .= " ORDER BY " . implode(', ', $this->order);
        }

        if (!empty($this->group)) {
            $this->sql .= " GROUP BY " . implode(', ', $this->group);
        }

        if (!empty($this->limit)) {
            $this->sql .= " LIMIT " . $this->limit;
        }

        if (!is_null($this->offset)) {
            $this->sql .= " OFFSET " . $this->offset;
        }

        return $this->sql;
    }

    /**
     * Permet d'éxécuter une requête et de récupérer le premier résultat
     *
     * @return mixed|false
     */
    public function fetchOrFail()
    {
        $query = $this->pdo->prepare($this->toSQL());
        $query->execute($this->params);

        $this->params = [];

        $results = $query->fetchAll(\PDO::FETCH_ASSOC);

        if (isset($this->entity)) {
            foreach ($results as $result) {
                $record[] = Hydrator::hydrate($result, $this->entity);
            }
        } else {
            $record = $results;
        }

        $this->clear();

        return $record !== false ? $record : null;
    }

    public function setData(array $data)
    {
        $this->data = $data;
    }

    public function getClass(string $class)
    {
        $this->entity = $class;
        $classTab = explode("\\", $class);
        $class = array_pop($classTab);
        $this->from = strtolower(StringTransformer::PascalCaseToSnakeCase($class));
        return $this->from;
    }

    public function clear()
    {
        /** @var \ReflectionClass $class */
        $class = new \ReflectionClass($this);

        foreach ($class->getDefaultProperties() as $key => $property) {
            if (is_null($property)) {
                continue;
            }

            if ($key !== "pdo") {
                $this->$key = $property;
            }
        };

        $this->entity = null;

        return $this;
    }
}
