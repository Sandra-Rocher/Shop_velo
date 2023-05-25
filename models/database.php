<?php

namespace models;
use \PDO;
use \PDOException;

class Database {

     static public function getPDO(){
    //     return new PDO("mysql:host=localhost;dbname=velo", "root", "");
    // }
        try {
            return new PDO('mysql:host=localhost;dbname=velo', 'root', '');

        } catch(PDOException $e) {
            die('Erreur : '.$e->getMessage());
        }
    }
}

