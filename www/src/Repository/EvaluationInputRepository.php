<?php


namespace App\Repository;


use App\Core\Database\Repository\AbstractRepository;
use App\Core\Evaluation\EvaluationInput;

/**
 * find
 * findAll
 * findOneBy
 * findBy
 */
class EvaluationInputRepository extends AbstractRepository
{

    public function getEntity()
    {
        return EvaluationInput::class;
    }
}