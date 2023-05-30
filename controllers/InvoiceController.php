<?php

namespace controllers;

use \models\database;
use \models\stock;
use \models\produit;
use \models\patron;
use \models\client;
use \models\invoice;


class InvoiceController{


    protected $bdd;


    public function __construct()
    {
        $this->bdd = Database::getPDO();
    }


    public function showInvoice(){

        $data = new Invoice;
        $result = $data->findAll_Invoices();

        $page = "views/ShowInvoice.phtml";
             
        require_once "views/Base.phtml";

    }



    public function createInvoice(){

        $data = new Stock;
        $result = $data->findAll();

        $data= new Client();
        $result2 = $data->findAll_Client();

        $page = "views/CreateInvoice.phtml";

        require_once "views/Base.phtml";

    }


    public function updateQuantity($produitId){

        $verif = $this->bdd->prepare('SELECT id, stock FROM `produits`
                                WHERE id = ? 
                                ');
        $verif->execute(array($produitId));
        $result = $verif->fetch();
        
        echo '<option value="">Choisissez votre quantité</option> ';
        for ($ii=1;$ii<=$result['stock'];$ii++) {
            echo '<option value="'.$result['id'].'">'.$ii.'</option> ';
        }
    }



    public function addProductsOnInvoice($IDproduit, $designation, $quantity){

        $verif = $this->bdd->prepare('SELECT * FROM `produits`
                                        WHERE id = ? 
                                        ');
        $verif->execute(array($IDproduit));
        $result = $verif->fetch();

        $data = new Produit();
        $data->setPrixHT($result['price_ht']);
        $data->setTva($result['id_tva']);
        $resultTTC = $data->calculateTTC();

        $calculht = $result['price_ht']->calculateTotalHT($quantity);
        $calculttc = $resultTTC->calculateTotalTTC($quantity);

        echo '<tr>
                <th scope="row">'.$IDproduit.'</th>
                <td>'.$designation.'</td>
                <td>'.$quantity.'</td>
                <td>'.$result['price_ht'].'</td>
                <td>'.$resultTTC.'</td>
                <td>'.$calculht.'</td>
                <td>'.$calculttc.'</td>
            </tr> ';

    
    }

}





// SELECT *, personnel.prenom AS personnelPrenom, clients.prenom AS clientPrenom, facture.id AS idFact
// FROM facture

// JOIN ligne_facture ON facture.id = ligne_facture.id_facture
// JOIN personnel ON facture.id_personnel = personnel.id 
// JOIN clients ON facture.id_client = clients.id

// WHERE facture.id = 7





// SELECT *, produits.price_ht AS produitPrixHT  
// FROM ligne_facture

// JOIN produits ON ligne_facture.id_produits = produits.id
// WHERE id_facture = 7


