<?php

namespace App\Core\Database;

use App\Core\Exception\NoRecordException;
use PDO;

class Table extends QueryBuilder
{

    /**
     * Entité à utiliser
     *
     * @var string|null
     */
    protected $entity;

    public function __construct(PDO $pdo = null)
    {
        parent::__construct($pdo);
    }

    /**
     * Pagine des éléments
     *
     * @param int $perPage
     * @param int $currentPage
     * @return Pagerfanta
     */
    public function findPaginated(int $perPage, int $currentPage): PagerFanta
    {
        $query = new PaginatedQuery(
            $this->pdo,
            $this->paginationQuery(),
            "SELECT COUNT(id) FROM {$this->from}",
            $this->entity
        );
        return (new Pagerfanta($query))
            ->setMaxPerPage($perPage)
            ->setCurrentPage($currentPage);
    }

    protected function paginationQuery()
    {
        return "SELECT * FROM {$this->from}";
    }

    /**
     * Récupère une liste clef valeur de nos enregistrements
     */
    public function findList(): array
    {
        $results = $this->pdo
            ->query("SELECT id, name FROM {$this->from}")
            ->fetchAll(\PDO::FETCH_NUM);
        $list = [];
        foreach ($results as $result) {
            $list[$result[0]] = $result[1];
        }
        return $list;
    }

    /**
     * Récupère tous les enregistrements
     *
     * @return array
     */
    public function findAll(): array
    {
        $query = $this->pdo->query("SELECT * FROM {$this->from}");
        if ($this->entity) {
            $query->setFetchMode(\PDO::FETCH_CLASS, $this->entity);
        } else {
            $query->setFetchMode(\PDO::FETCH_OBJ);
        }
        return $query->fetchAll();
    }

    /**
     * Récupère une ligne par rapport à un champs
     *
     * @param array $params
     * @return mixed|false
     * @throws NoRecordException
     */
    public function findBy(array $params)
    {
        $sql = "SELECT * FROM {$this->from} WHERE ";
        $sql .= $this->buildWhereFieldQuery($params);

        return $this->fetchOrFail($sql, $params);
    }

    private function buildWhereFieldQuery(array $params)
    {
        return join(
            ' AND ', array_map(
                function ($field) {
                    return "`$field` = :$field";
                }, array_keys($params)
            )
        );
    }


    /**
     * Récupère un élément à partir de son ID
     *
     * @param int $id
     * @return mixed
     * @throws NoRecordException
     */
    public function find(int $id)
    {
        $this->from($this->from)
            ->where("id = :id");

        $this->setParam("id", $id);
        return $this->fetchOrFail();
    }

    /**
     * Crée un nouvel enregistrement
     *
     * @param array $params
     * @return bool
     */
    public function insert(array $params): bool
    {
        $query = $this->pdo->prepare("INSERT INTO {$this->from} ("
            . join(', ', array_keys($params)) .
            ") VALUES (" . $this->buildFieldQuery($params) . ")");


        if (!($result = $query->execute($params))) {
            foreach ($params as $key => $param) {
                $query->bindParam($key, $param);
            }
            $result = $query->execute($params);
        }

        return $result;

    }

    private function buildFieldQuery(array $params)
    {
        return join(
            ', ', array_map(
                function ($field) {
                    return ":$field";
                }, array_keys($params)
            )
        );
    }

    /**
     * Supprime un enregistrment
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $query = $this->pdo->prepare("DELETE FROM {$this->from} WHERE id = :id");
        return $query->execute(["id" => $id]);
    }

    /**
     * Met à jour un enregistrement au niveau de la base de données
     *
     * @param int $id
     * @param array $params
     * @return bool
     */
    public function update(int $id, array $params): bool
    {
        $fieldQuery = implode(',', array_map(function ($param) {
            return $param . "=:" . $param;
        }, array_keys($params)));

        $params["id"] = $id;
        $query = $this->pdo->prepare("UPDATE {$this->from} SET {$fieldQuery} WHERE id = :id");
        $query->execute($params);
        return $query->fetchObject();
    }

    /**
     * @return mixed
     */
    public function getEntity(): string
    {
        return $this->entity;
    }

    /**
     * @return string
     */
    public function getTable(): string
    {
        return $this->from;
    }

    /**
     * Vérifie qu'un enregistrement existe
     *
     * @param  $id
     * @return bool
     */
    public function exists($id): bool
    {
        $query = $this->pdo->prepare("SELECT id FROM {$this->from} WHERE id = :id");
        $query->execute(["id" => $id]);
        return $query->fetchColumn() !== false;
    }

    /**
     * @return \PDO
     */
    public function getPdo(): \PDO
    {
        return $this->pdo;
    }

    public function hydrate($object, $data)
    {
        foreach ($data as $key => $value) {
            $method = "set" . ucfirst($key);
            if (is_callable([$object, $method])) {
                $object->$method($value);
                $values[$key] = $value;
            }
        }

        return $object;
    }

    /**
     * Récupère la première colonne
     *
     * @param string $query
     * @param array $params
     * @return mixed
     */
    private function fetchColumn(string $query, array $params = [])
    {
        $query = $this->pdo->prepare($query);
        $query->execute($params);
        if ($this->entity) {
            $query->setFetchMode(\PDO::FETCH_CLASS, $this->entity);
        }
        return $query->fetchColumn();
    }
}
