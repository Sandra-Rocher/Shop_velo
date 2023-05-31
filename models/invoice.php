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

        $select = $this->bdd->prepare("SELECT *, facture.id AS factID, personnel.prenom, clients.nom
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

        $idFacture = $this->bdd->lastInsertId();
        return $idFacture;
    }

    
    //Fonction pour inserer en bdd les lignes des factures
    public function addInvoiceLigneOnBDD($quantite, $id_produits, $idFacture){

        $insert = $this->bdd->prepare('INSERT INTO ligne_facture (quantite, id_produits, id_facture)
                                        VALUES (?, ?, ?) ');
        $insert->execute(array($quantite, $id_produits, $idFacture));
    }

}