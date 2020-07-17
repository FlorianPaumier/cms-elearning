<?php


namespace App\Core\Interfaces;


interface SubscriberInterface
{
    /**
     * Return all the events defined for the subscriber
     */
    public function getEvents() : array;
}