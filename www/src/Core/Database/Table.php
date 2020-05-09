<?php

namespace App\Core\Database;

use App\Core\Exception\NoRecordException;
use PDO;

/**
 * Class Table
 * Gestion des fonctions récurantes
 * @package App\Core\Database
 */
class Table extends QueryBuilder
{

    /**
     * Entité à utiliser
     *
     * @var string|null
     */
    protected $entity = null;
    /**
     * @var array
     */
    protected $queries = [];

    /**
     * Récupération de l'instance de PDO
     * @param PDO|null $pdo
     */
    public function __construct(PDO $pdo = null)
    {
        parent::__construct($pdo);
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
    public function findAll(): ?array
    {
        $this->select("*")->orderBy("id", 'ASC');

        return $this->fetchOrFail();
    }

    /**
     * Récupère une ligne par rapport à un champs
     *
     * @param  array $params
     * @return mixed|false
     * @throws NoRecordException
     */

    public function findBy(array $params)
    {
        foreach (array_keys($params) as $key => $param){
            if($key > 0){
                $this->andWhere("$param = :$param");
            }else{
                $this->where("$param = :$param");
            }
        }

        $this->setParams($params);
        return $this->fetchOrFail();
    }

    public function persist(object &$objet): void
    {
        $this->getClass(get_class($objet));
        $params = Hydrator::getData($objet);

        $this->method = is_null($params["id"]) ? "INSERT" : "UPDATE";

        if ($this->method == "INSERT"){
            $query = "INSERT INTO {$this->from} ("
                . join(', ', array_keys($params)) .
                ") VALUES (" . $this->buildFieldQuery($params) . ")";
        }else{
            $fieldQuery = implode(
                ',', array_map(
                    function ($param) {
                        return $param . "=:" . $param;
                    }, array_keys($params)
                )
            );
            $query = "$this->method {$this->from} SET {$fieldQuery} WHERE id = :id";
        }

        $this->queries[] = [
            "sql" => $query,
            "data" => $params,
            "object" => $objet,
        ];
    }

    public function flush()
    {
        foreach ($this->queries as $query){
            try {
                $sql = $this->pdo->prepare($query["sql"]);
                $sql->execute($query["data"]);
            }catch (\Exception $e){
                dump($e->getMessage());
            }
            dump($sql->errorInfo());
            if(is_null($query["object"]->getId()))
                $query["object"]->setId($this->pdo->lastInsertId());
        }

        $this->clear();
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
     * @param  int $id
     * @return mixed
     */
    public function find(int $id)
    {
        $this->where("id = :id");
        $this->setParam("id" ,$id);
        return $this->fetchOrFail()[0];
    }

    /**
     * Crée un nouvel enregistrement
     *
     * @param  array $params
     * @return bool
     */
    public function insert(array $params): bool
    {
        $query = $this->pdo->prepare(
            "INSERT INTO {$this->from} ("
            . join(', ', array_keys($params)) .
            ") VALUES (" . $this->buildFieldQuery($params) . ")"
        );


        if (!($result = $query->execute($params))) {
            foreach ($params as $key => $param) {
                $query->bindParam($key, $param);
            }
            $result = $query->execute($params);
        }

        return $result;

    }

    /**
     * Formatage de collone pour les données
     * @param array $params
     * @return string
     */
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
     * @param  int $id
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
     * @param  int   $id
     * @param  array $params
     * @return bool
     */
    public function update(int $id, array $params): bool
    {
        $fieldQuery = implode(
            ',', array_map(
                function ($param) {
                    return $param . "=:" . $param;
                }, array_keys($params)
            )
        );

        $params["id"] = $id;
        $query = $this->pdo->prepare("UPDATE {$this->from} SET {$fieldQuery} WHERE id = :id");
        $query->execute($params);
        return $query->fetchObject();
    }

    /**
     * Retourne l'entité utilisé
     * @return mixed
     */
    public function getEntity(): string
    {
        return $this->entity;
    }

    /**
     * @param string|null $entity
     * @return Table
     */
    public function setEntity(?string $entity): Table
    {
        $this->entity = $entity;
        $this->getClass($entity);
        return $this;
    }

    /**
     * Retourne la table visée
     * @return string
     */
    public function getTable(): string
    {
        return $this->from;
    }

    /**
     * Vérifie qu'un enregistrement existe
     *
     * @param array $search
     * @return bool
     */
    public function exists(array $search): bool
    {
        $result = $this->findBy($search);

        return !empty($result);
    }

    /**
     * Retourne l'instance PDO courante
     * @return \PDO
     */
    public function getPdo(): \PDO
    {
        return $this->pdo;
    }

    /**
     * Insert les données trouvé dans l'objet souhaité
     * @param $object
     * @param $data
     * @return mixed
     */
    public function hydrate($object, array $data)
    {
        return Hydrator::hydrate($data,$object);
    }

    public function getData(object $object)
    {
         $data = Hydrator::getData($object);
         die;
    }

    /**
     * Récupère la première colonne
     *
     * @param  string $query
     * @param  array  $params
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
