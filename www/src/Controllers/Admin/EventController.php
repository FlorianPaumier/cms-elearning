<?php


namespace App\Controllers\Admin;


use App\Core\Helpers\StringTransformer;
use App\Core\Interfaces\BaseController;
use App\Core\Request\Request;
use App\Entity\Event;
use App\Entity\Stream;
use App\Form\EventForm;
use App\Form\StreamForm;
use App\Repository\EventRepository;
use App\Repository\StreamRepository;

class EventController extends BaseController
{

    public function list(Request $request, EventRepository $repository)
    {
        return $this->render("admin/events/index", ["list" => $repository->paginate(10)]);
    }

    public function new(Request $request)
    {
        $event = new Event();
        $form = $this->createForm(EventForm::class, $event);
        $form->handleRequest($request);

        if($request->getMethod() == "POST" && $form->isValid()){
            $event->setSlug(StringTransformer::slugify($event->getTitle()));
            $this->entityManager->persist($event);
            $this->entityManager->flush();

            $this->redirect->redirectToRoute("admin_events_list");
        }

        return $this->render("admin/events/form", ["form" => $form->createView()]);
    }

    public function edit(Request $request, Event $event)
    {
        $form = $this->createForm(EventForm::class, $event);
        $form->handleRequest($request);

        if($request->getMethod() == "POST" && $form->isValid()){
            $event->setSlug(StringTransformer::slugify($event->getTitle()));
            $this->entityManager->persist($event);
            $this->entityManager->flush();

            $this->redirect->redirectToRoute("admin_events_list");
        }

        return $this->render("admin/events/form", ["form" => $form->createView()]);
    }

    public function stream(Request $request, Event $event, StreamRepository $streamRepository)
    {
        $stream = $streamRepository->findOneBy(["event_id" => $event->getId()]);

        if(is_null($stream)){
            $stream = (new Stream())
            ->setEvent($event);
        }

        $form = $this->createForm(StreamForm::class, $stream);
        $form->handleRequest($request);

        if($form->isValid()){
            $event->setStream($stream);
            $this->entityManager->persist($event)->persist($stream)->flush();
            $this->redirect->redirectToRoute("admin_events_list");
        }

        return $this->render("admin/events/stream", [
            "form" => $form->createView(),
        ]);
    }

    public function delete(Event $event)
    {
        $this->entityManager->delete($event);
        $this->redirect->redirectToRoute("admin_events_list");
    }

    public function deleteStream(Event $event, Stream $stream)
    {
        $event->setStream(null);
        $this->entityManager->persist($event)->delete($stream);
        $this->redirect->redirectToRoute("admin_events_list");
    }
}