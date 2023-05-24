<?php

namespace models;

class Stock{

    private $products = array();

    protected $bdd;

    public function __construct()
    {
        $this->bdd = Database::getPDO();
    }

    public function findAll(){
        $select = $this->bdd->prepare("SELECT * FROM produits");
        $select->execute();

        return $select->fetchAll();
    }

    public function findAllAndStore(){
        $select = $this->bdd->prepare("SELECT * FROM produits");
        $select->execute();

        $toto = $select->fetchAll();

        foreach ($toto as $tot) {
           $produc = new Produit(); 

           $produc->setId_produit($tot["id"]);
           $produc->setDesignation($tot["designation"]);
           $produc->setReference($tot["reference"]);
           $produc->setPrixHT($tot["price_ht"]);
           $produc->setStock($tot["stock"]);
           $produc->setStock_alerte($tot["alerte"]);
           $produc->setTva($tot["id_tva"]);

           array_push($this->products, $produc);
        }

    }


    /**
     * Get the value of products
     */ 
    public function getProducts()
    {
        return $this->products;
    }


}
