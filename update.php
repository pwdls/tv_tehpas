<?php
// ini_set('error_reporting', E_ALL);
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);

define('ARHIV', include_once("conf/whereArhiv--dir-cfg.php"));

function main()
{
    $dir = include_once("conf/whereToGetFales--file-cfg.php");
    $arrDir = getArrDir($dir);

    foreach ($arrDir as $value) {
        setData($dir, $value);
    }
}

function getArrDir($dir)
{
    $result = scandir($dir);
    unset($result[0]);
    unset($result[1]);
    $result = array_values($result);

    return $result;
}

function setData($dir, $file)
{
    $data = file($dir . $file);
    $result = '';
    foreach ($data as $value) {
        $result .= $value;
    }
    $result = btw($result);
    $guid = json_decode($result);

    if (!empty($guid->guid) && $guid->result == 0) {
        arhive($guid->guid, $dir, $file);
    }

}

function arhive($name, $lastDir, $fileName)
{
    $dir = substr($name, 0, 2);
    if (!is_dir(ARHIV . $dir)) {
        mkdir(ARHIV . $dir, 0700);
    }
    $dirFile = ARHIV . $dir . '/' . $name . '.json';
    if (file_exists($dirFile)) unlink($dirFile);
    rename($lastDir . $fileName, $dirFile);
}

function btw($b1)
{
    $b1 = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $b1);
    $b1 = str_replace(array("\r\n", "\r", "\n", "\t"), '', $b1);
    return $b1;
}

function foo($foo)
{
    echo '<pre>';
    var_dump($foo);
    echo '</pre>';
}

main();