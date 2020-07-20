<?php


namespace App\Controllers\Frontend;


use App\Core\Formatter\Serializer;
use App\Core\Interfaces\BaseController;
use App\Core\Request\Request;
use App\Entity\Event;

class EventController extends BaseController
{

    public function index(Request $request, Serializer $serializer)
    {
        $events = $this->entityManager->setEntity(Event::class)->findAll();

        return $this->render("frontend/events/calendar", ["events" => $serializer->serialize($events, 'json')]);
    }
}