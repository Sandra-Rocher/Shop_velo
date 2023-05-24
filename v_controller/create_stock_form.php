<?php

session_start();

// connexion avec la database
require_once '../v_model/datab.php';

if(isset($_POST['designation']) && ($_POST['reference']) && ($_POST['price_ht']) && ($_POST['stock']) && ($_POST['alerte']) && ($_POST['id_tva']) && (!empty($_POST['designation'])) && (!empty($_POST['reference'])) && (!empty($_POST['price_ht'])) && (!empty($_POST['stock'])) && (!empty($_POST['alerte'])) && (!empty($_POST['id_tva']))){
    

    $designation = htmlspecialchars($_POST['designation']);
    $reference = htmlspecialchars($_POST['reference']);
    $price_ht = htmlspecialchars($_POST['price_ht']);
    $stock = htmlspecialchars($_POST['stock']);
    $alerte = htmlspecialchars($_POST['alerte']);
    $id_tva = htmlspecialchars($_POST['id_tva']);


        $check = $pdo->prepare('SELECT reference FROM produits WHERE reference = ?');
        $check->execute(array($reference));
        $data = $check->fetch();



            if ($reference != $data['reference']) {

        
                // on add tout ici
                $insert = $pdo->prepare('INSERT INTO produits (designation, reference, price_ht, stock, alerte, id_tva)');
                if($insert->execute(array($designation, $reference, $price_ht, $stock, $alerte, $id_tva ))){

                echo "Nouvel article enregistré !";
                

                } else {
                    echo "Nouvel article non enregistré, ERREUR";
                    die();
                }


            } else {
                echo "Référence déja existante";
                die();
            }


}else{
    echo "Champs vide"; die();
}