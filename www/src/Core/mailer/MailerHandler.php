<?php

namespace App\Core\Mailer;

use App\Core\Cache\CacheHandler;
use App\Core\Cache\ConfigHandler;
use App\Core\Kernel\Kernel;
use PHPMailer\PHPMailer\PHPMailer;

class MailerHandler
{

    /** @var PHPMailer */
    private $swiftmailer;

    /** @var string */
    private $sender = "devweb.paumier@gmail.com";

    /** @var array  */
    private $dest = [];

    /** @var string */
    private $subjet;

    /** @var PHPMailer */
    private $body;

    /** @var array  */
    private $bcc = [];

    /** @var array  */
    private $cc = [];

    /** @var string */
    private $contentType = "text";

    /** @var string */
    private $charset = "UTF-8";

    public function __construct()
    {
       $this->swiftmailer = new PHPMailer($this->createTransport());
    }

    public function send()
    {
        $message = new Swift_Message($this->subjet, $this->body, $this->contentType, $this->charset);

        $message->setTo($this->dest);
        $message->setFrom($this->sender);
        $message->setFrom($this->sender);

        return $this->swiftmailer->send($message);
    }

    /**
     * @return string
     */
    public function getSender(): string
    {
        return $this->sender;
    }

    /**
     * @param string $sender
     * @return MailerHandler
     */
    public function setSender(string $sender): MailerHandler
    {
        $this->sender = $sender;
        return $this;
    }

    /**
     * @return array
     */
    public function getDest(): array
    {
        return $this->dest;
    }

    /**
     * @param array $dest
     * @return MailerHandler
     */
    public function setDest(array $dest): MailerHandler
    {
        $this->dest = $dest;
        return $this;
    }

    /**
     * @return string
     */
    public function getSubjet(): string
    {
        return $this->subjet;
    }

    /**
     * @param string $subjet
     * @return MailerHandler
     */
    public function setSubjet(string $subjet): MailerHandler
    {
        $this->subjet = $subjet;
        return $this;
    }

    /**
     * @return string
     */
    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * @param string $body
     * @return MailerHandler
     */
    public function setBody(string $body): MailerHandler
    {
        $this->body = $body;
        return $this;
    }

    /**
     * @return array
     */
    public function getBcc(): array
    {
        return $this->bcc;
    }

    /**
     * @param array $bcc
     * @return MailerHandler
     */
    public function setBcc(array $bcc): MailerHandler
    {
        $this->bcc = $bcc;
        return $this;
    }

    /**
     * @return array
     */
    public function getCc(): array
    {
        return $this->cc;
    }

    /**
     * @param array $cc
     * @return MailerHandler
     */
    public function setCc(array $cc): MailerHandler
    {
        $this->cc = $cc;
        return $this;
    }

    /**
     * @return string
     */
    public function getContentType(): string
    {
        return $this->contentType;
    }

    /**
     * @param string $contentType
     * @return MailerHandler
     */
    public function setContentType(string $contentType): MailerHandler
    {
        $this->contentType = $contentType;
        return $this;
    }

    /**
     * @return string
     */
    public function getCharset(): string
    {
        return $this->charset;
    }

    /**
     * @param string $charset
     * @return MailerHandler
     */
    public function setCharset(string $charset): MailerHandler
    {
        $this->charset = $charset;
        return $this;
    }

    private function createTransport(): Swift_SmtpTransport
    {
        $config = CacheHandler::get("config")["swiftmailer"];
        dump(CacheHandler::get("config")["swiftmailer"], "mail");
        $transport = new Swift_SmtpTransport($config["host"], $config["port"] ?? 25, $config["encryption"]);

        if(!is_null($config["username"])){
            $transport->setUsername($config["username"]);
        }

        if(!is_null($config["password"])){
            $transport->setPassword($config["password"]);
        }

        return $transport;
    }
}