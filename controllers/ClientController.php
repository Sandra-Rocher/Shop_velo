<?php

namespace controllers;


use \models\client;
// use \models\patron;


class ClientController{


    //fonction qui affiche tous les clients
    public function showClient(){

        $data= new Client();
        $result = $data->findAll_Client();

        $page = "views/ShowClient.phtml";
        require_once "views/Base.phtml";
    }




    //fonction qui creer un client
    public function createClient(){


    // Vérifier si des données ont été soumises via POST
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        
    // Créer une instance de la classe Client
    $client = new Client();

    // Récupérer les données du formulaire
    $client->setLastname(htmlspecialchars($_POST['lastname']));
    $client->setFirstname(htmlspecialchars($_POST['firstname']));
    $client->setAdress1(htmlspecialchars($_POST['adress1']));
    $client->setAdress2(htmlspecialchars($_POST['adress2']));
    $client->setPostal_code(htmlspecialchars($_POST['postal_code']));
    $client->setCity(htmlspecialchars($_POST['city']));
    $client->setEmail(filter_var(htmlspecialchars($_POST['email'])), FILTER_VALIDATE_EMAIL);
    $client->setPhone(htmlspecialchars($_POST['phone']));

    // Appeler la fonction addClient() pour ajouter le client
    $client->addClient();

    // Rediriger vers une page
    header('Location: /velo/Client/showClient');
    exit;
}

        $page = "views/CreateClient.phtml";

        $data= new Client();
        $result = $data->findAll_Client();

        $page = "views/CreateClient.phtml";
        require_once "views/Base.phtml";
    }


    //fonction qui modifie un ou plusieurs client(s) en même temps
    public function updateClient(){

        // Vérifier si des données ont été soumises via POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            //récupère les données qui ont été POST en field et les mets tous dans la variable $fields
            $fields = $_POST['field'];

            // pour chaque field rassemblés dans $fields on boucle et on les sort :
            foreach ($fields as $field){

                // on créer une instance client pour chacun
                $client = new Client();
            
                // Récupérer les données du formulaire pour chaque field
                $client->setId(htmlspecialchars($field['id_client']));
                $client->setLastname(htmlspecialchars($field['lastname']));
                $client->setFirstname(htmlspecialchars($field['firstname']));
                $client->setAdress1(htmlspecialchars($field['adress1']));
                $client->setAdress2(htmlspecialchars($field['adress2']));
                $client->setPostal_code(htmlspecialchars($field['postal_code']));
                $client->setCity(htmlspecialchars($field['city']));
                $client->setEmail(htmlspecialchars($field['email']));
                $client->setPhone(htmlspecialchars($field['phone']));
            
                // update le/les client(s) avec la fonction updateclient situé dans la classe client
                $client->updateClient();
            }
    
            // Rediriger vers une page
            header('Location: /velo/Client/showClient');
            exit;
        }
    
            $page = "views/CreateClient.phtml";
            require_once "views/Base.phtml";
        }
    

        //Fonction qui delete un client par son $id lû par le routing en [2] parametres newUrl
        public function deleteClient($id){

            $data = new Client();
            $data->deleteClient($id);

            header('Location: /velo/Client/showClient');
            exit;
            
            require_once "views/Base.phtml";
        
            
        }

}