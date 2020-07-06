<?php


namespace App\Entity;

use App\Core\Interfaces\Entity;

class Commentary
{
    use Entity;

    /** @var string */
    protected $commentary;

    /** @var string */
    protected $user;

    /** @var string */
    protected $article;

    /** @var string */
    protected $createDate;

    /** @var string */
    protected $editDate;

    public function setCommentary(string $commentary){
        $this->commentary = $commentary;

        return $this->commentary;
    }

    public function getCommentary(){
        return $this->commentary;
    }

    public function getUser() {
        return $this->user;
    }

    public function getArticle() {
        return $this->article;
    }



}