<?php

namespace config;

use controllers\AdminController;


class Routing
{

    public function get()
    {

        //vérifie si il y a dans qchose dans ctrl en get dans l'url
        if (isset($_GET['ctrl'])) {


            //sécurise les données et la place dans la variable $url
            $url = htmlspecialchars($_GET["ctrl"]);

            // explode va analyser ce qu'il y a entre chaque / dans l $url qui est l url et stock dans $newUrl
            $newUrl = explode("/", $url);

            // en faisant ça, je tape dans mon url des mots entre / et il me les montre en arrayy
            // par exemple : localhost/velo/admin/users/1 = arrayy [0]= stringg admin, [1]= stringg users etc en var_dump($newUrl);

            // ucfirst va passer la premiere lettre en majuscule, donc j obtiendrai AdminController si je tape 
            // localhost/velo/admin/users, il prendra admin, qui est le [0] grace a explode, et lui ajoutera .Controller au bout.
            $controllerName = "controllers\\" . ucfirst($newUrl[0]) . "Controller";
            // en résumé : il va dans le dossier controllers, trouver AdminControllers.php (.php grâce à l'autoload)


            // on a défini avant controllerName et methodName donc s'il les trouve dans velo/admin/index c'est ok, le else error 404
            // apparaitra si on fait velo/admin/index
            if (isset($newUrl[1])) {

                // maintenant tu met en minuscule index qui est dans le [1]
                $methodName = strtolower($newUrl[1]);

                // nouveau controllername, instanciation
                $controller = new $controllerName();

                 // $controller->$methodName();
                // var_dump($controller);

                // Si il y a 3 arguments dans l url :
                if (isset($newUrl[2])) {

                    //J'explode entre les ; et je stock dans les $arg
                    $newUrlExploded = explode(";", $newUrl[2]);
                    if (count($newUrlExploded) == 3){
                        $arg1 = $newUrlExploded[0];
                        $arg2 = $newUrlExploded[1];
                        $arg3 = $newUrlExploded[2];

                        //On déclenche le controller + fonction avec les 3 arguments ( ils sont attendus)
                        $controller->$methodName($arg1, $arg2, $arg3);

                    //J'explode entre les ; et je stock dans les $arg
                    } else if (count($newUrlExploded) == 6){
                        $arg1 = $newUrlExploded[0];
                        $arg2 = $newUrlExploded[1];
                        $arg3 = $newUrlExploded[2];
                        $arg4 = $newUrlExploded[3];
                        $arg5 = $newUrlExploded[4]; 
                        $arg6 = $newUrlExploded[5];

                        //On déclenche le controller + fonction avec les 6 arguments (ils sont attendus)
                        $controller->$methodName($arg1, $arg2, $arg3, $arg4, $arg5, $arg6);

                    //Si il n'y a qu'un argument dans l url
                    } else if  (count($newUrlExploded) == 1)  {

                        //On place le 3 eme argument dans $id
                        $id = $newUrl[2];
                        //Controller concerné déclenche la fonction qui est à l'intérieur (avec l'$id)
                        $controller->$methodName($id);
                    }
                
                } else {
                    //Controller concerné déclenche la fonction qui est à l'intérieur
                    $controller->$methodName();
                }

                // au final on a taper la meme chose que dans le else (car on avait que index a afficher après tout)
                // on a donc la méthode simple et facile else (en dessous) qui dit va chercher la page admincontroller 
                // et declenche la fonction index

                // et on a le if (au dessus) ou l'on réecrit mot par mot lettre par lettre la meme chose..
                // on va chercher le dossier controller // se transforme en / et l url newUrl[0] c'est le mot admin, je le transform
                // en Admin avec ucfirst, et je lui rajoute .Controller donc .php

                // ensuite je fais strtolower de newurl[1] donc index se met en minuscule

                // donc newcontrollername = new AdminController
                // et controller->methodName = ->index

            } else {
                //sinon error 404 
                echo "error 404 ctrl " .$_GET["ctrl"];
            }
        } else {
            //sinon dirige quoi qu'il arrive vers l'accueil (connexion)
            $admin = new AdminController();
            $admin->index();
        }
    }
}
