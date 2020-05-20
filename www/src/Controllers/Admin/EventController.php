<?php


namespace App\Controllers\Admin;


use App\Core\Helpers\StringTransformer;
use App\Core\Interfaces\BaseController;
use App\Core\Request\Request;
use App\Entity\Event;
use App\Form\EventForm;

class EventController extends BaseController
{

    public function list(Request $request)
    {
        return $this->render("admin/events/index", ["list" => $this->repository->setEntity(Event::class)->findAll()]);
    }

    public function new(Request $request)
    {
        $event = new Event();
        $form = $this->createForm(EventForm::class, $event);
        $form->handleRequest($request);

        if($request->getMethod() == "POST" && $form->isValid()){
            $event->setSlug(StringTransformer::slugify($event->getTitle()));
            $this->repository->persist($event);
            $this->repository->flush();

            $this->redirect->redirectToRoute("admin_events_list");
        }

        return $this->render("admin/events/form", ["form" => $form->createView()]);
    }

    public function edit(Request $request, Event $event)
    {

    }

    public function delete(Event $event)
    {

    }

}