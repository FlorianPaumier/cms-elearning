<?php


namespace App\Controllers\Chat;

use App\Core\Interfaces\BaseController;
use App\Form\ChatForm;

class ChatController extends BaseController
{
    public function index()
    {
        $form = $this->createForm(ChatForm::class);

        return $this->renderer->render(
            ROOT_PATH . "/public/views/chat/chat",
            ["form" => $form->createView()]
        );
    }
}