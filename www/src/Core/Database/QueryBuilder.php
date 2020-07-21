<?php

namespace App\Core\Database;

use App\Core\Helpers\StringTransformer;
use App\Entity\Lesson;
use PDO;
use PHPMailer\PHPMailer\Exception;

/**
 * Class QueryBuilder
 * @package App\Core\Database
 */
abstract class QueryBuilder
{
    #region field
    /** @var \PDO */
    protected $pdo;

    /**
     * @var array
     * Fields to search
     */
    protected $select = [];

    /**
     * @var string
     * Table to use
     */
    protected $from = null;

    /**
     * @var string
     * Alias tp use for the fields in the query
     */
    protected $alias = null;

    /**
     * @var array
     * Conditions to add in the query
     */
    protected $where = [];

    /**
     * @var array
     * parameters to link to the query
     */
    protected $parameters = [];

    /**
     * @var array
     */
    protected $order = [];

    /**
     * @var array
     */
    protected $group = [];

    /**
     * @var int
     */
    protected $limit = null;

    /**
     * @var int
     */
    protected $offset = null;

    /** @var string */
    protected $method = "SELECT";

    /** @var object */
    protected $entity = null;

    /**
     * @var array
     */
    protected $relations = [];
    /**
     * @var array
     */
    protected $orWhere = [];

    #endregion

    #region getter/setter

    /**
     * @param string|null $entity
     * @return EntityManager
     */
    public function setEntity(?string $entity): self
    {
        $this->entity = $entity;
        return $this;
    }

    /**
     *
     * @param string $table
     * @param string $alias
     * @return $this
     */
    public function from(string $table, string $alias = null): self
    {
        $this->from = $table;
        $this->alias = $alias;

        return $this;
    }

    /**
     * Add the fields to use
     * @param mixed ...$args
     * @return $this
     */
    public function select(...$args): self
    {
        foreach ($args as $arg) {
            if (gettype($arg) == "array") {
                foreach ($arg as $value) {
                    $this->select[] = $value;
                }
            } else {
                $this->select[] = $arg;
            }
        }
        return $this;
    }


    /**
     * @param string $condition
     * @return $this
     */
    public function where(string $condition): self
    {
        $this->where = [$condition];

        return $this;
    }

    /**
     * @param string $condition
     * @return $this
     */
    public function andWhere(string $condition): self
    {
        $this->where[] = $condition;

        return $this;
    }

    /**
     * @param string $condition
     * @return $this
     */
    public function orWhere(string $condition): self
    {
        $this->orWhere[] = $condition;

        return $this;
    }


    /**
     * @param string $key
     * @param $value
     * @return $this
     */
    public function setParameter(string $key, $value): self
    {

        $this->parameters[$key] = $value;

        return $this;
    }

    /**
     * @param array $parameters
     * @return $this
     */
    public function setParameters(array $parameters): self
    {

        foreach ($parameters as $key => $value) {
            $this->parameters[$key] = $value;
        }

        return $this;
    }

    /**
     * @param string $alias
     * @return $this
     */
    public function setAlias(string $alias): self
    {
        $this->alias = $alias;
        return $this;
    }


    /**
     * @param string $key
     * @param string $value
     * @return $this
     * @throws \Exception
     */
    public function orderBy(string $key, $value = ""): self
    {
        if (!empty($value) && !in_array($value, ["ASC", "DESC"])) {
            throw new \Exception("Method not allowed", 500);
        }

        $this->order[$key] = $value;
        return $this;
    }

    /**
     * @param string $key
     * @param $value
     * @return $this
     */
    public function groupBy(string $key, $value): self
    {
        $this->group[$key] = $value;
        return $this;
    }

    /**
     * @param int $limit
     * @return $this
     */
    public function setMaxResult(int $limit): self
    {
        $this->limit = $limit;
        return $this;
    }

    /**
     * @param int $offset
     * @return $this
     */
    public function setFirstResult(int $offset): self
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
        $this->offset = ($page - 1) * $this->limit;
        return $this;
    }

    /**
     * @return int
     * @throws \Exception
     */
    public function count()
    {
        $this->select("count(*)");

        $entity = $this->entity;
        $this->entity = null;

        $results = $this->fetch();

        $this->entity = $entity;

        return isset($results["count"]) ? (int)$results["count"] : (int)$results["count(id)"];
    }


    /**
     * @return string
     */
    private function setField()
    {
        switch ($this->method) {
            case "INSERT INTO":
                $fields = $this->getNotNullValues();
                return "(" . join(", ", array_keys($this->fieldsValues)) . ") VALUES 
            (:" . join(", :", array_keys($this->fieldsValues)) . ")";
            case "UPDATE":
                return "SET " . join(" , ", array_map(function ($value) {
                        return "$value = :$value";
                    }, array_keys($this->fieldsValues)));
            case "SELECT":
                if ($this->alias) {
                    $this->from .= " AS {$this->alias}";
                    $alias = $this->alias;
                    if (!in_array("*", $this->select)) {
                        $this->select = array_map(function ($value) use ($alias) {
                            return "$value";
                        }, $this->select);
                    }
                } elseif ($this->relations) {
                    $this->alias = $this->from;
                }
                $fields = join(", ", $this->select);

                return $fields;
            default:
                return "";
        }
    }

    /**
     * @return array|null[]
     */
    private function getNotNullValues()
    {
        return array_map(function ($key, $value) {
            if (!is_null($this->fieldsValues[$key])) {
                return $key;
            } else {
                return null;
            }
        }, array_keys($this->fieldsValues), $this->fieldsValues);
    }

    #endregion

    #region fonction
    /**
     * QueryBuilder constructor.
     * @param PDO|null $pdo
     */
    public function __construct(\PDO $pdo = null)
    {
        if (is_null($pdo)) {
            $pdo = Connection::instance();
        }
        $this->pdo = $pdo;
    }

    /**
     * Execute raw sql with parameters
     * @param string $sql
     * @param array $values
     * @return bool|\PDOStatement
     */
    public function execute(string $sql, array $values)
    {
        $sql = $this->pdo->prepare($sql);
        $sql->execute($values);
        return $sql;
    }

    /**
     * Transform this object into sql string
     * @return string
     */
    public function toSQL(): string
    {
        $fromCache = $this->from;

        $this->from = "\"{$this->from}\"";
        if (empty($this->select)) {
            $this->select = ["*"];
        }

        $fields = $this->setField();

        if (in_array($this->method, ["INSERT INTO", "UPDATE"])) {
            $sql = "$this->method {$this->from} $fields";
        } else {
            $sql = "$this->method $fields FROM {$this->from}";
        }

        if ($this->relations) {
            foreach ($this->relations as $type => $relation) {
                foreach ($relation as $value) {
                    $sql .= " $type $value";
                }
            }
        }

        if (!empty($this->where)) {
            $sql .= " WHERE " . $this->where[0];

            array_shift($this->where);

            if (!empty($this->where)) {
                foreach ($this->where as $selector) {
                    $sql .= " AND " . $selector;
                }
            }
        }

        if (!empty($this->orWhere)) {
            foreach ($this->orWhere as $or) {
                $sql .= " OR " . $or;
            }
        }

        $alias = $this->alias;
        if (!empty($this->order)) {
            $sql .= " ORDER BY " . implode(', ', array_map(function ($key, $value) use ($alias) {
                    return $alias ? "$alias.$key $value" : "$key $value";
                }, array_keys($this->order), $this->order));
        }

        if (!empty($this->group)) {
            $sql .= " GROUP BY " . implode(', ', $this->group);
        }

        if (!is_null($this->limit)) {
            $sql .= " LIMIT " . $this->limit;
        }

        if (!is_null($this->offset)) {
            $sql .= " OFFSET " . $this->offset;
        }

        $this->from = $fromCache;

        return $sql;
    }

    /**
     * Execute sql to retrieve data and hydrate object if is necessary
     * @param bool $clear
     * @return array|mixed|null
     * @throws \ReflectionException
     */
    public function fetch(bool $clear = true)
    {
        $query = $this->pdo->prepare($this->toSQL());
        dump($query);
        if (!$query->execute($this->parameters)) {
            dump($query->errorInfo());
            throw new \Exception("Un erreur est survenu lors de la requête", 500);
        }

        $results = $query->fetchAll(PDO::FETCH_ASSOC);
        if (!is_null($this->entity)) {

            if ($this->relations) {
                Hydrator::$relations = true;
                $records = Hydrator::hydrateRelation($results, $this->entity);

            } else {
                foreach ($results as $result) {
                    $records[] = Hydrator::hydrate($result, $this->entity);
                }
            }
        } else {
            $records = $results;
        }

        if ($clear) {
            $this->clear();
        }

        if (is_null($records)) {
            return null;
        }


        return count($records) > 1 ? $records : (!empty($records) ? array_pop($records) : null);
    }


    /**
     * Put all sql data to the original state to avoid conflict
     * @param bool $all
     * @return $this
     * @throws \ReflectionException
     */
    public function clear(bool $all = false)
    {
        /** @var \ReflectionClass $class */
        $class = new \ReflectionClass($this);

        foreach ($class->getDefaultProperties() as $key => $property) {
            if (is_null($property) || (!$all && $key == "queries") || (!$all && $property == "from")) {
                continue;
            }

            if ($key !== "pdo") {
                $this->$key = $property;
            }
        };

        if ($all) {
            $this->entity = null;
        }

        return $this;
    }

    #endregion
}
