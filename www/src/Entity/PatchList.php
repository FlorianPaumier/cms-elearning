<?php


namespace App\Entity;

use App\Core\Interfaces\Entity;

class PatchList
{
    use Entity;

    /**
     * @var string $tableName;
     */
    public string $tableName;

    /**
     * @var int $currentVersion;
     */
    public int $currentVersion;

    /**
     * @return string
     */
    public function getTableName(): string
    {
        return $this->tableName;
    }

    /**
     * @param string $tableName
     */
    public function setTableName(string $tableName): void
    {
        $this->tableName = $tableName;
    }

    /**
     * @return int
     */
    public function getCurrentVersion(): int
    {
        return $this->currentVersion;
    }

    /**
     * @param int $currentVersion
     */
    public function setCurrentVersion(int $currentVersion): void
    {
        $this->currentVersion = $currentVersion;
    }


}