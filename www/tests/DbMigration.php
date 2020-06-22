<?php
$migrationPath = "../app/config/migration";

$tables = preg_grep('/^([^.])/', scandir($migrationPath));

foreach ($tables as $table){
    $versions = yaml_parse_file($migrationPath."/".$table);
    $table = preg_replace('\..*/', '', strtolower($table));
    foreach ($versions as $key => $version) {
        if($key == "2" ) {
            switch($version['action']) {
                case 'create':
                    createTable($table,$version['column']);
                    break;
                case 'add-col':
                    addTableColumn($table,$version['column']);
                    break;
                case 'mod-col':
                    //$this->dropTable();
                    break;
                default:
                    return 0;
                    break;
            }
        }
    }
}


function createTable($table,$columns)
{
    $content = tableConfigurable($columns);

    echo "create table ".$table."{".$content."}";
}

function addTableColumn($table,$columns)
{
    $content = tableConfigurableAddColumn($columns);
    var_dump($content);
    echo "ALTER TABLE " . $table . " ADD COLUMN " .$content. ";";
}

function alterTableColumn($table,$columns) {


}

function dropTableColumn($table,$columns) {


}

function dropTable($name){
    $sql = 'DROP TABLE '.$name;

}

function tableConfigurable($columns){
    $sentence = '';
    $content = '';
    foreach ($columns as $column){
        foreach ($column as $key => $value){
            if($key == "options"){
                $options = implode(" ",$value);
            }

            if($key == "foreign_key") {
                $foreignKey = ' REFERENCES ' . $value['table'] . '(' . $value['column'] . ')';
            } else {
                $foreignKey = '';
            }

        }
        $sentence = $column['name'].' '.$column['type'].' '.$options.''.$foreignKey;
        $options = '';
        $content = $content.' '.$sentence.', ';
        $sentence = '';
    }

    $content = ltrim(substr($content, 0, -2));
    return $content;
}

function tableConfigurableAddColumn($columns){
    $sentence = '';
    $content = '';
    foreach ($columns as $column){
        foreach ($column as $key => $value){
            if($key == "options"){
                $options = implode(" ",$value);
            }

            if($key == "foreign_key") {
                $foreignKey = ' REFERENCES ' . $value['table'] . '(' . $value['column'] . ')';
            } else {
                $foreignKey = '';
            }

        }
        $sentence = $column['name'].' '.$column['type'].' '.$options.''.$foreignKey;
        $options = '';
        $content = $content.' '.$sentence.', ';
        $sentence = '';
    }

    $content = ltrim(substr($content, 0, -2));
    return $content;
}
die();
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

