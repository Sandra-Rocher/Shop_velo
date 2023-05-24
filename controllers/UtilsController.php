<?php

namespace controllers;


use \models\database;
use \models\employee;


class utils{


private $bdd;

//Pour intérroger la base de données mysql
public function __construct()
    {
        $this->bdd = Database::getPDO();
    }


    //fonction connexion des employés
    public function connexion()
    {
        $prenomEmp = new Employee();
        $result = $prenomEmp->findEmployeeForConnexion($_POST["prenom"]);

        if (password_verify($_POST["pass"], $result["id_password"])) {
            $_SESSION["id"] = $result["id"];
            $_SESSION["role"] = $result["id_role"];
            $_SESSION["prenom"] = $result["prenom"];
            return header("Location: ../Stock/showStock");
        } else {
            echo "Mauvais mot de passe";
            $page = "views/Accueil.phtml";
            require_once "views/Base.phtml";
        }
    }


//fonction déconnexion des employés
public function deconnexion(){

    session_destroy();
    header('Location: ../velo/index.php');
    die();
}





}