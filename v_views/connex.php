<?php

session_start();

?>


<!DOCTYPE html>
<html lang="en">
<head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Connexion</title>
</head>
<body>

<!-- lien header navbar -->
 <?php require_once 'header.php' ?>

 <!-- Si la personne est déja connecté on ne lui affiche pas la connexion. Il faudra qu'elle se déconnecte (ce qu'on lui propose plus bas) -->
 <?php
    if(empty($_SESSION['id'])){
?>

<div class="container d-flex align-items-center" style="height: 550px;">
    <div class="container col-sm-12 col-md-8 col-lg-3 border border-info shadow-lg mb-5 mt-5">
        <div class="row shadow-lg bg-info-rounded">
            <div class="text-center mt-4">
                    <h2 class="text-center">Connexion</h2>
                    <form class="form-group" method="POST" action="functions/connex_form.php">
                         <div class="d-grid gap-2 mx-auto mt-4">


<?php 
        if(isset($_GET['login_err']))
        {
                    $err = htmlspecialchars($_GET['login_err']);

                    switch($err)
                    {

                        case 'wrong_password':
                        ?>
                            <div class="alert alert-danger">
                                <strong>Erreur</strong> Mot de passe incorrect
                            </div>
                        <?php
                        break;

                        case 'no_exist':
                        ?>
                            <div class="alert alert-danger">
                                <strong>Erreur</strong> Compte non existant
                            </div>
                        <?php
                        break;

                        case 'empty':
                        ?>
                             <div class="alert alert-danger">
                                 <strong>Erreur</strong> Veuillez remplir les champs
                             </div>
                        <?php
                        break;

                        case 'fatalError':
                            ?>
                                 <div class="alert alert-danger">
                                     <strong>Erreur</strong> Fatal ERROR
                                 </div>
                            <?php
                        break;


                    }
        }
?> 
            
 
                            <input type="nom" name="nom" class="form-control text-center" placeholder="Nom" required="required" autocomplete="off">
                            <input type="password" name="password" class="form-control text-center" placeholder="Mot de passe" required="required" autocomplete="off">
                        
                        </div>
                        <div class="d-grid gap-2 col-6 mx-auto mt-4">
                            <button tpe="submit" class="btn btn-info">Connexion</button>
                        </div>
                    </form>
                            
                    
            </div>
        </div>
    </div>
</div>

<?php
}else{
?>
        <div class="container mt-5 mb-5 text-center">
             <div class ="fs-4 mb-3"> Vous êtes déja connecté en tant que <?= $_SESSION["user_name"] ?></div>
            <a href="functions/deconnexion.php">Déconnexion</a>
        </div>

<?php
}
?>


<!-- lien footer -->
<?php require_once 'footer.php' ?>

</body>
</html>