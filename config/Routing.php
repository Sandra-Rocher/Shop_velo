<?php


namespace config;

// va dans le dossier controllers chercher admincontroller
use controllers\AdminController;
// use controllers\ClientController;


class Routing
{


    public function get()
    {

        // si il y a ctrl dans l'url : je fais 
        if (isset($_GET['ctrl'])) {


// if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_x_REQUESTED_WITH']) == 'xmlhttprequest') {
// echo 'zoub';
// die();
// }




            // comme on get dans l url ce qu'il y a apres ctrl, on htmlspecialchars 
            $url = htmlspecialchars($_GET["ctrl"]);

            // explode va analyser ce qu'il y a apres le / dans l $url qui est l url
            $newUrl = explode("/", $url);

            // en faisant ça, je tape dans mon url des mots entre / et il me les montre en arrayy
            // par exemple : localhost/shop/admin/users/1 = arrayy [0]= stringg admin, [1]= stringg users
            // var_dump($newUrl);

            // ucfirst va passer la premiere lettre en majuscule, donc j obtiendrai AdminController si je tape 
            // localhost/shop/admin/users, il prendra admin, qui est le [0] grace a explode, et lui ajoutera .Controller au bout.
            $controllerName = "controllers\\" . ucfirst($newUrl[0]) . "Controller";
            // en gros on a retapé va dans le dossier controllers, et chope AdminControllers.php




            // on a défini avant controllerName et methodName donc s'il les trouve dans shop/admin/index c'est ok, le else error 404
            // apparaitra si on fait shop/admin/index
            if (isset($newUrl[1])) {


                $methodName = strtolower($newUrl[1]);
                // maintenant tu met en minuscule index qui est dans le [1]


                // nouveau controllername
                $controller = new $controllerName();

                 // $controller->$methodName();
                // var_dump($controller);


                if (isset($newUrl[2])) {

                    $newUrlExploded = explode(";", $newUrl[2]);
                    if (count($newUrlExploded) == 3){
                        $arg1 = $newUrlExploded[0];
                        $arg2 = $newUrlExploded[1];
                        $arg3 = $newUrlExploded[2];

                        $controller->$methodName($arg1, $arg2, $arg3);

                    } else if (count($newUrlExploded) == 6){
                        $arg1 = $newUrlExploded[0];
                        $arg2 = $newUrlExploded[1];
                        $arg3 = $newUrlExploded[2];
                        $arg4 = $newUrlExploded[3];
                        $arg5 = $newUrlExploded[4]; 
                        $arg6 = $newUrlExploded[5];

                        $controller->$methodName($arg1, $arg2, $arg3, $arg4, $arg5, $arg6);


                    } else if  (count($newUrlExploded) == 1)  {

                        $id = $newUrl[2];
                        
                        $controller->$methodName($id);
                    }
                
                } else {
                    $controller->$methodName();
                }

                // au final on a taper la meme chose que dans le else (car on avait que index a afficher après tout)
                // on a donc la méthode simple et facile else (en dessous) qui dit va chercher la page admincontroller 
                // et declenche la fonction index

                // et on a le if (au dessus) ou l'on réecrit mot par mot lettre par lettre la meme chose !!!!
                // on va chercher le dossier controller // se transforme en / et l url newUrl[0] c'est le mot admin, je le transform
                // en Admin avec ucfirst, et je lui rajoute .Controller donc .phppp

                // ensuite je fais strtolower de newurl[1] donc index se met en minuscule

                // donc newcontrollername = new AdminController
                // et controller->methodName = ->index

            } else {
                echo "error 404 ctrl " .$_GET["ctrl"];
            }
        } else {
            // sinon : je dirige vers l accueil normal puisque l url affiche lcoalhost shop/ vide. On affichera donc la 
            // view de la page index admin, pour ça je lui dis va voir dans la class admin controller, et declenche la function index
            $admin = new AdminController();
            $admin->index();
        }
    }
}
