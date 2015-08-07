<?php
require_once 'includes/db.inc.php';
include 'includes/user.inc.php';
include 'includes/category.inc.php';
$out = "";
if (!empty($_SESSION["user_session"])) {

    $userID = $_SESSION["user_session"];
    $out = '<div class="right bottom-aligned-text"><a href="logout.php?logout=true">Déconnexion</a></div>';
    $out .= '<div class="right"><h1>Bonjour <a href="profile.php">'.user_edit($db_connexion, $userID)['user_name']."</a></h1></div>";
if(isset($_SESSION["cart"])){
    $cart = $_SESSION["cart"];
    var_dump($cart);
  }
    $out .= '<br><div >nom du produit : , qty : 
                <a href="panier.php?action=delete&id=">Supprimer</a>
                <br/><a href="">Voir mon panier</a>
                </div>';

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
        </form>';
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
                <div class="left"><a href="index.php">logo</a></div>
                <div class="right">
                       <?php echo $out ?>
                 </div>
            </div>
            <?php
            $where = isset($_GET['id'])?"where id_categorie =".$_GET["id"]:" where 1";
           
    echo "<div class='col-md-3'>
          <ul>";
          try{
            $statement = $db_connexion->prepare("SELECT * FROM categorie where id_parent=:parent and niveau=:niveau;");
            $statement->execute(array(":parent" => 0 , ":niveau" => 1));
            $categories = $statement->fetchAll();
            category_children($categories , 1 , $db_connexion); // niveau de départ
          }catch(PDOException $e){
            echo $e->getMessage();
          }
          
   echo "</ul>
        </div>";

echo "<div class='col-md-9'>";

if(isset($_GET["id"])){
  $categorie = category_edit($_GET["id"], $db_connexion);
  echo "<p>".utf8_encode($categorie["nom"])."</p> "; 
}



$statement = $db_connexion->query("SELECT * FROM produit $where;");
$produits = $statement->fetchAll();

     foreach($produits as $produit){
         echo "<div >
          <p>".$produit["nom"]."</p> 
          <p>".$produit["reference"]."</p> 
          <p>".$produit["prix"]."</p> 
          <p>".$produit["prixht"]."</p> ";
         $category = category_edit($produit["id_categorie"], $db_connexion);
         echo "<p>".utf8_encode($category["nom"])."</p> 
         <p><a href='produit.php?id=".$produit["id_produit"]."'>Plus d'info</a></p>
         </div>";
     }
echo "
      ";
echo "</div>"; 
?>
        </div>

    </body>
</html>


