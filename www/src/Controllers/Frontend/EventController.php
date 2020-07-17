<?php


namespace App\Controllers\Frontend;


use App\Core\Formatter\Serializer;
use App\Core\Interfaces\BaseController;
use App\Core\Request\Request;
use App\Entity\Event;
use App\Entity\Stream;
use App\Entity\StreamInscription;
use App\Repository\EventRepository;
use App\Repository\StreamInscriptionRepository;

class EventController extends BaseController
{

    public function index(Request $request, Serializer $serializer, EventRepository $repository)
    {
        $events = $repository->findAll();

        return $this->render("frontend/events/calendar", ["events" => $serializer->serialize($events, 'json')]);
    }

    public function stream(Request $request)
    {
        return $this->render("frontend/events/stream", [
            "stream" => "dev_geek",
            "host" => "localhost"
        ]);
    }

    public function streamSubscribe(Request $request, Stream $stream, StreamInscriptionRepository $repository)
    {
        if ($this->getUser()) {

            $subscription = $repository->findOneBy(["user_id" => $this->getUser()->getId(), "stream_id" => $stream->getId()]);

            if (is_null($subscription)) {
                $subscription = (new StreamInscription())->setUser($this->getUser())->setStream($stream);
                $this->entityManager->persist($subscription)->flush();
                $message = "Votre inscription a bien été prise en compte. A bientôt";
            } else {
                $message = "Vous avez déjà une inscription à votre nom";
            }
        }else{
            $message = "Vous devez êtes connecter pour vous inscrire";
        }

        return json_encode(["message" => $message]);
    }
}