<?php

namespace App\Core\database;

use PDO;

class EntityGenerator extends QueryBuilder
{

    const PATH = '../src';

    public function __construct(PDO $pdo = null)
    {
        parent::__construct($pdo);
        $this->checkDirectory();
    }

    private function getPdo(): \PDO
    {
        return $this->pdo;
    }

    function parseTableConfigurable($columns): string
    {
        $sentence = '';
        $content = '';
        foreach ($columns as $column){
            foreach ($column as $key => $value){
                if($key == "options"){
                    $options = implode(" ",$value);
                }
            }
            $sentence = $column['name'].' '.$column['type'].' '.$options;
            $options = '';
            $content = $content.' '.$sentence.', ';
            $sentence = '';
        }
        $content = ltrim(substr($content, 0, -2));
        return $content;
    }

    private function getFeature(): array
    {
        return scandir(self::PATH);
    }

    private function checkDirectory(){
        $directories = $this->getFeature();
        foreach($directories as $directory){
            $dir = scandir('../src/'.$directory);
            foreach($dir as $content){ //en dehors de Core
                if($content == 'Entity'){
                    //Sélectionner dans la base de donnée, la dernière version de la table, et ou supérieur
                    $files = scandir('../src/'.$directory.'/'.$content);
                    foreach($files as $file){
                        $filePath = lcfirst($directory).'Entity.yml';
                        if ($filePath == $file){
                            $entity_content = yaml_parse_file('../src/'.$directory.'/'.$content.'/'.$filePath); //parser et lire le fichier pour mettre en place la création de base de données ainsi que la lecture à travers une commande php ???

                            $this->checkVersion($entity_content);
                            //$version = $entity_content['version'];
                            //$action = $entity_content['action'];
                            //$column = $entity_content['column'];
                            //@todo ajout d'une création de table relationnel si il y a des clé étrangère et pouvoir mettre à jour si besoin

                            $this->check($directory,$version,$action,$column);
                        }
                    }
                }
            }
        }
    }

    private function checkVersion($entity_content){
        foreach($entity_content as $key => $value){
            echo $key;
            var_dump($value);
        }
    }

    private function check($directory,$version, $action, $column){
        if( $version != 'O.O.1'){
            switch ($action){
                case 'create':
                    $this->createTable($directory,$column);
                    break;
                case 'update':
                    $this->updateTable($directory,$column);
                    break;
                case 'drop':
                    $this->dropTable($directory);
                    break;
                default:
                    echo 'ork';
                    break;
            }
        }
    }

    private function updateTable($directory,$column){

    }

    private function progression($action,$table)
    {
        echo $action.' of '.strtolower($table).'...';
    }

    private function createTable($table,$columns)
    {
        $table = strtolower($table);

        $content = $this->parseTableConfigurable($columns);

        $this->pdo->exec("CREATE TABLE ".$table."{".$content."}");

    }

    private function dropTable($table){
        $this->pdo->exec("DROP TABLE ".$table);
    }

}