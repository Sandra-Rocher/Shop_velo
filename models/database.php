<?php

namespace models;
use \PDO;

class Database {

    static public function getPDO(){
        return new PDO("mysql:host=localhost;dbname=velo", "root", "");
    }
}

?>


