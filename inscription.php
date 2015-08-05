
<?php
require_once 'db.inc.php';
include 'user.inc.php';
if (!empty($_SESSION["user_session"])){
  header("Location:profile.php");
}
if(isset($_POST["btn-login"])){ // premiere validation : action de cliquer

	$username = $_POST["txt_uname_user"];
	$usermail = $_POST["txt_uname_email"];
	$userpass = $_POST["txt_password"];

	if(empty($username)){
		$errors[] = "veuillez fournir un pseudo";
	}else if(empty($usermail)){
		$errors[] = "veuillez fournir un mail";
	}else if(!preg_match('/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/',$usermail)){
		$errors[] = "veuillez valider votre mail";
	}else if(empty($userpass)){
		$errors[] = "veuillez fournir un mot de passe";
	}else if(strlen($userpass) < 8){
        $errors[] = "votre mot de passe doit comporter au minimum 8 caractères";
	}else{
        $sql = 'SELECT user_name , user_email FROM users where user_name=:user OR user_email=:email';
        try{
          $stmt = $db_connexion->prepare($sql);
          $stmt->execute(array(':user' =>$username , ':email' => $usermail));
          $row = $stmt->fetch();

          if($row["user_name"] == $username){
          	$errors[] = "le pseudo a déjà été pris";
          }else if ($row["user_email"] == $usermail){
            $errors[] = "L'email a déjà été renseigné";
          }else{
              if(user_register($username,$usermail,$userpass, $db_connexion)){
              	header("Location:inscription.php?succes");
              }
          }

        }catch(PDOException $e ){
             echo $e->getMessage();
        }


	}

}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Inscription</title>
<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" type="text/css"  />
<link rel="stylesheet" href="style.css" type="text/css"  />
</head>
<body>
<div class="container">
        <div class="form-container">
        <form action="inscription.php" method="post">
            <h2>Inscrivez-vous.</h2>
            <hr />
            <?php
            if(isset($errors)){
            	foreach($errors as $error){
            		?>
            		<div class="alert alert-danger"><?php echo $error ?></div>
            		<?php
            	}
            }
            else if (isset($_GET["succes"])){
                    ?>
            		<div class="alert alert-succes">
            			Inscription avec succés! <a href="index.php">Connectez-vous</a>
            		</div>
            		<?php
            }
            ?>
            <div class="form-group">
                <input type="text" class="form-control" name="txt_uname_user" placeholder="Username "  />
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="txt_uname_email" placeholder=" E mail ID"  />
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="txt_password" placeholder="Your Password"  />
            </div>
            <div class="clearfix"></div><hr />
            <div class="form-group">
                <input type="submit" name="btn-login" class="btn btn-block btn-primary" value="Inscrivez vous" >
            </div>
            <br />
            <label>Vous avez un compte<a href="index.php">connectez-vous</a></label>
        </form>
       </div>
</div>

</body>
</html>

     
