<?php


namespace App\Repository;


use App\Core\Database\Repository\AbstractRepository;
use App\Core\Evaluation\EvaluationMeta;
use App\Core\Evaluation\EvaluationObject;

class EvaluationObjectRepository extends AbstractRepository
{

    public function getEntity()
    {
        return EvaluationObject::class;
    }

    public function findWithMeta(EvaluationObject $evaluationObject)
    {
        return $this->
        setAlias("eo")
            ->leftJoin(EvaluationMeta::class, "em")
            ->where("eo.evaluation_id = :id")
            ->setParameter("id", $evaluationObject->getId())
            ->fetch()
            ;
    }
}