<?php

// Voici ma premiere page, j arrive sur index bien sur, et c est par là qu'on redirige avec le routing

//utilise l autoloader
require_once "config/Autoloader.php";

// j'ai besoin de cette function, je vais require les fichiers a chaque fois je dirige, redirige, j appel
Autoloader::Autoload();

//utilise le routing
use config\Routing;

// on creer une variable, et on declenche routing, puis on lui déclenche la fonction get
$route = new Routing();
$route->get();