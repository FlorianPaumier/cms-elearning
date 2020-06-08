<?php


namespace App\Entity;

use App\Core\Interfaces\Entity;

class PatchList
{
    use Entity;

    public $tableName;

    public $currentVersion;

    /**
     * @return mixed
     */
    public function getTableName()
    {
        return $this->tableName;
    }

    /**
     * @param mixed $tableName
     */
    public function setTableName($tableName)
    {
        $this->tableName = $tableName;
    }

    /**
     * @return mixed
     */
    public function getCurrentVersion()
    {
        return $this->currentVersion;
    }

    /**
     * @param mixed $currentVersion
     */
    public function setCurrentVersion($currentVersion)
    {
        $this->currentVersion = $currentVersion;
    }


}