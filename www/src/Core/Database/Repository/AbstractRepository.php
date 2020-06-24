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

    public function __construct(\PDO $pdo = null)
    {
        $repository = explode("\\", get_called_class());
        $this->repository = array_pop($repository);

        $this->class .= explode("Repository", $this->repository)[0];
        $table = explode("_", StringTransformer::PascalCaseToSnakeCase($this->class));
        $this->table = array_pop($table);

        $this->setEntity(get_class(new $this->class()));
        $this->from($this->table . "s");
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
            $links = $this->createLinkPagination($server["HTTP_HOST"]. explode("?", $server["REQUEST_URI"], 2)[0]. "?page=", $page, $start, $end);
        }

        return [
            "data" =>  $results = $this->setMaxResult($length)
                ->page($page)
                ->fetch(false),
            "total" => $count,
            "per_page" => $length,
            "links" => $links,
        ];
    }

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

    private function createLinkPagination(string $url, int $page, int $start, int $end)
    {

        $link = '<nav aria-label="Page navigation example">';
        $link .= '<ul class="pagination">';
        $link .= '<li class="page-item ' . (($page - 1) < 1 ? "disabled" : "" ). '"><a rel="external" class="page-link" href="' . $url . ($page - 1) . '" > Previous</a></li>';
        $link .= '<li class="page-item ' . (($page - 1) <= 1 ? "disabled" : "" ) . '">';
        $link .= '<a class="page-link" rel="external" href="' . $url . '1" aria-label="Previous">';
        $link .= '<span aria-hidden="true">&laquo;</span></a></li>';//<span class="sr-only"> Previous</span>
        for ($i = $start; $i < $end; $i++) {
            $link .= '<li class="page-item ' . (($page == $i) ? "active" : "" ) . '"><a rel="external" target="_blank" class="page-link" href="' . $url . $i . '">' . $i . '</a></li>';

        }
        $link .= '<li class="page-item ' . (($page + 1) === $end ? "disabled" : "" ). '">';
        $link .= '<a rel="external" class="page-link" href = "' . $url . $end . '" aria-label="Next" >';
        $link .= '<span aria-hidden="true">&laquo;</span></a></li>';//<span class="sr-only"> Next</span>
        $link .= '<li class="page-item ' .(($page + 1) > $end ? "disabled" : "" ) . '"><a rel="external" class="page-link" href = "' . $url . ($page + 1) . '"> Next</a></li>';
        $link .= '</ul>';
        return $link;
    }
}