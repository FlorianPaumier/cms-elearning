<?php
namespace App\Core\Mailer;

class SendMailHandler extends MailerHandler
{
    public function __construct()
    {
        parent::__construct();
    }

    public function contact(array $dest){
        $this->setDest($dest);
        $this->setBody("Hello");
        $this->send();
    }
}