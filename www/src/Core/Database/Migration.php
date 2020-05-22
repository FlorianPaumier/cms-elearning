<?php

namespace App\Core\Database;

use PDO;

class Migration extends Table
{
    /*
     * Cette classe va regrouper toutes les actions possible d'effectuer sur les tables et les colonnes.
     */

    protected $tableName = "";

    protected $method = "CREATE TABLE IF NOT EXISTS";

    protected $content = "";

    protected $sql = "";

    public function __construct(PDO $pdo = null)
    {
        parent::__construct($pdo);
    }

    public function create(): self
    {
        $this->sql = $this->method." ".$this->tableName." (".$this->content.");";

        return $this;

    }

    public function drop(): self
    {
        $this->sql = $this->method." ".$this->tableName.";";
    }

    public function alter(): self
    {
        $this->sql = $this->method." ".$this->tableName;
    }

    public function apply($method)
    {
        switch($method){
            case 'create':
                $this->createTable();
                $this->create();
                $this->pdo->exec($this->sql);
                break;
            case 'alter':
                $this->alterTable();
                $this->alter();
                $this->pdo->exec($this->sql);
                break;
            case 'drop':
                $this->dropTable();
                $this->drop();
                break;
            default:
                die('missing method in yml');
                break;
        }
    }

    public function setTableName($tableName): self
    {
        $this->tableName = $tableName;
        return $this;
    }

    public function setContent($content): self
    {
        $this->content = $content;
        return $this;
    }

    public function createTable(): self
    {
        $this->method = "CREATE TABLE IF NOT EXISTS";
        return $this;
    }

    public function alterTable(): self
    {
        $this->method = "ALTER TABLE";
        return $this;
    }

    public function dropTable(): self
    {
        // see to add cascade
        $this->method = "DROP TABLE IF EXISTS";
        return $this;
    }

}