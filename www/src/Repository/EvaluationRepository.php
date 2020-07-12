<?php


namespace App\Repository;


use App\Core\Database\Repository\AbstractRepository;
use App\Core\Evaluation\Evaluation;

/**
 * find
 * findAll
 * findOneBy
 * findBy
 */
class EvaluationRepository extends AbstractRepository
{

    public function getEntity()
    {
        return Evaluation::class;
    }
}