<?php


namespace App\Core\Mailer;


use App\Core\Render\RenderView;

class MailerMessage
{
    /** @var array  */
    private $dest = [];

    /** @var string */
    private $subjet = "";

    /** @var string|RenderView */
    private $body = "";

    /** @var array  */
    private $bcc = [];

    /** @var array  */
    private $cc = [];

    /** @var string */
    private $contentType = "text";

    /**
     * @return array
     */
    public function getDest(): array
    {
        return $this->dest;
    }

    /**
     * @param array $dest
     * @return MailerMessage
     */
    public function setDest(array $dest): MailerMessage
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
     * @return MailerMessage
     */
    public function setSubjet(string $subjet): MailerMessage
    {
        $this->subjet = $subjet;
        return $this;
    }

    /**
     * @return RenderView|string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param RenderView|string $body
     * @return MailerMessage
     */
    public function setBody($body)
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
     * @return MailerMessage
     */
    public function setBcc(array $bcc): MailerMessage
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
     * @return MailerMessage
     */
    public function setCc(array $cc): MailerMessage
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
     * @return MailerMessage
     */
    public function setContentType(string $contentType): MailerMessage
    {
        $this->contentType = $contentType;
        return $this;
    }

}