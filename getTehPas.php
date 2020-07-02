<?php
define('ARHIV', include_once("conf/whereArhiv--dir-cfg.php"));
header('Content-Type: text/html; charset=utf-8');

function main()
{
    $guid = filter_input(INPUT_GET, 'guid');

    if (!empty($guid)) {
        $file = ARHIV . substr($guid, 0, 2) . '/' . $guid . '.json';

        if (file_exists($file)) {
            echo getFile($file);
        } else {
            echo '{"result":"1"}';
        }
    }
}

function getFile($file)
{
    $data = file($file);
    $result = '';
    foreach ($data as $value) {
        $result .= $value;
    }
    $result = btw($result);
    return $result;
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