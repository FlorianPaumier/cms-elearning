<?php


namespace App\Entity;


use App\Core\Interfaces\Entity;

class OptionSondage
{

    use Entity;

    /** @var int */
    protected $id;

    /** @var int */
    protected $sondageId;

    /** @var string */
    protected $libelle_option;

    public function __construct(){}

    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return OptionSondage
     */
    public function setId(int $id): OptionSondage
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return int
     */
    public function getSondageId(): ?int
    {
        return $this->sondageId;
    }

    /**
     * @param string $sondageId
     * @return OptionSondage
     */
    public function setSondageId(int $sondageId): OptionSondage
    {
        $this->sondageId = $sondageId;
        return $this;
    }

    /**
     * @return string
     */
    public function getLibelleOption(): ?string
    {
        return $this->libelle_option;
    }

    /**
     * @param string $libelle_option
     * @return OptionSondage
     */
    public function setLibelleOption(string $libelle_option): OptionSondage
    {
        $this->libelle_option = $libelle_option;
        return $this;
    }
}