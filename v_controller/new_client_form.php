<?php

session_start();

// connexion avec la database
require_once '../v_model/datab.php';


// Traitement de l'inscription ci dessous
if (isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['adresse1']) && isset($_POST['adresse2']) && isset($_POST['code_postal']) && isset($_POST['ville']) && isset($_POST['email']) && isset($_POST['telephone'])) {
    $nom = htmlspecialchars($_POST['nom']);
    $prenom = htmlspecialchars($_POST['prenom']);
    $adresse1 = htmlspecialchars($_POST['adresse1']);
    $adresse2 = htmlspecialchars($_POST['adresse2']);
    $code_postal = htmlspecialchars($_POST['code_postal']);
    $ville = htmlspecialchars($_POST['ville']);
    $email = htmlspecialchars($_POST['email']);
    $telephone = htmlspecialchars($_POST['telephone']);

    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {


        $check = $pdo->prepare('SELECT nom, prenom, adresse1, adresse2, code_postal, ville, email, telephone FROM clients WHERE email = ?');
        $check->execute(array($email));
        $data = $check->fetch();

            if ($email != $data['email']) {

        
                // on add tout ici
                $insert = $pdo->prepare('INSERT INTO clients (nom, prenom, adresse1, adresse2, code_postal, ville, email, telephone)');
                if($insert->execute(array($nom, $prenom, $adresse1, $adresse2, $code_postal, $ville, $email, $telephone ))){
       
                   echo "Inscription client réussie !";
                

                } else {
                    echo "Inscription client raté";
                    die();
                }


            } else {
                echo "Email déja existant";
                die();
            }

    } else {
        echo "Email non valide";
        die();
    }

}