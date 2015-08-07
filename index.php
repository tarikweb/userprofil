<?php
require_once 'includes/db.inc.php';
include 'includes/user.inc.php';
$out = "";
if (!empty($_SESSION["user_session"])) {
    $userID = $_SESSION["user_session"];
    $out = '<div class="right bottom-aligned-text"><a href="logout.php?logout=true">Déconnexion</a></div>';
    $out .= '<div class="right"><h1>Bonjour <a href="profile.php">'.user_edit($db_connexion, $userID)['user_name']."</a></h1></div>";

}
else if(empty($_SESSION)){
    $out = '<form action="login.php" method="post" class="navbar-form navbar-right">
            <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                <input type="text" class="form-control" name="txt_uname_email" placeholder="Pseudo ou e-mail" size="15" required />
            </div>
            <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                <input type="password" class="form-control" name="txt_password" placeholder="Mot de passe" size="15" required />
            </div>
            <button type="submit" name="btn-login" class="btn btn-primary">
                <i class="glyphicon glyphicon-log-in"></i>&nbsp;Connectez vous
            </button>
            </br>
            <div class="right">
            <label>vous n\'avez pas de compte? <a href="inscription.php">Inscrivez-vous</a></label>
            </div>
        </form>';;
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
            <div class="header">
                <div class="right">
                       <?php echo $out ?>
                 </div>
            </div>
        </div>

    </body>
</html>


