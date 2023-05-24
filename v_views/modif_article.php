<?php

session_start();

// page d'appel des functions
require_once 'functions/get_posts.php';

// même fonction que full article, car on veut aussi afficher l'article en grand avant de le modifier
// $article = get_full_articles();

// Verification que l'id de la personne soit bien connectée et celle qui à éditée l'article
if(!isset($_SESSION["id"]) || $_SESSION["id"] != $article['id_users']){
    
        // redirection sur l'article en full qui été sélectionné par l'id
  header('Location:full_article.php?id='.$article[0].'&rep_err=wrong_id_us');
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Modifier un article</title>
</head>
<body>


<?php require 'header.php' ?>


<?php
    if(!empty($_SESSION['id'])){
?>

<!-- Modal de confirmation de suppression d'article, script modal.js -->
<div id="dialog-confirm" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="dialog-confirm-title" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="dialog-confirm-title">Confirmation de la suppression</h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Etes-vous sûr de vouloir supprimer cet élément ?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="confirm-yes">Confirmer</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
      </div>
    </div>
  </div>
</div>


<?php
   
    
    echo     ' <div class="container mt-5 mb-5 col-sm12 col-md-8 col-lg-10 border border-info shadow-lg bg-info-rounded">
                    <div class="row text-center border border-info shadow-lg bg-info-rounded">
                        <h1 class="mt-5">Modifier un article</h1>

                                <form class="form-group mt-3" method="POST" action="functions/modif_article_form.php?&id='.$_GET['id'].'" enctype="multipart/form-data">
                                    <div class="d-grid gap-2 col-sm-12 col-md-8 col-lg-10 mx-auto mt-3">

                                        <label for="title_art" class="fs-4 mx-auto">Modifier votre titre</label>
                                        <input type="text" class="form-control" name="tit" id="title_art"  placeholder="Titre de votre article..." value="'.$article[1].'" required="required">
            
                                        <label for="comm_art" class="fs-4 mx-auto">Modifier votre commentaire</label>
                                        <textarea class="form-control" name="cont" id="comm_art" rows="8" required="required" placeholder="" >'.$article[2].'</textarea>
            

                                       <div class="row mt-3">
                                            <div class="col-6">
                                                <img src= stock_avatar/'.$article [3].' class="card-img-top w-25" alt=" '.$article [1].'">
                                            </div> 
                                            <div class="col-6 mt-auto mb-auto">
                                                <label for="image_art" class="fs-4 mx-auto">Modifier l\'image</label>
                                                <input type="file" class="form-control" name="image" id="image_art"  placeholder="" value="<?= '.$article[3].' ?>" ">
                                            </div> 
                                        </div>
                                        

                                        <div class="row">
                                            <div class="d-flex justify-content-around mx-auto mt-5 mb-4">
                                                <a href="functions/delete_article.php?&id='.$_GET['id'].'"<button class="confirmModal btn btn-info" type="submit">Supprimer entièrement l\'article</button></a>
                                                <button class="btn btn-info" type="submit">Envoyer les modifications</button>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="d-grid gap-2 mx-auto mt-4 mb-5">
                                        <div class="fs-bold"><a href="crit_valid.php">Avant de valider votre article, allez voir les critères de validation de celui-ci</a></div>
                                    </div>
                                </form>    
                                     
                    </div>
                </div> ';
                  

?>

<?php
}else{
?>
        <div class="container mt-5 mb-5 text-center">
             <div class ="fs-4 mb-3"> Vous devez être connecté pour modifier vos articles </div>
            <a href="connexion.php">Connexion</a>
        </div>

<?php
}
?>


<?php require_once 'footer.php' ?>

 </body>
</html>




