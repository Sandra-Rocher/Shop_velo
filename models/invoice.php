<?php

namespace models;


class Invoice{


    private $bdd;


    public function __construct()
    {
        $this->bdd = Database::getPDO();
    }

    //Fonction pour afficher toute les factures
    public function findAll_Invoices()
    {

        $select = $this->bdd->prepare("SELECT *, facture.id AS idFact, personnel.prenom, clients.nom
                                        FROM facture
                                        JOIN personnel ON facture.id_personnel = personnel.id
                                        JOIN clients ON facture.id_client = clients.id
                                        ORDER BY dateFact ASC
                                        ");
        $select->execute();

        return $select->fetchAll();

    }




    //Fonction pour inserer en bdd les factures
    public function addInvoiceFactOnBDD($totalHT, $totalTTC, $idClient, $idPersonnel)
    {
        $insert = $this->bdd->prepare('INSERT INTO facture (prix_ht, prix_ttc, id_client, id_personnel)
                                        VALUES (?, ?, ?, ?) ');
        $insert->execute(array($totalHT, $totalTTC, $idClient, $idPersonnel));

        return $this->bdd->lastInsertId();
    }

    
    //Fonction pour inserer en bdd les lignes des factures
    public function addInvoiceLigneOnBDD($quantite, $id_produits, $idFacture){

        $insert = $this->bdd->prepare('INSERT INTO ligne_facture (quantite, id_produits, id_facture)
                                        VALUES (?, ?, ?) ');
        $insert->execute(array($quantite, $id_produits, $idFacture));
    }



    //Fonction qui affiche lors du click sur loupe la facture complète du client 
    public function finalyInv($id){

        $select = $this->bdd->prepare("SELECT *, personnel.prenom AS personnelPrenom, clients.prenom 
                                                                AS clientPrenom, facture.id 
                                                                AS idFact
                                        FROM facture
                                        JOIN ligne_facture ON facture.id = ligne_facture.id_facture
                                        JOIN personnel ON facture.id_personnel = personnel.id 
                                        JOIN clients ON facture.id_client = clients.id
                                        JOIN produits ON ligne_facture.id_produits = produits.id 
                                        WHERE facture.id = ?
                                        ");
        $select->execute(array($id));

        return $select->fetchAll();

    }

}

