<?php


namespace App\Core\Database\Repository;


use App\Core\Cache\ConfigHandler;
use App\Core\Database\EntityManager;
use App\Core\Database\QueryBuilder;
use App\Core\Exception\NoRecordException;
use App\Core\Helpers\EntityHelper;
use App\Core\Helpers\StringTransformer;
use App\Core\Request\ParameterBag;
use App\Core\Request\Request;
use App\Entity\User;

abstract class AbstractRepository extends QueryBuilder
{

    /** @var string */
    private $table;

    /** @var string */
    private $class = "App\\Entity\\";

    /** @var AbstractRepository */
    private $repository;

    /**
     * AbstractRepository constructor.
     * Create a new instance of a repository and prepare the query
     * @param \PDO|null $pdo
     */
    public function __construct(\PDO $pdo = null)
    {
        $repository = explode("\\", get_called_class());
        $this->repository = array_pop($repository);

        $this->class .= explode("Repository", $this->repository)[0];
        $this->table = explode("_", StringTransformer::PascalCaseToSnakeCase($this->class), 3)[2];

        if(class_exists($this->class)){
            $class = get_class(new $this->class());
        }else{
            $class = $this->getEntity();
        }

        $this->setEntity($class);
        $this->from($this->table);
        parent::__construct($pdo);
    }

    /**
     * Récupère tous les enregistrements
     *
     * @return array
     */
    public function findAll(): ?array
    {
        $this->orderBy("id", 'ASC');
        $results = $this->fetch();

        if(is_null($results))
            return [];

        return gettype($results) == "object" ? [$results] : $results;
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
        foreach (array_keys($params) as $key => $param) {
            if ($key > 0) {
                $this->andWhere("$param = :$param");
            } else {
                $this->where("$param = :$param");
            }
        }

        $this->setParameters($params);
        return $this->fetch();
    }

    /**
     * Récupère une ligne par rapport à un champs
     *
     * @param array $params
     * @return mixed|false
     * @throws NoRecordException
     */
    public function findOneBy(array $params)
    {
        foreach (array_keys($params) as $key => $param) {
            if ($key > 0) {
                $this->andWhere("$param = :$param");
            } else {
                $this->where("$param = :$param");
            }
        }

        $this->setParameters($params);

        return $this->fetch();
    }

    /**
     * Récupère un élément à partir de son ID
     *
     * @param int $id
     * @return mixed
     */
    public function find(int $id)
    {
        $this->where("id = :id");
        $this->setParameter("id", $id);
        return $this->fetch();
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
     * Create a pagination from the query and return array with result and html
     * @param int $length
     * @param bool $paginate
     * @return array
     * @throws \Exception
     */
    public function paginate(int $length, bool $paginate = true): array
    {
        /** @var Request $request */
        $request = ConfigHandler::get("request");

        $page = $request->getQuery()->get("page") ?? 1;

        $count = $this->count();

        $start = ($page - 5) * $length < 0 ? 1 : ($page - 5);
        $end = ($page + 5) * $length > $count ? ceil($count / $length) : ($page + 5);


        $links = null;

        if ($paginate) {
            $server = $request->getServer();
            $links = $this->createLinkPagination("http://".$server["HTTP_HOST"]. explode("?", $server["REQUEST_URI"], 2)[0]. "?page=", $page, $start, $end);
        }

        $data = $this->setMaxResult($length)
                ->orderBy("id" , "ASC")
                ->page($page)
                ->fetch();

        if(!is_array($data)){
            $data = [$data];
        }

        return [
            "data" => $data,
            "total" => $count,
            "per_page" => $length,
            "links" => $links,
        ];
    }

    /**
     * Count the entry with some arguments
     * @param array $args
     * @return int
     */
    public function countBy(array $args)
    {
        foreach (array_keys($args) as $key => $param) {
            if ($key > 0) {
                $this->andWhere("$param = :$param");
            } else {
                $this->where("$param = :$param");
            }
        }

        $this->setParameters($args);

        return $this->count();
    }

    /**
     * Create the query for join table
     * @param string $tableTarget
     * @param string $alias
     * @return AbstractRepository
     */
    private function join(string $tableTarget,string $key,  string $alias)
    {
        if(strpos($tableTarget, "\\") !== false){
            $tableTarget = StringTransformer::PascalCaseToSnakeCase(EntityHelper::getClassName($tableTarget));
        }

        if($this->alias){
            $this->relations[$key][] = "\"$tableTarget\" AS $alias on ".$this->alias.".id"." = $alias.id";
        }else{
            $this->relations[$key][] = "\"$tableTarget\" AS $alias on ".$this->table.".id"." = $alias.id";
        }

        $this->addSelect($tableTarget, $alias);

        return $this;
    }

    /**
     * Create join for left option
     * @param string $tableTarget
     * @param string $alias
     * @return AbstractRepository
     */
    public function leftJoin(string $tableTarget, string $alias)
    {
        return $this->join($tableTarget, "LEFT JOIN", $alias);
    }

    /**
     * Create join for inner option
     * @param string $tableTarget
     * @param string $alias
     * @return AbstractRepository
     */
    public function innerJoin(string $tableTarget, string $alias)
    {
        return $this->join($tableTarget, "INNER JOIN", $alias);
    }

    /**
     * Create join for right option
     * @param string $tableTarget
     * @param string $alias
     * @return AbstractRepository
     */
    public function rightJoin(string $tableTarget, string $alias)
    {
        return $this->join($tableTarget, "RIGHT JOIN", $alias);
    }

    /**
     * Create join for relation many to many option
     * @param string $tableTarget
     * @param string $alias
     * @param string $type
     * @param string $joinTable
     * @return $this
     */
    public function joinMany(string $tableTarget, string $alias, string $type = "JOIN", string $joinTable = ""){

        if(strpos($tableTarget, "\\") !== false){
            $tableTarget = StringTransformer::PascalCaseToSnakeCase(EntityHelper::getClassName($tableTarget))."s";
        }

        if(empty($joinTable)){
            $joinTable = $this->from . "_" . $tableTarget;
        }

        $this->relations["JOIN"][] = "$joinTable on ".$this->alias.".id"." = $joinTable.".mb_substr($this->table, 0, -1)."_id";
        $this->relations["JOIN"][] = "$tableTarget AS $alias on ".$joinTable.".".mb_substr($tableTarget, 0, -1)."_id = $alias.id";

        $this->addSelect($tableTarget, $alias);

        return $this;

    }

    /**
     * add all collumn with alias from both table
     * @param string $table
     * @param string $alias
     */
    private function addSelect(string $table, string $alias)
    {
        if(empty($this->select)){
            $this->addColumns($this->table, $this->alias ?? $this->table, $this->getColumns($this->table));
        }

        $this->addColumns($table,$alias, $this->getColumns($table));
    }

    /**
     * Get all collumn name from the table
     * @param string $table
     * @return array
     */
    private function getColumns(string $table){

        $q = $this->pdo->prepare("SELECT COLUMN_NAME FROM information_schema.COLUMNS WHERE TABLE_NAME = '$table'");
        $q->execute();

        return $q->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Add the collumns in the select array for the query
     * @param string $table
     * @param string|null $alias
     * @param array $columns
     */
    private function addColumns(string $table,?string $alias, array $columns){
        foreach ($columns as $column){
            $name = $column["column_name"];
            $target = $name;
            if($alias){
                $target = $alias.".$name";
            }

            $target .= " AS ".$table."_$name";

            $this->select($target);
        }
    }

    /**
     * Creation of the html part for the pagination.
     * @param string $url
     * @param int $page
     * @param int $start
     * @param int $end
     * @return string
     */
    private function createLinkPagination(string $url, int $page, int $start, int $end)
    {

        $link = '<nav aria-label="Page navigation example" class="pagination-bar">';
        $link .= '<ul class="pagination list-unstyle">';
        $link .= '<li class="page-item ' . (($page - 1) < 1 ? "disabled" : "" ). '"><a '.(($page - 1) < 1 ? "disabled" : "" ).' rel="external" class="page-link" href="' . $url . ($page - 1) . '" ><span>Previous</span></a></li>';
        $link .= '<li class="page-item ' . (($page - 1) <= 1 ? "disabled" : "" ) . '">';
        $link .= '<a class="page-link" rel="external" href="' . $url . '1" aria-label="Previous" '.(($page - 1) < 1 ? "disabled" : "" ).'>';
        $link .= '<span aria-hidden="true">←</span></a></li>';//<span class="sr-only"> Previous</span>
        for ($i = $start; $i <= $end; $i++) {
            $link .= '<li class="page-item ' . (($page == $i) ? "active disabled" : "" ) . '"><a rel="external" class="page-link" href="' . $url . $i . '">' . $i . '</a></li>';

        }
        $link .= '<li class="page-item ' . (($page + 1) > $end ? "disabled" : "" ). '">';
        $link .= '<a rel="external" class="page-link" href = "' . $url . $end . '" aria-label="Next" '.(($page + 1) > $end ? "disabled" : "" ).'>';
        $link .= '<span aria-hidden="true">→</span></a></li>';//<span class="sr-only"> Next</span>
        $link .= '<li class="page-item ' .(($page + 1) > $end ? "disabled" : "" ) . '"><a rel="external" class="page-link" href = "' . $url . ($page + 1) . '" '.(($page - 1) < 1 ? "disabled" : "" ).'><span>Next</span></a></li>';
        $link .= '</ul>';
        return $link;
    }
}