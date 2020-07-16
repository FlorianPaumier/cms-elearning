<?php

namespace App\Core\Mailer;

use App\Core\Cache\CacheHandler;
use App\Core\Cache\ConfigHandler;
use App\Core\Kernel\Kernel;
use App\Core\Render\RenderView;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

class MailerHandler
{

    /** @var PHPMailer */
    private $mail;

    /** @var string */
    private $sender = "devweb.paumier@gmail.com";
    private $replyTo = "devweb.paumier@gmail.com";

    /** @var string */
    private $charset = "UTF-8";

    public function __construct()
    {
        if (file_exists(ROOT_PATH . "/lib/PHPMailer/vendor/autoload.php")) {
            $this->mail = $this->createTransport();
        }else{
            throw new \Exception("You need to install phpmailer");
        }
    }

    public function send(MailerMessage $message)
    {
        $this->mail->setFrom($this->sender);

        $this->setDest($message->getDest());
        $this->setBcc($message->getBcc());
        $this->setCc($message->getCc());
        $this->mail->addReplyTo($this->replyTo);
        $this->mail->isHTML(true);

        $content = $message->getBody();
        if ($content instanceof RenderView) {
            $content = $content->compile();
        }

        $this->mail->Subject = $message->getSubjet();
        $this->mail->Body = $content;

        try {
            $this->mail->send();
            return true;
        } catch (Exception $exception) {
            dump($exception->getMessage());
        }

        return false;
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

    private function createTransport(): PhpMailer
    {
        $config = CacheHandler::get("config")["mailer"];
        $mail = new PHPMailer(true);

        $this->sender = $config["username"];
        $this->replyTo = $config["username"];
        $mail->SMTPDebug = SMTP::DEBUG_OFF;                      // Enable verbose debug output
        $mail->isSMTP();                                            // Send using SMTP
        $mail->Host = $config["host"];                    // Set the SMTP server to send through
        $mail->SMTPAuth = $config["transport"] == "smtp";                                   // Enable SMTP authentication
        $mail->Username = $config["username"];                     // SMTP username
        $mail->Password = $config["password"];                               // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
        $mail->Port = $config["port"] ?? 25;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

        return $mail;
    }

    private function setDest(array $recipients)
    {
        try {
            foreach ($recipients as $key => $recipient) {
                $name = "";
                if (gettype($key) == 'string') {
                    $name = $key;
                }

                $this->mail->addAddress($recipient, $name);
            }
        } catch (Exception $exception) {
            dump($exception->getMessage());
        }
    }

    private function setBcc(array $bcc)
    {
        try {
            foreach ($bcc as $key => $recipient) {
                $name = "";
                if (gettype($key) == 'string') {
                    $name = $key;
                }

                $this->mail->addBCC($recipient, $name);
            }
        } catch (Exception $exception) {
            dump($exception->getMessage());
        }
    }

    private function setCc(array $cc)
    {
        try {
            foreach ($cc as $key => $recipient) {
                $name = "";
                if (gettype($key) == 'string') {
                    $name = $key;
                }

                $this->mail->addBCC($recipient, $name);
            }
        } catch (Exception $exception) {
            dump($exception->getMessage());
        }
    }

    public function sendTest()
    {
        $msg = (new MailerMessage())
            ->setDest($this->sender)
            ->setBody("Ceci est un test du mailer. Il fonctionne !")
            ->setSubjet("Test du mailer")
        ;

        return $this->send($msg);
    }

}