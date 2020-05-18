<?php


namespace App\Controllers\Chat;

use App\Core\Cache\ConfigHandler;
use App\Core\Interfaces\BaseController;
use App\Core\Request\Request;
use App\Entity\ChatMessage;
use App\Entity\ChatSession;
use App\Form\ChatForm;

class ChatController extends BaseController
{
    public function index(Request $request)
    {
        $chatMessage = new ChatMessage();

        //$this->repository->getClass(User::class);
        //$users = $this->repository->findAll();

        $this->repository->getClass(ChatMessage::class);
        $messages = $this->repository->findBy(['id_session' => $_SESSION['id_session']]);

        $this->repository->getClass(ChatSession::class);
        $chatSession = $this->repository->findAll();

        $form = $this->createForm(ChatForm::class, $chatMessage);
        $form->handleRequest($request);

        if ($request->getMethod() == "POST" && $form->isValid()) {
            $em = ConfigHandler::get("repository");
            $chatMessage->setIdUser($_SESSION["id_user"]);
            $chatMessage->setIdSession($_SESSION["id_session"]);
            $em->persist($chatMessage);
            $em->flush();
            $this->redirect->redirectToRoute("app_chat");
        }

        return $this->renderer->render(
            "chat/chat", [
                "form" => $form->createView(),
                "messages" => $messages,
                "chatSession" => $chatSession
                //"users" => $users
            ]
        );
    }
}