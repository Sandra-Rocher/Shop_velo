<?php
    session_start();

    require_once '../modele/datab.php';


if(isset($_POST['nom']) && isset($_POST['password']))
{
    $nom = htmlspecialchars(trim($_POST['nom']));
    $password = htmlspecialchars(trim($_POST['password']));

    if(!empty($nom) && !empty($password)){

        $nom = strtolower($nom);

        $check = $pdo->prepare('SELECT nom, id, id_role, id_password FROM personnel WHERE nom = ?');
        $check->execute(array($nom));
        $data = $check->fetch();
        $row = $check->rowCount();

        if($row > 0)
        {
            
                if(password_verify($password, $data['id_password']))
                {
                    $_SESSION['nom'] = $data['nom'];
                    $_SESSION['id'] = $data['id'];
                    $_SESSION['id_role'] = $data['id_role'];
                        // verifier si l'utilisateur connecter est un admin ou user

                        if($data['id_role'] == '1')
                        {
                            header('Location: ../vente.php');

                        }else if($data['id_role'] == '2')
                        {
                            header('Location: ../vente.php');

                        } else { header('Location: ../connex.php?&login_err=fatalError'); die(); }
                        
                }else{ header('Location:../connex.php?&login_err=wrong_password'); die(); }

           

        } else{ header('Location:../connex.php?&login_err=no_exist'); die(); }

    } else{ header('Location:../connex.php?&login_err=empty'); die(); }

} else{ header('Location:../connex.php'); die(); }
