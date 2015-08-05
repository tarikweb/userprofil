<?php
require_once 'db.inc.php';
include 'user.inc.php';

if (empty($_SESSION["user_session"])){
    header("Location:index.php");
}

$user_id = $_SESSION["user_session"];
$action = isset($_GET["action"])?$_GET["action"]:"";
if (!empty($_GET["id"])){
switch ($action){
    case 'modifier':
    user_update($user_id, $db_connexion); // fonction modification / ajoute de nouvelles données sur le profil
    break;
    case 'image': // fonction d'upload d'image
    user_image_upload($user_id, $db_connexion);
    break;
    default:
    // Récupperation de profil de l'utiisateur en cours
    try{
      $stmt = $db_connexion->prepare("SELECT * FROM users where id_user=:user");
      $stmt->bindparam(":user", $user_id);
      $stmt->execute();
      $user = $stmt->fetch();

    }catch(PDOException $e){
       echo $e->getMessage();
    }
    break;
  }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Bienvenu à la page sécurisée <?php print $user["user_name"] ?></title>
<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" type="text/css"  />
<link rel="stylesheet" href="style.css" type="text/css"  />
</head>
<body>
<div class="container">
    <div class="header">
      <div class="right"><a href="logout.php?logout=true"> Déconnexion </a></div>
    </div>
    <div class="row">
    	<div class="col-md-3">
    		<ul>
    			<li><a href="profile.php?action=modifier&id=<?php echo $user_id ?>">Compléter votre profil</a></li>
    			<li><a href="profile.php?action=image&id=<?php echo $user_id ?>">Télécharger une image</a></li>

    		</ul>
    	</div>
    	<div class="col-md-9">
            <?php


            ?>

        <p>Bienvenu sur Votre profil</p>
        <?php 
         echo "Votre pseudo : ".$user["user_name"]."<br/>";
         echo "Votre email : ".$user["user_email"]."<br/>";
         echo "Vous êtes membre depuis : ".$user["date_created"]."<br/>";
         echo "Dernière connexion : ".$user["last_login"]."<br/>"	;

        ?>
    	</div>
    </div>
</div>

</body>
</html>

     
