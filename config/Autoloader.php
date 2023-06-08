<?php


class Autoloader
{

    public static function Autoload()
    {
        
        session_start();
        
        // il va attraper un $classname et le callback
        spl_autoload_register(function ($classname) {

            // pour attraper l antislash il faut en mettre deux, car le premier echappera les guillemets qui perturbe la ligne suivante
            $classname = str_replace("\\", "/", $classname);

            //Si la page existe, on lui rajoute un .php
            if (file_exists($classname . ".php")) {

                // je lui dit de rajouter un .php a la fin de $classname, classname c'est une page
                require $classname . ".php";
               // On aurait pu aussi dire :
            //    require_once $classname .= ".php";

                
            } else {
                //Page 404 : non trouvée
                echo "autoloader erreur 404 $classname";
                exit();
            }
        });
    }
}
