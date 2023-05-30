<?php

//Je suis bien dans l'espace du dossier controllers
namespace controllers;

//J'ai besoin des données situées dans d'autres pages
use models\Patron;
use models\Employee;



class AdminController{

    public function index(){

        
        // session_start();

        //Je mets dans la variable $page ce que contient accueil.phtml situé dans le dossier views
        $page = "views/Accueil.phtml";

        //J'ajoute ce que contient la page base.phtml situé dans le dossier views
        require_once "views/Base.phtml";

    }

        //Fonction qui montre tout le personnel
        public function showPersonnels(){

            $data = new Patron();
            $result = $data->findAll_Personnel();

            $page = "views/ShowPersonnels.phtml";
             
            require_once "views/Base.phtml";
        }

        //Fonction qui creer un personnel
        public function createPersonnel(){


            // Vérifier si des données ont été soumises via POST
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Créer une instance de la classe Personnel
            $personnel = new Employee();
        
            // Récupérer les données du formulaire
            $personnel->setFirstname(htmlspecialchars($_POST['firstname']));
            $personnel->setRole(htmlspecialchars($_POST['role']));
            $personnel->setPass(password_hash(htmlspecialchars($_POST['pass']), PASSWORD_DEFAULT));
        
            // Appeler la fonction addClient() dans Patron() pour ajouter le Personnel
            $patron= new Patron();
            $patron->addPersonnel($personnel);
        
            // Rediriger vers une page
            header('Location: /velo/Admin/ShowPersonnels');
            exit;
        }
        
                //Si aucun $_POST n'a été fait : il arrive direct ici et attends qu'on lui POST qqchose
                $page = "views/CreatePersonnel.phtml";


                $data = new Patron();
                $result = $data->findAll_Personnel();

                $page = "views/CreatePersonnel.phtml";

        
                require_once "views/Base.phtml";
            }


            //fonction qui modifie un ou plusieurs personnel(s) en même temps
            public function updatePersonnel(){


                // Vérifier si des données ont été soumises via POST
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {

                    // Appeler la fonction addClient() pour ajouter le Personnel
                    $patron= new Patron();

                    $fields = ($_POST['field']);

                    foreach ($fields as $field){

                        // Créer une instance de la classe Personnel
                        $personnel = new Employee();
                    
                        // Récupérer les données du formulaire
                        $personnel->setId(htmlspecialchars($field['id_personnel']));
                        $personnel->setFirstname(htmlspecialchars($field['firstname']));
                        $personnel->setRole(htmlspecialchars($field['role']));
                        
                        $patron->updatePersonnel($personnel);
                    }
 
            
                    // Rediriger vers une page de confirmation ou effectuer d'autres actions après l'ajout du Personnel
                    header('Location: /velo/Admin/ShowPersonnels');
                    exit;
                }
            
                    $page = "views/CreatePersonnel.phtml";
            
                    require_once "views/Base.phtml";
                }
    


            //fonction qui delete un personnel par son $id lû par le routing en [2] parametres newUrl
            public function deletePersonnel($id){

                $data = new Patron();
                $data->deletePersonnel($id);
    
                header('Location: /velo/Admin/showPersonnels');
                exit;
                
                require_once "views/Base.phtml";
            
            }



    
            public function showSales(){

                $data = new Patron();
                $salesOfTheDay = $data->getSalesOfTheDay();
                $salesOfStockOfTheMonth = $data->getSalesOfStockOfTheMonth();
                $SalesOfStockOfTheMonthAndShowTVA = $data->getSalesOfStockOfTheMonthAndShowTVA();
                $SalesOfStockOfTheYear = $data->getSalesOfStockOfTheYear();
                $SalesByEmployeesByMonth = $data->getSalesByEmployeesByMonth();
                $SalesByEmployeesByYear = $data->getSalesByEmployeesByYear();

                $data2 = new Employee();
                $id = $_SESSION['id'];
                $SalesOfTheMonth = $data->getSalesOfTheMonth($id);
                $SalesOfTheYear = $data->getSalesOfTheYear($id);

                $page = "views/showSales.phtml";
                 
                require_once "views/Base.phtml";
            }


    

}
