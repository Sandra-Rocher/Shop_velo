<?php

namespace controllers;


use \models\database;
use \models\employee;


class UtilsController{

    private $message;
    private $bdd;


//Pour intérroger la base de données mysql
public function __construct()
    {
        $this->bdd = Database::getPDO();

    }



    //fonction connexion des employés
    public function connexion()
    {
        $prenom = $_POST['prenom'];
        $pass = $_POST["pass"];

        $result = new Employee;
        $result->findEmployeeForConnexion($prenom);


        $message = $this->message->checkPasswordFromEmployee($result, $pass);

        if ($message) {
            header("Location: ../Stock/showStock");
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