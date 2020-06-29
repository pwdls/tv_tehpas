<?php

class PWDLS_mysql
{
    /*    private $host = '127.0.0.1';
      private $db = 'sitemanager0';
      private $user = 'magok';
      private $pass = 'ehj;fq'; */

    private $host;
    private $db;
    private $user;
    private $pass;
    private $mysql;

    private function __construct($id = 0)
    {
        $base = include('../conf/mysql--dostup-cfg.php');
        if (!empty($base[$id])) {
            $this->host = '127.0.0.1';
            $this->db = 'tehpas';
            $this->user = 'root';
            $this->pass = '';

            $this->mysql = new \mysqli($this->host, $this->user, $this->pass, $this->db);
            if (!$this->mysql) {
                echo "Ошибка: Невозможно установить соединение с MySQL." . PHP_EOL;
                echo "Код ошибки errno: " . mysqli_connect_errno() . PHP_EOL;
            } else {
                $this->mysql->query('SET NAMES utf8');
            }
        }
    }

    static public function getMySQL($mas, $id = 0)
    {
        $foo = new PWDLS_mysql($id);
        if (gettype($mas) == 'array') {
            $i = 1;
            while ($i <= count($mas)) {
                $res = $foo->mysql->query($mas[$i - 1]);
                $i++;
            }
        } else {
            $res = $foo->mysql->query($mas);
        }
        $foo->mysql->close();
        if ($res->num_rows != 0) {
            while ($row = $res->fetch_array()) {
                $result[] = $row;
            }
        } else {
            $result = 'FALSE';
        }
        return $result;
    }

}