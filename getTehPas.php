<?php
header('Content-Type: text/html; charset=utf-8');
$guid = filter_input(INPUT_GET,'guid');
if(!empty($guid)){
    $select = 'select tv_data as result FROM TV_TEHPAS WHERE tv_guid = "' . $guid . '";';
    $ob = PWDLS_mysql::getMySQL($select);
    if($ob){
        echo $ob['tv_data'];
    }
}