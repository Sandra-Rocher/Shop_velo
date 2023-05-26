<?php

namespace models;

class Employee extends Human{

    protected $role;
    protected $pass;


    /**
     * Get the value of role
     */ 
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Set the value of role
     *
     * @return  self
     */ 
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get the value of pass
     */ 
    public function getPass()
    {
        return $this->pass;
    }

    /**
     * Set the value of pass
     *
     * @return  self
     */ 
    public function setPass($pass)
    {
        $this->pass = $pass;

        return $this;
    }

    /**
     * L'id passait ici est celle du session start du vendeur concerné par ses ventes mensuelles
     */ 
    public function getSalesOfTheMonth($id)
    {
        $select = $this->bdd->prepare("SELECT *
                                        FROM facture
                                        WHERE MONTH(dateFact) = MONTH(CURDATE()) 
                                        AND id_personnel = ?");
        $select->execute(array($id));

        return $select->fetchAll();

    }
    

    /**
     * L'id passait ici est celle du session start du vendeur concerné par ses ventes annuelles
     */ 
    public function getSalesOfTheYear($id)
    {
        $select = $this->bdd->prepare("SELECT * 
                                        FROM facture
                                        WHERE YEAR(dateFact) = YEAR(CURDATE()) 
                                        AND dateFact >= CONCAT(YEAR(CURDATE()), '-01-01')
                                        AND dateFact <= CURDATE() 
                                        AND id_personnel = ?");
        $select->execute(array($id));

        return $select->fetchAll();
    }



//TODO : creation de la facture par pdf... ici on cherche a rassembler les lignes_factures à leurs factures
    public function createInvoice($id)
    {
        $insert = $this->bdd->prepare('INSERT INTO facture (prix_ht, prix_ttc, id_client, id_personnel)');
        ($insert->execute(array($id)));
    }

    

    public function findEmployeeForConnexion($prenom)
    {
        $select = $this->bdd->prepare("SELECT * FROM personnel WHERE prenom = ?");
        $select->execute(array($prenom));

        return $select->fetch();
    }


    public function checkPasswordFromEmployee($result, $pass)
    {
        if (password_verify($pass, $result["id_password"])) {
            $_SESSION["id"] = $result["id"];
            $_SESSION["role"] = $result["id_role"];
            $_SESSION["prenom"] = $result["prenom"];
            return true;
        } else {
            return false;
        }
    }

}


