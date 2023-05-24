<?php

namespace models;


class Produit
{

    protected $id_produit;
    protected $designation;
    protected $reference;
    protected $prixHT;
    protected $stock;
    protected $stock_alerte;
    protected $tva;

    protected $bdd;


    public function __construct()
    {
        $this->bdd = Database::getPDO();
    }


    /**
     * Get the value of id_produit
     */
    public function getId_produit()
    {
        return $this->id_produit;
    }

    /**
     * Set the value of id_produit
     *
     * @return  self
     */
    public function setId_produit($id_produit)
    {
        $this->id_produit = $id_produit;

        return $this;
    }

    /**
     * Get the value of designation
     */
    public function getDesignation()
    {
        return $this->designation;
    }

    /**
     * Set the value of designation
     *
     * @return  self
     */
    public function setDesignation($designation)
    {
        $this->designation = $designation;

        return $this;
    }

    /**
     * Get the value of reference
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * Set the value of reference
     *
     * @return  self
     */
    public function setReference($reference)
    {
        $this->reference = $reference;

        return $this;
    }

    /**
     * Get the value of prixHT
     */
    public function getPrixHT()
    {
        return $this->prixHT;
    }

    /**
     * Set the value of prixHT
     *
     * @return  self
     */
    public function setPrixHT($prixHT)
    {
        $this->prixHT = $prixHT;

        return $this;
    }

    /**
     * Get the value of stock
     */
    public function getStock()
    {
        return $this->stock;
    }

    /**
     * Set the value of stock
     *
     * @return  self
     */
    public function setStock($stock)
    {
        $this->stock = $stock;

        return $this;
    }

    /**
     * Get the value of stock_alerte
     */
    public function getStock_alerte()
    {
        return $this->stock_alerte;
    }

    /**
     * Set the value of stock_alerte
     *
     * @return  self
     */
    public function setStock_alerte($stock_alerte)
    {
        $this->stock_alerte = $stock_alerte;

        return $this;
    }

    /**
     * Get the value of tva
     */
    public function getTva()
    {
        return $this->tva;
    }

    /**
     * Set the value of tva
     *
     * @return  self
     */
    public function setTva($tva)
    {
        $this->tva = $tva;

        return $this;
    }



    public function calculateTTC()
    {
        return $this->prixHT * $this->tva;
    }


    public function isAlerteStock()
    {
        return ($this->stock > $this->stock_alerte) ? false : true;
    }




}
