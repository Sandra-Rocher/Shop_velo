<?php


class Autoloader
{

    public static function Autoload()
    {
        
        //On démarre la session start pour tout le site
        session_start();
        
        // recupère un $classname et le callback
        spl_autoload_register(function ($classname) {

            // transforme \ en / (on met double // à cause de l'échappé)
            $classname = str_replace("\\", "/", $classname);

            //Si la page existe, on lui rajoute un .php
            if (file_exists($classname . ".php")) {

                //rajouter un .php a la fin de $classname, classname étant une page
                require $classname . ".php";
               // On aurait pu aussi dire :
                //require_once $classname .= ".php";

                
            } else {
                //sinon Page 404 : non trouvée
                echo "autoloader erreur 404 $classname";
                exit();
            }
        });
    }
}
