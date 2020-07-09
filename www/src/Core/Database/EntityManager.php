<?php

namespace App\Core\Database;

use App\Core\Exception\NoRecordException;
use App\Core\Helpers\EntityHelper;
use PDO;
use PHPMailer\PHPMailer\Exception;

/**
 * Class Table
 * Gestion des fonctions récurantes
 * @package App\Core\Database
 */
class EntityManager extends QueryBuilder
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

    protected $fieldsValues = [];

    /**
     * Récupération de l'instance de PDO
     * @param PDO|null $pdo
     */
    public function __construct(PDO $pdo = null)
    {
        parent::__construct($pdo);
    }

    public function persist(object &$objet): self
    {
        $this->from(EntityHelper::getClass($objet));

        $params = Hydrator::getData($objet);

        if (!isset($params["id"])) {
            $this->insert($objet);
        } else {
            $this->update($objet);
        }

        return $this;
    }

    public function flush()
    {
        foreach ($this->queries as $query) {
            try {

                $this->execute($query["sql"], $query["data"]);
//                dump($query["sql"])1;
//                dump($query["data"]);

                if (is_null($query["object"]->getId())) {
                    $query["object"]->setId($this->pdo->lastInsertId());
                }
            } catch (\Exception $e) {
                throw new \Exception($e);
            }
        }

        $this->clear(true);
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
     * Crée un nouvel enregistrement
     *
     * @param array $params
     * @return bool
     */
    private function insert(object &$object): self
    {
        $this->method = "INSERT INTO";
        $this->setFieldsValues(Hydrator::getData($object));
        $this->addToQueue($object);

        return $this;
    }

    /**
     * Met à jour un enregistrement au niveau de la base de données
     *
     * @param int $id
     * @param array $params
     * @return bool
     */
    private function update(object &$object): self
    {
        $this->method = "UPDATE";
        $this->where("id = :id");
        $this->setFieldsValues(Hydrator::getData($object));
        $this->addToQueue($object);
        return $this;
    }

    /**
     * Formatage de collone pour les données
     * @param array $params
     * @return string
     */
    protected function buildFieldQuery(array $params)
    {
        return join(
            ', ', array_map(
                function ($field) {
                    return ":$field";
                }, array_keys($params)
            )
        );
    }

    protected function addToQueue(object &$object)
    {
        $this->queries[] = [
            "sql" => $this->toSQL(),
            "data" => $this->fieldsValues,
            "object" => $object,
        ];

        $this->clear();
    }

    public function delete(object $object)
    {
        if (!is_callable([$object, 'getId'])) {
            throw new \Exception("No id in object");
        }
        $this->from(EntityHelper::getClass($object));
        $this->method = "DELETE";

        $this->where("id = :id")
            ->setFieldsValues(["id" => $object->getId()]);

        $this->addToQueue($object);
        $this->flush();
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
        return Hydrator::hydrate($data, $object);
    }

    public function getRepository(string $class)
    {
        if (class_exists($class)) {
            return new $class;
        }else{
            $name = EntityHelper::getClassName($class);
            $repo = "App\\Repository\\$name";

            if (class_exists($repo))
                return new $repo;
        }

        return null;
    }

    private function setFieldsValues(array $values): void
    {
        $this->fieldsValues = [];
        $this->fieldsValues = $values;
    }
}
