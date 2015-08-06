<?php
require_once 'db.inc.php';
include 'user.inc.php';

if (!empty($_SESSION["user_session"])) {
    header("Location:profile.php");
}

if (isset($_POST["btn-login"])) {
    $username = $_POST["txt_uname_email"];
    $usermail = $_POST["txt_uname_email"];
    $userpass = $_POST["txt_password"];
    // user_login fonction qui permet d'authentifier un utilisateur
    if (user_login($username, $usermail, $userpass, $db_connexion)) {
        header("location:profile.php");
    }
    else {
        echo "erreur de connexion";
    }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Connexion</title>
        <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" type="text/css"  />
        <link rel="stylesheet" href="style.css" type="text/css"  />
    </head>
    <body>
        <div class="container">
            <div class="form-container">

                <div class="row" style="">
                    <div class="row" style="">
                        <form action="index.php" method="post">
                            <h2>Connectez-vous.</h2><hr />
                            <?php
                            ?>
                            <div class="form-group">
                                <input type="text" class="form-control" name="txt_uname_email" placeholder="Username or E mail ID" />
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" name="txt_password" placeholder="Your Password"  />
                            </div>
                            <div class="clearfix"></div><hr />
                            <div class="form-group">
                                <input type="submit" name="btn-login" class="btn btn-block btn-primary" value="Connectez vous">
                            </div>
                            <br />
                            <label>vous n'avez pas de compte<a href="inscription.php">Inscrivez-vous</a></label>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </body>
</html>


