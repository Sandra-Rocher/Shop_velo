<?php

namespace models;

use \PDO;
use \PDOException;

class Database {

    //Fonction pdo bdd
     static public function getPDO(){
    
        try {
            return new PDO('mysql:host=localhost;dbname=velo', 'root', '');
            

        } catch(PDOException $e) {
            die('Erreur : '.$e->getMessage());
        }
    }
}

