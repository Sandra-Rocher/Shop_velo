<?php

namespace models;


use models\Produit;


class Patron extends Employee{ 


    //Fonction qui affiche tous les personnels
    public function findAll_Personnel()
    {

        $select = $this->bdd->prepare("SELECT id, prenom, id_role FROM personnel");
        $select->execute();

        return $select->fetchAll();

    }

    //Pour add un personnel, le patron donnera en $value un objet : employee qui contient tout ce qu'il faut, donc on utilise les 
    //getteurs de firsname dans human, et getpass get role dans employee
    public function addPersonnel(Employee $value)
    {
        $insert = $this->bdd->prepare('INSERT INTO personnel (prenom, id_password, id_role)
                                         VALUES (?, ?, ?) ');
        ($insert->execute(array($value->getFirstname(), $value->getPass(), $value->getRole())));

    }

    //pour delete le patron devra donner un $id (ici on ne dit pas this->id sinon on donnerai l'id du patron)
    public function deletePersonnel(string $id)
    {
        $insert = $this->bdd->prepare('DELETE FROM personnel WHERE id = ?');
        ($insert->execute(array($id)));

    }

    //Pour update un personnel, le patron donnera en $value un objet : employee qui contient tout ce qu'il faut, donc on utilise les
    //  getteurs de firsname dans human, et  get role dans employee
    public function updatePersonnel(Employee $value)
    {

        $insert = $this->bdd->prepare('UPDATE personnel SET prenom = ?, id_role = ?
                                        WHERE id = ?');
        $insert->execute(array($value->getFirstname(), $value->getRole(), $value->getId()));

    }



    //Fonction pour ajouter un produit    
    public function addProduit(Produit $value)
    {
        $insert = $this->bdd->prepare('INSERT INTO produits (designation, reference, price_ht, stock, alerte, id_tva)
                                        VALUES (?, ?, ?, ?, ?, ?) ');
        $insert->execute(array($value->getDesignation(), $value->getReference(), $value->getPrixHT(), $value->getStock(), $value->getStock_alerte(), $value->Gettva() ));

    }


    //Fonction pour modifier un produit
    public function updateProduit(Produit $value)
    {

        $insert = $this->bdd->prepare('UPDATE produits SET designation = ?, reference = ?, price_ht = ?, stock = ?, alerte = ?, id_tva = ?
                                        WHERE id = ?');
        $insert->execute(array($value->getDesignation(), $value->getReference(), $value->getPrixHT(), $value->getStock(), $value->getStock_alerte(), $value->getTva(), $value->getId_produit()));

    }


    //Fonction pour supprimer un produit quand il a été vendue donc modifier son stock uniquement (soustraction)
    public function updateProduitWhenSold($stockSold, $id)
    {

        $insert = $this->bdd->prepare('UPDATE produits SET stock = stock - ?
                                        WHERE id = ?');
        $insert->execute(array($stockSold, $id));
    }


    //Fonction pour supprimer un produit
    public function deleteProduit(string $id)
    {
        $insert = $this->bdd->prepare('DELETE FROM produits WHERE id = ?');
        $insert->execute(array($id));

    }


 
//Affiche les ventes du journalières, et le chiffre d'affaires généré
    public function getSalesOfTheDay()
    {
        $select = $this->bdd->prepare("SELECT SUM(prix_ttc) AS Total 
                                        FROM facture
                                        WHERE DATE(dateFact) = CURDATE()");
        $select->execute();

        return $select->fetchAll();
    }



//Affiche un récapitulatif mensuel des ventes par produit : id produit designation + quantité cumulé
  public function getSalesOfStockOfTheMonth()
    {
        $select = $this->bdd->prepare("SELECT SUM(quantite), id_produits, designation
                                        FROM ligne_facture
                                        JOIN facture ON ligne_facture.id_facture = facture.id
                                        JOIN produits ON ligne_facture.id_produits = produits.id
                                        WHERE MONTH(facture.dateFact) = MONTH(CURDATE()) GROUP BY id_produits");
        $select->execute();

        return $select->fetchAll();
    }


//Affiche le total TVA collecté par mois
    public function getSalesOfStockOfTheMonthAndShowTVA()
    {
        $select = $this->bdd->prepare("SELECT SUM(prix_ht) AS total_ht,
                                         SUM(prix_ttc) AS total_ttc,
                                         (SUM(prix_ttc) - SUM(prix_ht)) AS TVA_a_reverser
                                        FROM facture
                                        WHERE MONTH(facture.dateFact) = MONTH(CURDATE())");
        $select->execute();

        return $select->fetchAll();
    }

    


//- Affiche l'un état cumulé des ventes par produit depuis le premier janvier de l’année en cours.
    public function getSalesOfStockOfTheYear()
    {
        $select = $this->bdd->prepare("SELECT SUM(quantite), id_produits, designation
                                        FROM ligne_facture
                                        JOIN facture ON ligne_facture.id_facture = facture.id
                                        JOIN produits ON ligne_facture.id_produits = produits.id
                                        WHERE YEAR(facture.dateFact) = YEAR(CURDATE()) 
                                        AND facture.dateFact >= CONCAT(YEAR(CURDATE()), '-01-01') 
                                        GROUP BY id_produits 
                                        ORDER BY id_produits ASC");
        $select->execute();

        return $select->fetchAll();

    }
    
    

//- Disposer d’un montant total des ventes HT par vendeur par mois. 
    public function getSalesByEmployeesByMonth()
    {
        $select = $this->bdd->prepare("SELECT id_personnel, prenom, SUM(prix_ht)
                                        FROM facture
                                        JOIN personnel ON facture.id_personnel = personnel.id
                                        WHERE MONTH(facture.dateFact) = MONTH(CURDATE())
                                        GROUP BY id_personnel");
        $select->execute();

        return $select->fetchAll();

    }


    //Affiche le total des ventes par employés sur l'année depuis le 01 janvier
    public function getSalesByEmployeesByYear()
    {
        $select = $this->bdd->prepare("SELECT id_personnel, prenom, SUM(prix_ht)
                                        FROM facture
                                        JOIN personnel ON facture.id_personnel = personnel.id
                                        WHERE YEAR(facture.dateFact) = YEAR(CURDATE()) 
                                        AND facture.dateFact >= CONCAT(YEAR(CURDATE()), '-01-01')
                                        GROUP BY id_personnel");
        $select->execute();

        return $select->fetchAll();

    }
  

}


