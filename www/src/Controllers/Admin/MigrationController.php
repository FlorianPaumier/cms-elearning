<?php

namespace App\Controllers\Admin;

use App\Core\Database\Migration;
use App\Core\Interfaces\BaseController;
use App\Entity\PatchList;

class MigrationController extends BaseController
{
    private const MIGRATION_PATH = '../app/migration';

    public $migration;

    public $tableName = '';

    public $files = [];

    public $datas = [];

    public $options = [];

    public $type = '';

    public $method = '';

    public $content = '';

    public $version = '';

    public $tableCurrentVersion = '';

    public $id = '';

    public function index()
    {
        $this->migration = new Migration();

        $this->setFiles();
        $this->processMigration();

        return $this->renderer->render(
            'admin/migration/migration'
        );
    }

    public function setFiles(): self
    {
        $this->files = preg_grep('/^([^.])/', scandir(self::MIGRATION_PATH));

        return $this;
    }

    public function setData($file): self
    {
        $this->datas = yaml_parse_file(self::MIGRATION_PATH.'/'.$file);

        return $this;
    }

    public function setId($id): self
    {
        $this->id = $id;

        return $this;
    }

    public function setTableName($table): self
    {
        $this->tableName = preg_replace('/\..*/', '', strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $table)));

        return $this;
    }

    public function setMethod($method)
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

    public function formatType($type): string
    {
        if(!empty($type)){
            return $type . ' ';
        } else {
            dump($this->tableName.' need type');
            return false;
        }
    }

    public function formatOptions($options): string
    {
        if(!empty($options)){
            return implode(' ',$options) . ' ';
        } else {
            return '';
        }
    }

    public function formatColumnName($columnName): string
    {
        if(!empty($columnName)){
            return $columnName . ' ';
        } else {
            dump($this->tableName.' need column name');
            return false;
        }
    }
    public function formatForeignKey($foreignKey): string
    {
        if(!empty($foreignKey)){
            return 'REFERENCES '.$foreignKey['table'].' ('.$foreignKey['column'].')';
        } else {
            return '';
        }
    }

    public function formatDefaultValue($value): string
    {
        if(!empty($value)){
            return 'DEFAULT '. $value . ' ';
        }else{
            return '';
        }

    }

    public function setVersion($version): self
    {
        $this->version = $version;

        return $this;
    }

    public function addPatchList(): void
    {
        $patchList = new PatchList();
        $patchList->setTableName($this->tableName);
        $patchList->setCurrentVersion($this->version);

        $this->repository->from('patch_list')->persist($patchList)->flush();
    }

    public function updatePatchList(): void
    {
        $patchList = new PatchList();
        $patchList->setTableName($this->tableName);
        $patchList->setCurrentVersion($this->version);
        $patchList->setId($this->id);

        $this->repository->from('patch_list')->persist($patchList)->flush();
    }

    public function setTableCurrentVersion($currentVersion): self
    {
        $this->tableCurrentVersion = $currentVersion;

        return $this;
    }

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
                $this->addPatchList();
                $this->setTableCurrentVersion(null);
                return true;
            } else {
                $this->setId('');
                dump($this->tableName . ' first method should be "create"');
                return false;
            }
        }
    }

    public function setContent(): self
    {
        foreach ($this->datas as $version => $data) {
            dump($this->tableName);
            dump($data['method']);
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
                            break;
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

                dump($this->tableName);
                $this->migration->setTableName($this->tableName);
                $this->migration->setContent($this->content);
                $this->migration->apply($this->method);

                $this->content = "";

                if($this->method !== 'create' && !empty($this->id)){
                    $this->updatePatchList();
                }
            }
        }

        return $this;
    }

    public function processMigration(): self
    {
        foreach ($this->files as $file) {
            $this->setTableName($file);
            $this->setData($file);
            $this->setContent();
        }

        return $this;
    }
}