<?php
// ini_set('error_reporting', E_ALL);
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);


define('ARHIV', include_once ("conf/whereArhiv--dir-cfg.php"));
include_once('class/PWDLS_mysql.class.php');


function main(){
    $dir = include_once("conf/whereToGetFales--file-cfg.php");
    $arrDir = getArrDir($dir);

    foreach ($arrDir as $value){
        setData($dir , $value);
    }
}

function foo($foo){
    echo '<pre>';
    var_dump($foo);
    echo '</pre>';
}

function getArrDir($dir){
    $result = scandir($dir);
    unset($result[0]);
    unset($result[1]);
    $result = array_values($result);

    return $result;
}

function setData($dir, $file){
    $data = file($dir . $file);
    $result = '';
    foreach ($data as $value){
        $result .= $value;
    }
    $result = btw($result);

    $guid = json_decode($result);
    $select = getSelect($result);
    PWDLS_mysql::getMySQL($select);

    arhive($guid->guid, $dir, $file);
}

function getSelect($data){
    $guid = json_decode($data);
    $select = 'select count(*) as result FROM tv_tehpas WHERE tv_guid = "' . $guid->guid . '";';
    $ob = PWDLS_mysql::getMySQL($select);

    if($ob[0]['result'] == 0){
        $result = "INSERT INTO tv_tehpas (tv_guid, tv_data) VALUES ('" . $guid->guid . "', '" . addslashes($data) . "');";
    } else {
        $result = "UPDATE tv_tehpas SET tv_data = '" . addslashes($data) . "' WHERE tv_guid = '" . $guid->guid . "';";
    }

    return $result;
}

function arhive($name, $lastDir, $fileName){
    $dir = substr($name, 0, 2);
    if (!is_dir(ARHIV . $dir)) {
        mkdir(ARHIV . $dir, 0700);
    }
    $dirFile = ARHIV . $dir . '/' . $name . '.json';
    if (file_exists($dirFile)) unlink($dirFile);
    rename($lastDir . $fileName, $dirFile);
}

function btw($b1) {
    $b1 = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $b1);
    $b1 = str_replace(array("\r\n", "\r", "\n", "\t"), '', $b1);
    return $b1;
}

main();