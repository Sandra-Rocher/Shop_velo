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


            if (file_exists($classname . ".php")) {

                // je lui dit de rajouter un .php a la fin de $classname, classname c'est une page
                require $classname . ".php";
                
            } else {
                echo "autoloader erreur 404 $classname";
                exit();
            }
        });
    }
}
