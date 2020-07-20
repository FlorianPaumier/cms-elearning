<?php


namespace App\Repository;


use App\Core\Contact\ContactForm;
use App\Core\Database\Repository\AbstractRepository;

/**
 * find
 * findAll
 * findOneBy
 * findBy
 */
class ContactFormRepository extends AbstractRepository
{

    protected function getEntity(){
        return ContactForm::class;
    }
}