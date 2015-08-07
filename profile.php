<?php
require_once 'includes/db.inc.php';
include 'includes/user.inc.php';
// Redirection si pas connecté
if (empty($_SESSION["user_session"])) {
    header("Location:index.php");
}
// récupperation de l'identifiant de la session
$user_id = $_SESSION["user_session"];
$action = isset($_GET["action"]) ? $_GET["action"] : "";

switch ($action) {
    case 'modifier':
        if (!empty($_GET["id"])) {
            // récupperation de l'id dans l'url
            $user_id = $_GET["id"];
            $out = user_update($user_id, $db_connexion);
        }
        // fonction modification ajout de nouvelles données sur le profil
        break;
    case 'image': // fonction d'upload d'image
        if (!empty($_GET["id"])) {
            // récupperation de l'id dans l'url
            $user_id = $_GET["id"];
            $out = user_image_upload($user_id, $db_connexion);
        }
        break;
    default:
        // Récupperation de profil de l'utiisateur en cours
        try {
            $stmt = $db_connexion->prepare("SELECT * FROM users where id_user=:user");
            $stmt->bindparam(":user", $user_id);
            $stmt->execute();
            $user = $stmt->fetch();
        }
        catch (PDOException $e) {
            echo $e->getMessage();
        }
        $out = '';
        $out .= (!empty($user["user_pic"])) ? "<img src='upload/" . $user["user_pic"] . "' width='100' height='100'>" : "";
        $out .= "Votre pseudo : " . $user["user_name"] . "<br/>";
        $out .= "Votre email : " . $user["user_email"] . "<br/>";
        $out .= "Vous êtes membre depuis : " . $user["date_created"] . "<br/>";
        $out .= "Dernière connexion : " . $user["last_login"] . "<br/>";

        break;
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
                    <p>Bienvenu sur Votre profil</p>
                    <?php
                    echo $out;
                    ?>
                </div>
            </div>
        </div>

    </body>
</html>


