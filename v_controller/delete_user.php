<?php

// démarrage de la session
session_start();

// on récupère l'id de l'user concerné
$id = $_SESSION['id'];

// connexion avec la database
require_once '../modele/database.php';

// on supprime dans la table
$delete = $pdo->prepare("DELETE FROM users WHERE id = ?");
$delete->execute([$id]);

// la session est détruite
session_destroy();
// on redirige
header('Location:../index.php?&success=supp_id_user');
die();
