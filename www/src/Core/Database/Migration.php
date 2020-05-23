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

        return $this;
    }

    public function alterAdd(): self
    {
        $this->sql = $this->method." ".$this->tableName." ". $this->content.";";

        return $this;
    }

    public function alterDrop(): self
    {
        $this->sql = $this->method." ".$this->tableName." ". $this->content.";";

        return $this;
    }

    public function apply($method)
    {
        switch($method){
            case 'create':
                $this->createTable();
                $this->create();
                dump($this->sql);
                $this->pdo->exec($this->sql);
                break;
            case 'alter-add':
                $this->alterTable();
                $this->alterAdd();
                dump($this->sql);
                $this->pdo->exec($this->sql);
                break;
            case 'alter-drop':
                $this->alterTable();
                $this->alterDrop();
                dump($this->sql);
                $this->pdo->exec($this->sql);
                break;
            case 'drop':
                $this->dropTable();
                $this->drop();
                dump($this->sql);
                break;
            default:
                dump($method . ' doesn\'t exit');
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