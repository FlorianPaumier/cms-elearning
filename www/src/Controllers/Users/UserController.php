<?php
namespace Controllers\Users;

use security\UserManager;

class UserController extends UserManager
{
    private $userManager;
    private $redirect;

    public function __construct(){
        $this->userManager = Kernel::get("userManager");
        $this->redirect = new RedirectionHandler();
    }


    public function login(){
        if ($this->userManager->isConnected()) {
            # code...
        }
    }
}
