<?php


namespace App\Repository;


use App\Core\Contact\ContactInput;
use App\Core\Database\Repository\AbstractRepository;

/**
 * find
 * findAll
 * findOneBy
 * findBy
 */
class ContactInputRepository extends AbstractRepository
{

    public function getEntity()
    {
        return ContactInput::class;
    }
}