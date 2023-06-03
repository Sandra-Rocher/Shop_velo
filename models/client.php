<?php

namespace models;

class Client extends Human{

    private $adress1;
    private $adress2;
    private $postal_code;
    private $city;
    private $email;
    private $phone;


    /**
     * Get the value of adress1
     */ 
    public function getAdress1()
    {
        return $this->adress1;
    }

    /**
     * Set the value of adress1
     *
     * @return  self
     */ 
    public function setAdress1($adress1)
    {
        $this->adress1 = $adress1;

        return $this;
    }

    /**
     * Get the value of adress2
     */ 
    public function getAdress2()
    {
        return $this->adress2;
    }

    /**
     * Set the value of adress2
     *
     * @return  self
     */ 
    public function setAdress2($adress2)
    {
        $this->adress2 = $adress2;

        return $this;
    }

    /**
     * Get the value of postal_code
     */ 
    public function getPostal_code()
    {
        return $this->postal_code;
    }

    /**
     * Set the value of postal_code
     *
     * @return  self
     */ 
    public function setPostal_code($postal_code)
    {
        $this->postal_code = $postal_code;

        return $this;
    }

    /**
     * Get the value of city
     */ 
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set the value of city
     *
     * @return  self
     */ 
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get the value of email
     */ 
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */ 
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of phone
     */ 
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set the value of phone
     *
     * @return  self
     */ 
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }


    //Fonction qui affiche tous les clients
    public function findAll_Client()
    {

        $select = $this->bdd->prepare("SELECT * FROM clients");
        $select->execute();

        return $select->fetchAll();
    }


    //Fonction qui ajoute un client
    public function addClient()
    {
        $insert = $this->bdd->prepare('INSERT INTO clients (nom, prenom, adresse1, adresse2, code_postal, ville, email, telephone)
                                        VALUES (?, ?, ?, ?, ?, ?, ?, ?) ');
        $insert->execute(array($this->firstname, $this->lastname, $this->adress1, $this->adress2, $this->postal_code, $this->city, $this->email, $this->phone ));

    }


    //Fonction qui supprime un client
    public function deleteClient($id)
    {
        $insert = $this->bdd->prepare('DELETE FROM clients WHERE id = ?');
        $insert->execute(array($id));

    }

    //Fonction qui modifie les données d'un client
    public function updateClient()
    {

        $insert = $this->bdd->prepare('UPDATE clients SET nom = ?, prenom = ?, adresse1 = ?, adresse2 = ?, code_postal = ?, ville = ?, email = ?, telephone = ?
                                        WHERE id = ?');
        $insert->execute([$this->lastname, $this->firstname, $this->adress1, $this->adress2, $this->postal_code, $this->city, $this->email, $this->phone, $this->id]);

    }


}