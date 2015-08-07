<?php
require_once 'includes/db.inc.php';
include 'includes/user.inc.php';
$out = "";
if (!empty($_SESSION["user_session"])) {
   $out = "Bonjour , <a href='logout.php?logout=true'> Déconnexion </a>";




}
else if(empty($_SESSION)){
    $out = '<div class="form-container">
            <form action="login.php" method="post">
             <h2>Connectez-vous.</h2>
            <div class="form-group">
            <input type="text" class="form-control" name="txt_uname_email" placeholder="Username or E mail ID" />
            
            <input type="password" class="form-control" name="txt_password" placeholder="Your Password"  />
            </div>
            <div class="form-group">
            <input type="submit" name="btn-login" class="btn btn-block btn-primary" value="Connectez vous">
            </div>
               
            <label>vous n\'avez pas de compte<a href="inscription.php">Inscrivez-vous</a></label>
            </form>
            </div>';
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


