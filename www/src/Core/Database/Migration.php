<?php

namespace App\Core\Database;

use PDO;

class Migration extends EntityManager
{
    /** @var string $tableName */
    protected $tableName = "";

    /** @var string $method */
    protected $method = "CREATE TABLE IF NOT EXISTS";

    /** @var string $content */
    protected $content = "";

    /** @var string $sql */
    protected $sql = "";

    /**
     * Migration constructor.
     *
     * @param PDO|null $pdo
     */
    public function __construct(PDO $pdo = null)
    {
        parent::__construct($pdo);
    }

    /**
     * Set sql request in $sql for CREATE TABLE syntax;
     * 
     * @return $this
     */
    public function create(): self
    {
        $this->sql = $this->method." ".$this->tableName." (".$this->content.");";

        return $this;

    }

    /**
     * Set sql request in $sql for DROP TABLE syntax;
     *
     * @return $this
     */
    public function drop(): self
    {
        $this->sql = $this->method." ".$this->tableName.";";

        return $this;
    }

    /**
     * Set sql request in $sql for ALTER TABLE ... ADD COLUMN syntax;
     *
     * @return $this
     */
    public function alterAdd(): self
    {
        $this->sql = $this->method." ".$this->tableName." ". $this->content.";";

        return $this;
    }

    /**
     * Set sql request in $sql for ALTER TABLE ... DROP COLUMN syntax;
     *
     * @return $this
     */
    public function alterDrop(): self
    {
        $this->sql = $this->method." ".$this->tableName." ". $this->content.";";

        return $this;
    }

    /**
     * Select the method to execute sql request
     *
     * @param string $method
     */
    public function apply($method): void
    {
        switch($method){
            case 'create':
                $this->createTable();
                $this->create();
                $this->pdo->exec($this->sql);
                break;
            case 'alter-add':
                $this->alterTable();
                $this->alterAdd();
                $this->pdo->exec($this->sql);
                break;
            case 'alter-drop':
                $this->alterTable();
                $this->alterDrop();
                $this->pdo->exec($this->sql);
                break;
            case 'drop':
                $this->dropTable();
                $this->drop();
                break;
            default:
                dump($method . ' doesn\'t exit');
                break;
        }
    }

    /**
     * Set table name value
     *
     * @param string $tableName
     *
     * @return $this
     */
    public function setTableName(string $tableName): self
    {
        $this->tableName = $tableName;

        return $this;
    }

    /**
     * Set content value
     *
     * @param string $content
     *
     * @return $this
     */
    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Set sql method CREATE TABLE;
     *
     * @return $this
     */
    public function createTable(): self
    {
        $this->method = "CREATE TABLE IF NOT EXISTS";

        return $this;
    }

    /**
     * Set sql method ALTER TABLE;
     *
     * @return $this
     */
    public function alterTable(): self
    {
        $this->method = "ALTER TABLE";
        return $this;
    }

    /**
     * Set sql method ALTER TABLE;
     *
     * @return $this
     */
    public function dropTable(): self
    {
        // see to add cascade
        $this->method = "DROP TABLE IF EXISTS";
        return $this;
    }

}