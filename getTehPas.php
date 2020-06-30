<?php
header('Content-Type: text/html; charset=utf-8');
include_once('class/PWDLS_mysql.class.php');
$guid = filter_input(INPUT_GET,'guid');
if(!empty($guid)){
    $select = 'select tv_data FROM tv_tehpas WHERE tv_guid = "' . $guid . '";';
    $ob = PWDLS_mysql::getMySQL($select);
    if($ob){
        echo $ob[0]['tv_data'];
    } else {
        echo '{"result":"1"}';
    }
}