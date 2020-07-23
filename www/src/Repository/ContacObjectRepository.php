<?php


namespace App\Repository;


use App\Core\Contact\ContactInput;
use App\Core\Contact\ContactObject;
use App\Core\Database\Repository\AbstractRepository;

/**
 * find
 * findAll
 * findOneBy
 * findBy
 */
class ContacObjectRepository extends AbstractRepository
{

    public function getEntity()
    {
        return ContactObject::class;
    }
}