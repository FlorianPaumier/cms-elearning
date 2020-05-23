<?php

namespace App\Controllers\Admin;

use App\Core\Database\Migration;
use App\Core\Interfaces\BaseController;
use App\Core\Render\RenderView;
use App\Entity\PatchList;
use Exception;

/**
 * Class MigrationController
 * @package App\Controllers\Admin
 */
class MigrationController extends BaseController
{
    /**
     * @const string MIGRATION_PATH;
     */
    private const MIGRATION_PATH = '../app/migration';

    /**
     * @var object $migration;
     */
    public $migration;

    /**
     * @var string $tableName
     */
    public $tableName = '';

    /**
     * @var array $files
     */
    public $files = [];

    /**
     * @var array $datas
     */
    public $datas = [];

    /**
     * @var array $options
     */
    public $options = [];

    /**
     * @var string $type
     */
    public $type = '';

    /**
     * @var string $method
     */
    public $method = '';

    /**
     * @var string $content
     */
    public $content = '';

    /**
     * @var string $version
     */
    public $version = '';

    /**
     * @var string $tableCurrentVersion
     */
    public $tableCurrentVersion = '';

    /**
     * @var string $id
     */
    public $id = '';

    /**
     * @return RenderView|string|string[]|null
     * @throws Exception
     */
    public function index()
    {
        $this->migration = new Migration();

        $this->processMigration();

        return $this->renderer->render(
            'admin/migration/migration'
        );
    }

    /**
     * Set list of file for migration
     *
     * @return $this
     */
    public function setFiles(): self
    {
        $this->files = preg_grep('/^([^.])/', scandir(self::MIGRATION_PATH));

        return $this;
    }

    /**
     * Set list of data from yml file
     *
     * @param string $file
     * @return $this
     */
    public function setData(string $file): self
    {
        $this->datas = yaml_parse_file(self::MIGRATION_PATH.'/'.$file);

        return $this;
    }

    /**
     * set id
     *
     * @param int|string $id
     * @return $this
     */
    public function setId($id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * set table name
     *
     * @param string $table
     * @return $this
     */
    public function setTableName(string $table): self
    {
        $this->tableName = preg_replace('/\..*/', '', strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $table)));

        return $this;
    }

    /**
     * set method
     *
     * @param string $method
     * @return $this|bool
     */
    public function setMethod(string $method)
    {
        if(!empty($method)){
            $this->method = $method;
        } else {
            $this->method = '';
            dump($this->tableName.' method empty');
            return false;
        }

        return $this;
    }

    /**
     * return column type if not empty
     *
     * @param string $type
     * @return string
     */
    public function formatType(string $type): string
    {
        if(!empty($type)){
            return $type . ' ';
        } else {
            dump($this->tableName.' need type');
            return false;
        }
    }

    /**
     * return implode options if not empty
     *
     * @param null|array $options
     * @return string
     */
    public function formatOptions(?array $options): string
    {
        if(!empty($options)){
            return implode(' ',$options) . ' ';
        } else {
            return '';
        }
    }

    /**
     * return column name if exist
     *
     * @param null|string $columnName
     * @return bool|string
     */
    public function formatColumnName(?string $columnName)
    {
        if(!empty($columnName)){
            return $columnName . ' ';
        } else {
            dump($this->tableName.' need column name');
            return false;
        }
    }

    /**
     * return foreign key it exist
     *
     * @param null|string[] $foreignKey
     * @return string
     */
    public function formatForeignKey(?array $foreignKey): string
    {
        if(!empty($foreignKey)){
            return 'REFERENCES '.$foreignKey['table'].' ('.$foreignKey['column'].')';
        } else {
            return '';
        }
    }

    /**
     * return default value if exist
     *
     * @param null|string $value
     * @return string
     */
    public function formatDefaultValue(?string $value): string
    {
        if(!empty($value)){
            return 'DEFAULT '. $value . ' ';
        }else{
            return '';
        }

    }

    /**
     * return version
     *
     * @param int $version
     * @return $this
     */
    public function setVersion(int $version): self
    {
        $this->version = $version;

        return $this;
    }

    /**
     *  add new row of table name and version in patch_list
     */
    public function addPatchList(): void
    {
        $patchList = new PatchList();
        $patchList->setTableName($this->tableName);
        $patchList->setCurrentVersion($this->version);

        $this->repository->from('patch_list')->persist($patchList)->flush();
    }

    /**
     *  update existing row of table name and version in patch_list
     */
    public function updatePatchList(): void
    {
        $patchList = new PatchList();
        $patchList->setTableName($this->tableName);
        $patchList->setCurrentVersion($this->version);
        $patchList->setId($this->id);

        $this->repository->from('patch_list')->persist($patchList)->flush();
    }

    /**
     * set value of current version of table if exist in patch_list
     *
     * @param null|int $currentVersion
     * @return $this
     */
    public function setTableCurrentVersion(?int $currentVersion): self
    {
        $this->tableCurrentVersion = $currentVersion;

        return $this;
    }

    /**
     * check if table exist or not then set data get by sql request in patch_list
     *
     * @return bool
     * @throws \App\Core\Exception\NoRecordException
     */
    public function checkTableExist()
    {
        $this->repository->getClass(PatchList::class);
        $row = $this->repository->findBy(["table_name" => $this->tableName]);
        if($row && !is_array($row)){
            $this->setId($row->getId());
            $this->setTableCurrentVersion($row->getCurrentVersion());
            return true;
        } else {
            if($this->method === 'create') {
                $this->setTableCurrentVersion(null);
                return true;
            } else {
                $this->setId('');
                dump($this->tableName . ' first method should be "create"');
                return false;
            }
        }
    }

    /**
     * Set sql content to execute in sql request
     *
     * @return $this
     * @throws \App\Core\Exception\NoRecordException
     */
    public function setContent(): self
    {
        foreach ($this->datas as $version => $data) {
            if(!is_int($version)){
                dump($this->tableName . ' version must be an integer');
                break;
            }
            if($this->setMethod($data['method']) === false) {
                break;
            }
            $this->setVersion($version);
            if($this->checkTableExist() === false ) {
                break;
            }
            
            if($version > $this->tableCurrentVersion){
                if($this->method !== 'drop'){
                    foreach ($data['column'] as $column){
                        if($this->method === 'alter-add') {
                            $this->content .= 'ADD COLUMN ';
                        }else if($this->method === 'alter-drop') {
                            $this->content .= 'DROP COLUMN ';
                        }

                        if($this->formatColumnName($column['name']) === false ) {
                            break 2;
                        } else {
                            $this->content .= $this->formatColumnName($column['name']);
                        }

                        if($this->method !== 'alter-drop') {
                            $this->content .= $this->formatType($column['type']);
                            $this->content .= $this->formatOptions($column['options']);
                            $this->content .= $this->formatDefaultValue($column['default']);
                            $this->content .= $this->formatForeignKey($column['foreign_key']);
                        }
                        $this->content .= ', ';
                    }
                }

                $this->content = ltrim(substr($this->content, 0, -3));

                $this->migration->setTableName($this->tableName);
                $this->migration->setContent($this->content);
                $this->migration->apply($this->method);

                $this->content = "";

                if($this->method !== 'create' && !empty($this->id)){
                    $this->updatePatchList();
                } else {
                    $this->addPatchList();
                }
            }
        }

        return $this;
    }

    /**
     * execute migration
     *
     * @return $this
     * @throws \App\Core\Exception\NoRecordException
     */
    public function processMigration(): self
    {
        $this->setFiles();

        foreach ($this->files as $file) {
            $this->setTableName($file);
            $this->setData($file);
            $this->setContent();
        }

        return $this;
    }
}