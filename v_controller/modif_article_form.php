<?php

session_start();


// connexion avec la database
require_once '../modele/database.php';



// Vérifier qu'on prends bien l'id de l'article qu'on veut modifier
if (isset($_GET['id']) && !empty($_GET['id'])) {

    $get_id = htmlspecialchars($_GET['id']);
} else {
    // CREER sur la page l erreur... et indenter tout ça !!
    header('Location:../modif_article.php?reg_err=error_no_art_id');
}



// si la session n'est pas vide
if (!empty($_SESSION['id'])) {

    // on recupere la session
    $my_session = $_SESSION['id'];

    // ici nous modifions un article déjà validé par l'admin et visible du public. (donc is_valid = 1). Pour ne pas que la
    //  personne en profite pour écrire n'importe quoi, il faudra que l'admin le re-vérifie : donc on passe is_valid à 0 comme 
    //  lorsqu'on créer un article du départ. Si il réponds de nouveau aux critères, l'admin repassera is_valid à 1 et l'article
    //   sera de nouveau publié.
    $is_valid = 0;

    // si le title n'est pas vide
    if (!empty($_POST['tit'])) {
        // on passe le title en htmlspecialchars
        $tit = htmlspecialchars($_POST['tit']);

        // si le content n'est pas vide
        if (!empty($_POST['cont'])) {
            // on passe le content en htmlspecialchars
            $cont = htmlspecialchars($_POST['cont']);


            if (isset($_FILES['image'])) {

                // si il y a une image avec son nom 
                if (!empty($_FILES['image']['name'])) {

                    // on récupere les infos de l'image
                    $name_file = $_FILES['image']['name'];
                    $type_file = $_FILES['image']['type'];
                    $size_file = $_FILES['image']['size'];
                    $tmp_file = $_FILES['image']['tmp_name'];
                    $err_file = $_FILES['image']['error'];

                    // on déclare les extensions autorisées
                    $authorised_extensions = ['png', 'jpg', 'jpeg', 'gif'];
                    $type = ['image/png', 'image/jpg', 'image/jpeg', 'image/gif'];

                    // on sépare le nom de l'image a partir du .
                    $extens = explode('.', $name_file);

                    // on déclare une taille maxi en octets
                    $max_size = 300000;

                    // on compare dans le tableau si le type file correspond au type
                    if (in_array($type_file, $type)) {
                        // on compte le nombre d'extension apres le ., on passe l'extension en minuscule
                        if (count($extens) <= 2 && in_array(strtolower(end($extens)), $authorised_extensions)) {

                            // on compare si l'img est de taille inférieur au max_size déclaré plus haut, et si elle est en erreur 0 (dans manuel php : téléchargement correct)
                            if ($size_file < $max_size && $err_file == 0) {

                                // on creer un numéro unique, que l'on recole l'extension précédément explode puis on l'envois vers le fichier stock_avatar une fois renommé en uniqid.
                                $image = uniqid() . '.' . strtolower(end($extens));
                                if (move_uploaded_file($tmp_file, '../stock_avatar/' . $image)) {

                                    // on prepare et execute la requete, dans la table articles, on rentre le titre, le content, et l'image de l'article crée
                                    $insert = $pdo->prepare('UPDATE articles 
                                                             SET title = ?, content = ?, image = ?, is_valid = ?
                                                             WHERE id = ?');

                                    $insert->execute([$tit, $cont, $image, $is_valid, $get_id]);

                                    //  Si on a rencontré une erreur, on la nomme ci dessous celon a quel endroit elle à eu lieu
                                    // echo "Article reçu, il sera vérifié par l'admin et publié ou supprimé !";
                                    header('Location:../other_articles.php?&reg_err=success_upd');
                                    die();


                                    // echo "Erreur, upload non effectué";
                                } else {
                                    header('Location:../other_articles.php?&reg_err=error_upd');
                                }


                                // echo "Image trop lourde ou format incorrect";
                            } else {
                                header('Location:../other_articles.php?&reg_err=type_file');
                            }


                            // echo "Merci de mettre une image";
                        } else {
                            header('Location:../other_articles.php?&reg_err=image');
                        }


                        // echo "Type non autorisé. Veuillez choisir une image.png ou .jpg ou .jpeg ou .gif";
                    } else {
                        header('Location:../other_articles.php?&reg_err=type');
                    }
                } // on prepare et execute la requete, dans la table articles, on rentre le titre, le content, et l'image de l'article crée
                $insert = $pdo->prepare('UPDATE articles 
                                         SET title = ?, content = ?, is_valid = ?
                                         WHERE id = ?');

                $insert->execute([$tit, $cont, $is_valid, $get_id]);

                //  Si on a rencontré une erreur, on la nomme ci dessous celon a quel endroit elle à eu lieu
                // echo "Article reçu, il sera vérifié par l'admin et publié ou supprimé !";
                header('Location:../other_articles.php?&reg_err=success_upd');
                die();
            }

            // echo "Veuillez mettre une description, ou un commentaire à votre article";
        } else {
            header('Location:../other_articles.php?&reg_err=cont_empty');
        }


        // echo "Veuillez remplir le titre de l'article" ;
    } else {
        header('Location:../other_articles.php?&reg_err=tit_empty');
    }


    // echo "Erreur d'id";
} else {
    header('Location:../other_articles.php?&reg_err=error_id');
}
