<?php


namespace App\Repository;

use App\Core\Database\Repository\AbstractRepository;
use App\Core\Evaluation\EvaluationMeta;

class EvaluationMetaRepository extends AbstractRepository
{

    public function getEntity()
    {
        return EvaluationMeta::class;
    }
}