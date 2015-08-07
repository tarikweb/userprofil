<?php

include 'util.inc.php'; // Nouveau fichier utilitaire diverses fonctions de traitement

// fonction inscription utilisateur
function user_register($username, $usermail, $userpass, $db_connexion) {
    try {
        $newpass = md5($userpass); // fonction de cryptage de mot de passe MD5
        $stmt = $db_connexion->prepare("INSERT INTO users(user_name, user_email, user_pass, date_created)
    	                              VALUES(:uname, :umail, :upass ,:date_created );");
        $stmt->bindparam(':uname', $username);
        $stmt->bindparam(':umail', $usermail);
        $stmt->bindparam(':upass', $newpass);
        $stmt->bindparam(':date_created', date("Y-m-d h:i:s"));
        $stmt->execute(); //execution de la requete
        return $stmt; // false si pas d'insertion , true sinon
    }
    catch (PDOException $e) {
        echo $e->getMessage();
    }
}

// fonction de connexion utilisateur

function user_login($username, $usermail, $userpass, $db_connexion) {
    try {
        $sql = 'SELECT * FROM users where user_name=:uname OR user_email=:umail';
        $stmt = $db_connexion->prepare($sql);
        $stmt->execute(array(':uname' => $username, ':umail' => $usermail));
        $userRow = $stmt->fetch(); //L récuperation de l'utilisateur de la table users

        if ($stmt->rowCount() > 0) {
            if ($userRow["user_pass"] == md5($userpass)) {
                $_SESSION["user_session"] = $userRow["id_user"];
                return true;
            }
            else {
                return false;
            }
        }
    }
    catch (PDOException $e) {
        echo $e->getMessage();
    }
}

// fonction de déconnexion de l'utilisateur
function user_logout($db_connexion) {
    try {
        // mise à jour de la dernière date de connexion
        $sql = "UPDATE users SET `last_login`='" . date("Y-m-d H:i:s") . "'  WHERE `id_user`=" . $_SESSION["user_session"];
        $db_connexion->query($sql);
        $db_connexion->exec();
        // destruction de la session
        session_destroy();
        unset($_SESSION["user_session"]);
        return true;
    }
    catch (PDOException $e) {
        echo $e->getMessage();
    }
}

// fonction de modification de l'utilisateur
function user_update($user_id, $db_connexion) {

    // Récuperation de profil
    $sql = 'SELECT * FROM users where id_user=:user';
    $stmt = $db_connexion->prepare($sql);
    $stmt->execute(array(":user" => $user_id));
    $row_user = $stmt->fetch();

    // Validation de post
    if (isset($_POST["btn-update"])) {
        $err = '';
        $success = '';
        // Validation des infos supplémentaires de l'utilisateur
        if (empty($_POST["user_firstname"])) {
            $errors[] = "Veuillez renseigner votre prénom";
        }
        else if (empty($_POST["user_lastname"])) {
            $errors[] = "Veuillez renseigner votre nom";
        }
        else if (empty($_POST["user_adress"])) {
            $errors[] = "Veuillez renseigner votre adresse";
        }
        else if (empty($_POST["user_zipcode"])) {
            $errors[] = "Veuillez renseigner votre code postal";
            // expression régulière verifie tous les code postaux insee
        }
        else if (!preg_match("#^[0-9]{5}$|^2([Aa]|[Bb])+[0-9]{3}$#", $_POST["user_zipcode"])) {
            $errors[] = "Veuillez renseigner un code postal valide";
        }
        else {
            try {
                // Traitement de modification de l'utilisateur (dans cette exemple de complétion)
                if (!empty($_POST["user_pass"]) && strlen($_POST["user_pass"]) >= 8) {
                    // cas ou l'utilisateur décide de modifier son mot de passe
                    $sql = "UPDATE users SET `user_pass`=:password , `user_firstname`=:firstname , `user_lastname`=:lastname, `user_adress`=:adress, `user_zipcode`= :zipcode, `date_updated` = :date_updated WHERE id_user=:user";
                    $datas = array(':firstname' => $_POST['user_firstname'],
                        ':lastname' => $_POST['user_lastname'],
                        ':zipcode' => $_POST['user_zipcode'],
                        ':adress' => $_POST['user_adress'],
                        ':user' => $user_id,
                        ':password' => md5($_POST["user_pass"]),
                        ':date_updated' => date('Y-m-d h:i:s'),
                    );
                }
                else if (strlen($_POST["user_pass"] < 8)) {
                    // message d'erreur si l'utilisateur spécifie un  mot de passe moins de 8 caractère
                    $errors[] = "Votre mot de passe doit comporter 8 carctères";
                }
                else {
                    $sql = "UPDATE users SET `user_firstname`=:firstname , `user_lastname`=:lastname, `user_adress`=:adress, `user_zipcode`= :zipcode, `date_updated` = :date_updated WHERE id_user=:user";
                    $datas = array(':firstname' => $_POST['user_firstname'],
                        ':lastname' => $_POST['user_lastname'],
                        ':zipcode' => $_POST['user_zipcode'],
                        ':adress' => $_POST['user_adress'],
                        ':user' => $user_id,
                        ':date_updated' => date('Y-m-d h:i:s'),
                    );
                }


                $stmt = $db_connexion->prepare($sql);
                $stmt->execute($datas);
                $success = "Modification réussie";
            }
            catch (PDOException $e) {
                echo $e->getMessage();
            }
        }
    }
    //formatage des erreurs
    if (isset($errors)) {
        foreach ($errors as $error) {
            $err .= $error . '<br/>';
        }
    }

    $form = (isset($success) ? $success : "")
            . $err
            . '<form action="?action=modifier&id=' . $user_id . '" method="post">
            <div class="form-group">
                <input type="text" class="form-control" name="user_name" placeholder="Username " value="' . $row_user['user_name'] . '"
                disabled="disabled" />
            </div>
             <div class="form-group">
                <input type="text" class="form-control" name="user_mail" placeholder="Usermail " value="' . $row_user['user_email'] . '" disabled="disabled" />
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="user_pass" placeholder="Password "   />
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="user_firstname" placeholder="Firstname"   />
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="user_lastname" placeholder="Lastname"   />
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="user_adress" placeholder="Adress"   />
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="user_zipcode" placeholder="Zip code"   />
            </div>
            <div class="form-group">
                <input type="submit" name="btn-update" class="btn btn-block btn-primary" value="Modifier" >
            </div>
           </form>';

    return $form;
}

// fonction d'ajout d'un utilisateur
function user_image_upload($user_id, $db_connexion) {
    if (isset($_FILES["avatar"])) { // la première entrée au téléchargement
        $dossier = "upload/";
        $fichier_tmp = $_FILES["avatar"]["tmp_name"];
        $fichier = $_FILES["avatar"]["name"];
        $extension = strrchr($fichier, '.'); // extension de fichier téléchargé
        $extensions = array('.jpg', '.png', '.gif', '.jpeg'); // extensions possibles de fichier à télécharger
        if (in_array($extension, $extensions)) {
            if (move_uploaded_file($fichier_tmp, $dossier . $user_id . "_avatar" . $extension)) {
                try {
                    $newfichier = $user_id . "_avatar" . $extension;
                    resize_image($newfichier, $extension);
                    // SQL ajout de l'image dans le profil user ......
                    $sql = "UPDATE users SET `user_pic`=:pic WHERE id_user =:user";
                    $stmt = $db_connexion->prepare($sql);
                    $stmt->execute(array(':pic' => $user_id . "_avatar" . $extension,
                        ':user' => $user_id
                    ));
                    $success = "téléchargement réussi de " . $fichier . " dans le répertoire upload/";
                }
                catch (PDOException $e) {
                    echo $e->getMessage();
                }
            }
            else {
                $errors[] = "echec du téléchargement";
            }
        }
        else {
            $errors[] = "Vous devez télécharger un fichier de format image : gif , png , jpeg";
        }
    }
    // formulaire de Téléchrgement d'avatar
    $form = '<form action="profile.php?action=image&id=' . $user_id . '" method="POST" enctype="multipart/form-data">
             <input type="file" name="avatar">
             <input type="hidden" name="MAX_FILE_SIZE" value="100000">
             <input type="submit" name="submit">
           </form>';
    return $form;
}

function user_edit($db_connexion, $userID){
  try {
    $sql = 'SELECT * FROM users where id_user=:user';
    $statement = $db_connexion->prepare($sql);
    $statement->execute(array(':user'=>$userID));
    $userRow = $statement->fetch();
    return $userRow;
  } catch (Exception $e) {
    echo $e->getMessage();
  }
}
