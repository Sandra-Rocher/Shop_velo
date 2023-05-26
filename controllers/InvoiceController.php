<?php

namespace controllers;

use \models\database;
use \models\stock;
use \models\produit;
use \models\patron;
use \models\invoice;


class InvoiceController{


    protected $bdd;


    public function __construct()
    {
        $this->bdd = Database::getPDO();
    }


    public function showInvoice(){

        $data = new Invoice;
        $result = $data->findAll_Invoices();

        $page = "views/ShowInvoice.phtml";
             
        require_once "views/Base.phtml";

    }


    public function showAllProduit(){

        $data = new Invoice;
        $result = $data->findAll_Invoices();

        $page = "views/ShowInvoice.phtml";
             
        require_once "views/Base.phtml";

    }






    public function createInvoice(){



    }


}