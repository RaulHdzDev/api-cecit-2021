<?php

namespace App\App;

use PDO;

class Database
{

    // COTACYT
    // private $host   = 'plataforma.cotacyt.gob.mx';
    // private $user   = 'innovacion';
    // private $pass   = 'W4HndVUhHBcZ343Z';
    // private $dbname = 'sistema_evaluacion';

    // ACM / TECDEVS
    private $host   = 'mante.hosting.acm.org';
    private $user   = 'mantehostingacm_kt';
    private $pass   = 'QWERTYKtdral_014';
    private $dbname = 'mantehostingacm_CotacytXXI';

    function connect()
    {
        $pdo = new PDO(
            'mysql:host=' . $this->host . ';dbname=' . $this->dbname, $this->user, $this->pass,
            array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8')
        );
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        return $pdo;
    }
}
