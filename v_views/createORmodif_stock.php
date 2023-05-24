<?php

session_start();

// Verification que l'id connecté soit connecté ET boss
if(!isset($_SESSION["id"]) || $_SESSION["id_role"] != 'boss'){
        // sinon : 
    echo "Vous n'êtes pas le boss";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Creer ou Modifier du stock</title>
</head>
<body>


<?php require_once 'header.php' ?>


     <div class="container col-sm-12 col-md-8 col-lg-3 border border-info shadow-lg mb-5 mt-5">
        <div class="row shadow-lg bg-info-rounded">
             <div class="text-center mt-4">
                 <h2 class="text-center">Creer du stock</h2>
                    <form class="form-group" method="POST" action="functions/create_stock_form.php">
                        <div class="d-grid gap-2 mx-auto mt-4">


                        <input type="text" name="designation" class="form-control text-center" placeholder="Dénomination de l'article" required="required" autocomplete="off">
                        <input type="text" name="reference" class="form-control text-center" placeholder="Ref en 2 lettres" required="required" autocomplete="off">
                        <input type="text" name="price_ht" class="form-control text-center" placeholder="Prix HT" required="required" autocomplete="off">
                        <input type="text" name="stock" class="form-control text-center" placeholder="Stock" required="required" autocomplete="off">
                        <input type="text" name="alerte" class="form-control text-center" placeholder="Stock_alerte" required="required" autocomplete="off">
                        <input type="text" name="id_tva" class="form-control text-center" placeholder="TVA appliqué" required="required" autocomplete="off">
                        
                        </div>
                        <div class="d-grid gap-2 col-6 mx-auto mt-4">
                            <button type="submit" class="btn btn-info">Valider</button>
                        </div>
                    </form>
                       
            </div>
        </div>
    </div>


    <div class="container col-sm-12 col-md-8 col-lg-3 border border-info shadow-lg mb-5 mt-5">
        <div class="row shadow-lg bg-info-rounded">
             <div class="text-center mt-4">
                 <h2 class="text-center">Modifier le stock</h2>
                    <form class="form-group" method="POST" action="functions/modif_stock_form.php">
                        <div class="d-grid gap-2 mx-auto mt-4">


                        <select class="form-select" name="produit" aria-label="select_produit">
                            <option selected>Sélectionner l'article</option>
                            <option value="1">Selle doussofess ref SD 55€ HT</option>
                            <option value="2">Selle duracuir ref SC 40€ HT</option>
                            <option value="3">Kit eclairage voitclair ref VC 65,50€ HT</option>
                            <option value="4">Guidon korn2vach ref GT 35,40€ HT</option>
                            <option value="5">Kit dépannage MacGyver ref MG 28€ HT</option>
                        </select>

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