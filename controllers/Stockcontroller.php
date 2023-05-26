<?php

namespace controllers;

use \models\database;
use \models\stock;
use \models\produit;
use \models\patron;



class StockController{

    protected $bdd;

    public function __construct()
    {
        $this->bdd = Database::getPDO();
    }

    //fonction qui montre le stock
    public function showStock(){
        
        $data = new Stock();
        $data->findAllAndStore();

        $result = $data->getProducts();

        $page = "views/ShowStock.phtml";
        require_once "views/Base.phtml";


    }

    //fonction pour creer un nouveau produit dans le stock
    public function createStock(){


        // Vérifier si des données ont été soumises via POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Créer une instance de la classe Produit
            $produit = new Produit();
        
            // Récupérer les données du formulaire
            $produit->setDesignation(htmlspecialchars($_POST['designation']));
            $produit->setReference(htmlspecialchars($_POST['reference']));
            $produit->setPrixHT(htmlspecialchars($_POST['price_ht']));
            $produit->setStock(htmlspecialchars($_POST['stock']));
            $produit->setStock_alerte(htmlspecialchars($_POST['alerte']));
            $produit->setTva(htmlspecialchars($_POST['id_tva']));
        
        
            // Appeler la fonction addClient() pour ajouter le Produit
            $patron= new Patron();
            $patron->addProduit($produit);
        
        
            // Rediriger vers une page de confirmation ou effectuer d'autres actions après l'ajout du Produit
            header('Location: /velo/Stock/showStock');
            exit;
        }
        //Si aucun post n'a été fait, on dirige ainsi :
        $page = "views/CreateStock.phtml";

        // $page2 = "views/ShowStock.phtml";
        $data = new Stock();
        $data->findAllAndStore();
        $result = $data->getProducts();

        require_once "views/Base.phtml";
    }

    //fonction pour modifier un produit
    public function updateProduit(){

        // Vérifier si des données ont été soumises via POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // En vue d'appeler la fonction updateProduit() pour update le Produit
            $patron = new Patron();

            //tous les field qui ont étaient POST sont stockés dans $fields
            $fields = $_POST['field'];

            //pour chacun d'entre eux, on les analyse un par un
            foreach ($fields as $field){
                // Créer une instance de la classe Produit
                $produit = new Produit();
            
                // Récupérer les données du formulaire
                $produit->setId_Produit(htmlspecialchars($field['id_produit']));
                $produit->setDesignation(htmlspecialchars($field['designation']));
                $produit->setReference(htmlspecialchars($field['reference']));
                $produit->setPrixHT(htmlspecialchars($field['price_ht']));
                $produit->setStock(htmlspecialchars($field['stock']));
                $produit->setStock_alerte(htmlspecialchars($field['alerte']));
                $produit->setTva(htmlspecialchars($field['id_tva']));
            
                // Appeler la fonction updateProduit() situé dans la classe Patron déja instancié plus haut pour update le Produit
                $patron->updateProduit($produit);
            }
        
            // Rediriger vers une page de confirmation ou effectuer d'autres actions après l'ajout du Produit
            header('Location: /velo/Stock/showStock');
            exit;
        }
        
        $page = "views/createStock.phtml";

        require_once "views/Base.phtml";
    }

    //fonction pour delete un produit par son $id
    public function deleteProduit($id){

        $data = new Patron();
        $data->deleteProduit($id);

        header('Location: /velo/Stock/showStock');
        exit;
        
        require_once "views/Base.phtml";
    }
            
}


