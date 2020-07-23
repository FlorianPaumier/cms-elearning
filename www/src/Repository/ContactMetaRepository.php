<?php


namespace App\Repository;


use App\Core\Contact\ContactInput;
use App\Core\Contact\ContactMeta;
use App\Core\Database\Repository\AbstractRepository;

/**
 * find
 * findAll
 * findOneBy
 * findBy
 */
class ContactMetaRepository extends AbstractRepository
{

    public function getEntity()
    {
        return ContactMeta::class;
    }
}