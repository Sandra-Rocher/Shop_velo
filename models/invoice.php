<?php


namespace models;


class Invoice{


    private $bdd;


    public function __construct()
    {
        $this->bdd = Database::getPDO();
    }


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

}