<?php

session_start();

// Verification que l'id user soit connecté ET admin
if(!isset($_SESSION["id"]) || $_SESSION["id_role"] != '1'){
        // sinon : déconnexion du curieux
    header("Location: functions/deconnexion.php");
}

// on va afficher les post et les commentaires grace à leurs fonctions get_all_... situées dans la page get_posts
require_once 'functions/get_posts.php';

// $articles = get_all_posts();

// $comments = get_all_comms();


// a partir de là c'est nickwall 
require_once 'modele/database.php';


// on mettra apres dans functions/get_posts
function inTable($table){

    global $pdo;
    $query = $pdo->query("SELECT COUNT(id) 
                        FROM $table
                        WHERE is_valid ='0'
                        ");

    return $query->fetch();
}


$tables = [

        "Articles postés" => "articles",
        "Commentaires postés" => "comm",
    ];

    

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Admin</title>

</head>
<body>

<?php require_once 'header.php' ?>


<div class="text-center mt-5 mb-5">
     <h2>Bienvenue <?= $_SESSION["user_name"] ?>, l'admin ! </h2>
</div> 

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
        if(isset($_GET['req']))
                {
                    $req = htmlspecialchars($_GET['req']);

                    switch($req)
                    {
                        case 'del_art':
                            ?>
                            <div class="alert alert-success">
                                <strong>Succès</strong> Vous avez supprimé l'article.
                            </div>
                            <?php
                        break;

                        case 'dont_del_art':
                            ?>
                                <div class="alert alert-danger">
                                    <strong>Erreur</strong> La suppréssion de l'article n'a pas marché.
                                </div>
                            <?php
                        break;

                        case 'agr_art':
                        ?>
                            <div class="alert alert-success">
                                <strong>succès</strong> Vous avez validé l'article.
                            </div>
                        <?php
                        break;

                        case 'dont_agr_art':
                            ?>
                                <div class="alert alert-danger">
                                    <strong>Erreur</strong> La validation de l'article n'a pas marché.
                                </div>
                            <?php
                        break;

                        case 'agr_com':
                            ?>
                                <div class="alert alert-success">
                                    <strong>succès</strong> Vous avez validé votre commentaire.
                                </div>
                            <?php
                        break;
    
                        case 'dont_agr_com':
                            ?>
                                 <div class="alert alert-danger">
                                     <strong>Erreur</strong> La validation du commentaire n'a pas marché.
                                </div>
                            <?php
                         break;

                         case 'del_com':
                            ?>
                                <div class="alert alert-success">
                                    <strong>succès</strong> Vous avez supprimé votre commentaire.
                                </div>
                            <?php
                        break;
    
                        case 'dont_del_com':
                            ?>
                                 <div class="alert alert-danger">
                                     <strong>Erreur</strong> La suppression du commentaire n'a pas marché.
                                </div>
                            <?php
                         break;
                    }
                }
?>

 
    <div class="container mt-5 mb-5">        
        <div class="d-flex justify-content-around">
                
<?php
foreach($tables as $table_name => $table){
?>
            <div class="card col-sm-12 col-md-6 col-lg-3">
                <div class="card bg-info text-center">
                    <h3> <?= $table_name ?></h3>
                    <h4> <?=inTable($table)[0]; ?></h4>
                   
                </div>  
            </div>
        
<?php
}
?>

        </div>
    </div>
           


<h3 class="text-center"> Articles non lus </h3>


<div class="container">
    <div class="row">
        <table class="mt-5 mb-5">
            <thead>
                <tr class="fs-5">
                    <th>Photo </th>
                    <th>Titre </th>
                    <th>Commentaire </th>
                    <th>Actions </th>
                </tr>
            </thead>

            <tbody>
                <?php
                foreach($articles as $article){
                
                echo '
                        <tr id="Article_' . $article[0] . '">
                        
                            <td> <img src="stock_avatar/'.$article['image'].'" width="120" height="80" alt="image de l\'article"></td>
                            <td>'.substr($article["title"],0,30).'...</td>
                            <td>'.substr($article["content"],0,80) .'...</td>
                            <td>
                                
                                <a href="functions/agree_article.php?id='. $article[0].'" class="btn btn-success mb-3"><i class="bi bi-check"></i></a>
                                <a class="confirmModal btn btn-danger mb-3" href="functions/delete_article_ad.php?id='.$article[0].'" ><i class="bi bi-trash3"></i></a>
                                <a href="#idArt'.$article[0].'" data-bs-toggle="modal" data-bs-target="#idArt'.$article[0].'" class="btn btn-info modal-trigger mb-3"><i class="bi bi-eye"></i></a>

                                        <div class="modal fade" id="idArt'.$article[0].'" tabindex="-1" aria-labelledby="idArticle" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-scrollable">
                                                <div class="modal-content">
                                                
                                                    <div class="modal-header">
                                                        <p>Article posté par <strong> <p class="text-info">'.$article["user_name"].'</p></strong></p>
                                                        <p> Le '.date("d/m/Y à H:i", strtotime($article["date_articles"])).'</p>
                                                    </div>   

                                                    <div class="modal-body">
                                                        <p class="modal-title" id="idArticle"><strong> Titre et photo : </strong> '.$article["title"].' </p>
                                                         <img src="stock_avatar/'.$article['image'].'" width="450" height="400" alt="image de l\'article">
                                                         <p><strong>Description :</strong> '.$article["content"].'</p>
                                                    </div>

                                                    <div class="modal-footer">
                                                         <a href="functions/agree_article.php?id='.$article[0].'" class="btn btn-success mb-3" ><i class="bi bi-check"></i></a>
                                                         <button type="button" class="btn btn-dark mb-3" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-x"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                            </td>
                        </tr>

                ';
                }
                ?>
            </tbody>
        </table>
    </div>
 </div>



 <h3 class="text-center"> Commentaires non lus </h3>


<div class="container">
    <div class="row">
        <table class="mt-5 mb-5">
            <thead>
                <tr class="fs-5">
                    <th>Photo de l'article</th>
                    <th>Commentaire posté sur l'article</th>
                    <th>Actions </th>
                </tr>
            </thead>

            <tbody>
                <?php
                foreach($comments as $comment){

                echo '
                        <tr id="Article_' . $comment["id_articles"] . '">
                        
                            <td> <img src="stock_avatar/'. $comment['image'].'" width="120" height="80" alt="image de l\'article"></td>
                            
                            <td>'.substr($comment["comment"],0,80) .'...</td>
                            <td>
                                
                                <a href="functions/agree_comm.php?id='. $comment[0].'" class="btn btn-success mb-3"><i class="bi bi-check"></i></a>
                                <a class="confirmModal btn btn-danger mb-3" href="functions/delete_comm_ad.php?id='. $comment[0].'"><i class="bi bi-trash3"></i></a>
                                <a href="#idArt'.$comment[0].'" data-bs-toggle="modal" data-bs-target="#idArt'.$comment[0].'" class="btn btn-info modal-trigger mb-3"><i class="bi bi-eye"></i></a>

                                        <div class="modal fade" id="idArt'. $comment[0] .'" tabindex="-1" aria-labelledby="idArticle" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-scrollable">
                                                <div class="modal-content">
                                                
                                                    <div class="modal-header">
                                                        <p>Commentaire posté par <strong> <p class="text-info">'.$comment["user_name"].' </p></strong></p>
                                                        <p> Le '.date("d/m/Y à H:i", strtotime($comment["date_comm"])).' </p>
                                                    </div>   

                                                    <div class="modal-body">
                                                        <p class="modal-title" id="idArticle"> <strong> Titre et photo de l\'article concerné : </strong>'.$comment["title"].' </p>
                                                         <img src="stock_avatar/'. $comment['image'].'" width="450" height="400" alt="image de l\'article">
                                                         <p><strong>Commentaire :</strong> '.$comment["comment"].' </p>
                                                    </div>

                                                    <div class="modal-footer">
                                                         <a href="functions/agree_comm.php?id='.$comment[0].'" class="btn btn-success mb-3" ><i class="bi bi-check"></i></a>
                                                         <button type="button" class="btn btn-dark mb-3" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-x"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                            </td>
                        </tr>

                ';
                }
                ?>
            </tbody>
        </table>
    </div>
 </div>


<?php require_once 'footer.php' ?>
 
</body>
</html>