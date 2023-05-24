<?php

session_start();

?>


<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>New client</title>
</head>
<body>


<?php require_once 'header.php' ?>


     <div class="container col-sm-12 col-md-8 col-lg-3 border border-info shadow-lg mb-5 mt-5">
        <div class="row shadow-lg bg-info-rounded">
             <div class="text-center mt-4">
                 <h2 class="text-center">Nouveau client</h2>
                    <form class="form-group" method="POST" action="functions/new_client_form.php">
                        <div class="d-grid gap-2 mx-auto mt-4">


                        <input type="text" name="nom" class="form-control text-center" placeholder="Nom" required="required" autocomplete="off">
                        <input type="text" name="prenom" class="form-control text-center" placeholder="Prenom" required="required" autocomplete="off">
                        <input type="text" name="adresse1" class="form-control text-center" placeholder="Votre adresse" required="required" autocomplete="off">
                        <input type="text" name="adresse2" class="form-control text-center" placeholder="Complément d'adresse" required="required" autocomplete="off">
                        <input type="text" name="code_postal" class="form-control text-center" placeholder="Code postal" required="required" autocomplete="off">
                        <input type="text" name="ville" class="form-control text-center" placeholder="Ville" required="required" autocomplete="off">
                        <input type="email" name="email" class="form-control text-center" placeholder="Email" required="required" autocomplete="off">
                        <input type="text" name="telephone" class="form-control text-center" placeholder="Votre numéro de téléphone" required="required" autocomplete="off">
                        
                        
                        </div>
                        <div class="d-grid gap-2 col-6 mx-auto mt-4">
                            <button type="submit" class="btn btn-info">Valider</button>
                        </div>
                    </form>
                       
                    
            </div>
        </div>
    </div>

<!-- lien footer -->
<?php require_once 'footer.php' ?>

</body>
</html>