<?php
require_once 'includes/db.inc.php';
include 'includes/user.inc.php';
include 'includes/category.inc.php';
include 'includes/product.inc.php';
$out = "";
if (!empty($_SESSION["user_session"])) {

    $userID = $_SESSION["user_session"];
    $out = '<div class="right bottom-aligned-text"><a href="logout.php?logout=true">Déconnexion</a></div>';
   
    $out .= '<div class="right"><h1>Bonjour <a href="profile.php">'.user_edit($db_connexion, $userID)['user_name']."</a></h1></div><br>"; 
  if(isset($_SESSION["cart"])){
  	$cart = $_SESSION["cart"];
  	foreach($cart as $c){
  		$produit = edit_product($c['id'] , $db_connexion);
      $out .= '<div >nom du produit '.$produit["nom"].' : , qty :'.$c["qty"].' 
                <a href="panier.php?action=delete&id=">Supprimer</a>
                <br/><a href="">Voir mon panier</a>
                </div>';
  	}
  }
   
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
        <title>Produit </title>
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
	 // Recupperation de l'id produit
	 $id = $_GET["id"];
	 $produit = edit_product($id,$db_connexion);
	 if(isset($_POST["btn-cart"])){ 
	 	// envoi du formulaire 
	 	if(!empty($_POST["qty"]) && is_numeric($_POST["qty"])){
	 		// Validation de qty doit etre numerique
	      if(!isset($_SESSION["cart"])) {
	      	// element de session panier vide par défaut si on a aucun produit selectioné
            $_SESSION["cart"][] = array('id' => $_POST["id_produit"],
                                       	'qty' =>  $_POST["qty"],
            	                       );
	 	    header("Location:produit.php?id=$id");
	      }
	      else{
	      	// Si on en a un on voit les produits qui y figurent
	      	$cart = $_SESSION["cart"];
            $ids = array();
            $qtys = array();
            foreach($cart as $c){
               $ids[] = $c["id"];
               $qtys[] = $c["qty"];
            }
            if(!in_array($_POST["id_produit"] , $ids)){
                $_SESSION["cart"][] = array('id' => $_POST["id_produit"], 
                	                        'qty' =>  $_POST["qty"],
                	                        );
            	}
            	else{
                $key = array_search($_POST["id_produit"] , $ids);
                $qt = $qtys[$key];
                $cart[$key]["qty"] += $_POST["qty"];
                $_SESSION["cart"] = $cart;
            	}
	 	    header("Location:produit.php?id=$id");
	      }
	 	}
	 	
	 }
	 echo "<div class='row'>
	       <div class='col-md-7'>
           <p>".$produit["nom"]."</p>
           <p>".$produit["prixht"]."</p>
           <p>".$produit["prix"]."</p>
           <p>".$produit["reference"]."</p>
           </div>
           <div class='col-md-3'>
            <form action='' method='post'>
            <div class='group-form'>
              <input type='text' name='qty'>
              <input type='hidden' name='id_produit' value='".$id."'>
            </div>
            <input type='submit' value='ajouter au pannier' name='btn-cart'>
            </form>
           </div>
	      </div>";
   }
echo "</div>"; 
?>
        </div>

    </body>
</html>


