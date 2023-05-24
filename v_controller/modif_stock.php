<?php

session_start();

// connexion avec la database
require_once '../v_model/datab.php';

if(isset($_POST['produit']) && (!empty($_POST['produit']))){
    

    $produit = htmlspecialchars($_POST['produit']);
    
        $insert = $pdo->prepare('INSERT INTO produits');
        $insert->execute(array('produit'));

        // il faudra rajouter quel colonne on veut modifier ? plusieurs select peut etre..

 

}