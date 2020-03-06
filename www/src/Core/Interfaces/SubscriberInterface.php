<?php


namespace App\Core\Interfaces;


interface SubscriberInterface
{
    public function getEvents() : array;
}