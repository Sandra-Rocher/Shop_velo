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


    //Fonction qui montre toute les factures présente dans la bdd
    public function showInvoice(){

        $data = new Invoice;
        $result = $data->findAll_Invoices();

        $page = "views/ShowInvoice.phtml";
             
        require_once "views/Base.phtml";

    }


    //Fonction pour afficher toute les produits et les clients afin de pouvoir selectionné quel produit pour quel client
    public function createInvoice(){

        $data = new Stock;
        $result = $data->findAll();

        $data= new Client();
        $result2 = $data->findAll_Client();

        $page = "views/CreateInvoice.phtml";

        require_once "views/Base.phtml";

    }


    //Fonction qui, lorsque le produit est selectionné, intérroge la bdd et renvoi la quantité disponible
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



    //Fonction qui ajoute dans un tableau le produit et sa quantité en calculant le HT et le TTC
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

        $data->getTva($result['price_ht']);
        $calculht = $data->calculateTotalHT($quantity);

        $calculttc = $data->calculateTotalTTC($resultTTC, $quantity);

        echo '<tr>
                <th scope="row">'.$IDproduit.'</th>
                <td>'.$designation.'</td>
                <td>'.$quantity.'</td>
                <td>'.$result['price_ht'].'€</td>
                <td>'.$resultTTC.'€</td>
                <td>'.$calculht.'€</td>
                <td>'.$calculttc.'€</td>
            </tr> ';
    }


    


    public function addInvoiceOnBDD($totalHT, $totalTTC, $idClient, $idPersonnel, $quantities, $productIds){

        $data = new Invoice();
        $idFacture = $data->addInvoiceFactOnBDD($totalHT, $totalTTC, $idClient, $idPersonnel);

        
        $data->addInvoiceLigneOnBDD($quantities, $productIds, $idFacture);


        $page = "views/ShowInvoice.phtml";

        require_once "views/Base.phtml";
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


