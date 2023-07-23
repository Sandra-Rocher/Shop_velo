<?php

namespace controllers;

use \models\Database;
use \models\Stock;
use \models\Produit;
use \models\Patron;
use \models\Client;
use \models\Invoice;


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



    // public function addInvoiceOnBDD avec $data qui contient : $totalHT, $totalTTC, $idClient, $idPersonnel, $quantities, $productIds
       public function addInvoiceOnBDD($data) {

         $data2 = json_decode($data, true);

         //Valeurs de TotalHT TotalTCC idClient et IdPersonnel
        $totalHT = $data2[0];
        $totalTTC = $data2[1];
        $idClient = $data2[2];
        $idPersonnel = $data2[3];

        //Tableau des produits et de leurs quantités 
        $quantities = $data2[4];
        $productIds = $data2[5];
    
        //Creer une nouvelle facture avec les 4 premieres valeurs : $totalHT, $totalTTC, $idClient, $idPersonnel
        // Prends la valeur de retour (lastInsertId()) stocké dans $idFacture pour la prochaine fonction
        $invoice = new Invoice();
        $idFacture = $invoice->addInvoiceFactOnBDD($totalHT, $totalTTC, $idClient , $idPersonnel);
    
        //Creer les lignes de facture pour chaque produit + quantité avec l'idfacture (lastInsertId()) qui est revenu
        // de la fonction addInvoiceFactOnBDD
        foreach ($quantities as $key => $quantity) {
            $productId = $productIds[$key];
            $invoice->addInvoiceLigneOnBDD($quantity, $productId, $idFacture);
        }
    
        //Update le stock pour chaque produit + sa quantité
        foreach ($quantities as $key => $quantity) {
            $productId = $productIds[$key];
            $sold = new Patron();
            $sold->updateProduitWhenSold($quantity, $productId);
        }
    
        //Redirige
        $page = "views/showInvoice.phtml";
        require_once "views/Base.phtml";
     }


     //Fonction qui permet de visualiser la facture client au click sur la loupe via l'id facture
     public function finalyInvoices($id){

        $data = new Invoice;
        $details = $data->finalyInv($id);

        $page = "views/ShowFinalInvoice.phtml";
        require_once "views/Base.phtml";

     }

     public function showPDF($id){

        $data = new Invoice;
        $details = $data->finalyInv($id);

        //$page = "views/ShowFinalInvoice.phtml"; Pas besoin car il target_blank
        //require_once "views/Base.phtml"; Pas besoin car il target_blank aussi
        require_once "fpdf.php";

     }


}


