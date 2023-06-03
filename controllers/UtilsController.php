<?php

namespace controllers;


use \models\database;
use \models\employee;


class UtilsController{


    private $bdd;


    //Pour intérroger la base de données mysql
    public function __construct()
    {
        $this->bdd = Database::getPDO();

    }



    //Fonction connexion des employés
    public function connexion()
    {
        $prenom = (htmlspecialchars($_POST['prenom']));
        $pass = (htmlspecialchars($_POST["pass"]));

        $myEmployee = new Employee;
        $result = $myEmployee->findEmployeeForConnexion($prenom);

        if ($myEmployee->checkPasswordFromEmployee($result, $pass)) {
            header("Location: ../Stock/showStock");
        } else {
            echo "Mauvais login ou mot de passe";
            $page = "views/Accueil.phtml";
            require_once "views/Base.phtml";
        }
    }


    //Fonction déconnexion des employés
    public function deconnexion()
    {
        session_destroy();
        header('Location: ../Admin/index');
        die();
    }


}