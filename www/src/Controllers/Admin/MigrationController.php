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

    public $method = 'create';

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

    public function setMethod($method): self
    {
        if(!empty($method)){
            $this->method = $method;
        } else {
            //todo ajouter un message d'erreur avec le nom de la table et l'erreur d'action absent
            die('nok');
        }

        return $this;
    }

    public function setType($type): string
    {
        if(!empty($type)){
            return $type . ' ';
        } else {
            //todo ajouter un message d'erreur avec le nom de la table et l'erreur type absent
            die('nok');
        }
    }

    public function setOptions($options): string
    {
        if(!empty($options)){
            return implode(' ',$options) . ' ';
        } else {
            return '';
        }
    }

    public function setColumnName($columnName): string
    {
        if(!empty($columnName)){
            return $columnName . ' ';
        } else {
            //todo ajouter un message d'erreur avec le nom de la table et l'erreur de nom absent
            die('nok');
        }
    }
    public function setForeignKey($foreignKey): string
    {
        if(!empty($foreignKey)){
            return 'REFERENCES '.$foreignKey['table'].' ('.$foreignKey['column'].')';
        } else {
            return '';
        }
    }

    public function setDefaultValue($value): string
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
        if($row){
            $this->setId($row->getId());
            $this->setTableCurrentVersion($row->getCurrentVersion());
        } else {
            $this->addPatchList();
        }
    }

    public function setContent(): self
    {
        foreach ($this->datas as $version => $data) {
            $this->setVersion($version);
            $this->checkTableExist();

            if($version > $this->tableCurrentVersion){
                $this->setMethod($data['action']);
                foreach ($data['column'] as $column){
                    $this->content .= $this->setColumnName($column['name']);
                    $this->content .= $this->setType($column['type']);
                    $this->content .= $this->setOptions($column['options']);
                    $this->content .= $this->setDefaultValue($column['default']);
                    $this->content .= $this->setForeignKey($column['foreign_key']);
                    $this->content .= ', ';

                }
                if($this->method !== 'create'){
                    $this->updatePatchList();
                }
            }
        }

        $this->content = ltrim(substr($this->content, 0, -3));

        return $this;
    }

    public function processMigration(): self
    {
        foreach ($this->files as $file) {
            $this->setTableName($file);
            $this->setData($file);
            $this->setContent();

            $this->migration->setTableName($this->tableName);
            $this->migration->setContent($this->content);
            $this->migration->apply($this->method);

            $this->content = "";
        }

        return $this;
    }
}