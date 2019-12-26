<?php

$directories = scandir("../src");
foreach($directories as $directory){
    $dir = scandir('../src/'.$directory);
    foreach($dir as $content){ //en dehors de Core
        if($content == 'Entity'){
            //Sélectionner dans la base de donnée, la dernière version de la table, et ou supérieur
            $files = scandir('../src/'.$directory.'/'.$content);
            foreach($files as $key => $file){
                $filePath = lcfirst($directory).'Entity.yml';
                if ($filePath == $file){
                    $entity_content = yaml_parse_file('../src/'.$directory.'/'.$content.'/'.$filePath); //parser et lire le fichier pour mettre en place la création de base de données ainsi que la lecture à travers une commande php ???
                    checkVersion($directory,$entity_content);
                    //$action = $entity_content['version']['action'];
                    //$column = $entity_content['version']['column'];
                    //@todo ajout d'une création de table relationnel si il y a des clé étrangère et pouvoir mettre à jour si besoin

                    //check($directory,$version,$action,$column);
                }
            }
        }
    }
}

// vérification de version

function checkVersion($directory,$entity_content){
    foreach($entity_content as $key => $array){
        if($key == 'version_1'){
            $version = $key;
            $action = $array['action'];
            $column = $array['column'];
            check($directory,$version,$action,$column);
        }
    }
}

function check($direcotry,$version, $action, $column){
    if( $version != 'O.O.1'){
        //echo 'ok';
    }else{
        //echo 'nok';
    }

    switch ($action){
        case 'create':
            createTable($direcotry,$column);
            break;
        case 'update':
            updateTable($column);
            break;
        case 'drop':
            dropTable();
            break;
        default:
            echo 'ork';
            break;
    }
}

function tableConfigurable($columns){
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

function createTable($name,$columns)
{
    $name = strtolower($name);

    $content = tableConfigurable($columns);

    echo "create table ".$name."{".$content."}";
}

function updateTable($column)
{

}

function dropTable(){

}

