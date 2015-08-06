<?php 
// fonction inscription utilisateur
function user_register($username,$usermail,$userpass, $db_connexion){
	try{
    $newpass = md5($userpass); // fonction de cryptage de mot de passe MD5
    $stmt = $db_connexion->prepare("INSERT INTO users(user_name, user_email, user_pass, date_created)
    	                            VALUES(:uname, :umail, :upass ,:date_created );");
    $stmt->bindparam(':uname', $username);
    $stmt->bindparam(':umail', $usermail);
    $stmt->bindparam(':upass', $newpass);
    $stmt->bindparam(':date_created', date("Y-m-d h:i:s"));
    $stmt->execute(); //execution de la requete 
     return $stmt; // false si pas d'insertion , true sinon
	 }catch(PDOException $e ){
             echo $e->getMessage();
     }

}

// fonction de connexion utilisateur

function user_login($username,$usermail,$userpass, $db_connexion){
	try{
      $sql = 'SELECT * FROM users where user_name=:uname OR user_email=:umail';
      $stmt = $db_connexion->prepare($sql);
      $stmt->execute(array(':uname' => $username , ':umail' => $usermail  ));
      $userRow = $stmt->fetch();//L récuperation de l'utilisateur de la table users

      if($stmt->rowCount()> 0){
      	if ($userRow["user_pass"] == md5($userpass)){
           $_SESSION["user_session"] = $userRow["id_user"];
           return true;
      	}else {
      		return false;
      	}
      }

	}catch(PDOException $e){
     echo $e->getMessage();
	}

}

// fonction de déconnexion de l'utilisateur
function user_logout($db_connexion){
	try{
      $sql = "UPDATE users SET `last_login`='".date("Y-m-d H:i:s")."'  WHERE `id_user`=".$_SESSION["user_session"];
      $db_connexion->query($sql);
      $db_connexion->exec();

      session_destroy();
      unset($_SESSION["user_session"]);
      return true;
	}catch(PDOException $e){
        echo $e->getMessage();
	}
 
}
// fonction de modification de l'utilisateur
function user_update($user_id , $db_connexion){
	// Récuperation de profil
	$sql = 'SELECT * FROM users where id_user=:user';
	$stmt = $db_connexion->prepare($sql);
	$stmt->execute(array(":user" =>$user_id));
	$row_user = $stmt->fetch();

	$form = '<form action="" method="post">
            <div class="form-group">
                <input type="text" class="form-control" name="user_name" placeholder="Username " value="'.$row_user['user_name'].'" />
            </div>  
             <div class="form-group">
                <input type="text" class="form-control" name="user_mail" placeholder="Usermail " value="'.$row_user['user_email'].'"  />
            </div> 
            <div class="form-group">
                <input type="password" class="form-control" name="user_pass" placeholder="Password "   />
            </div> 
            <div class="form-group">
                <input type="type" class="form-control" name="user_firstname" placeholder="Firstname"   />
            </div> 
            <div class="form-group">
                <input type="password" class="form-control" name="user_lastname" placeholder="Lastname"   />
            </div> 
            <div class="form-group">
                <input type="password" class="form-control" name="user_lastname" placeholder="Adress"   />
            </div> 
            <div class="form-group">
                <input type="password" class="form-control" name="user_lastname" placeholder="Zip code"   />
            </div> 
            <div class="form-group">
                <input type="submit" name="btn-update" class="btn btn-block btn-primary" value="Modifier" >
            </div>

           </form>';
  return $form;

}
// fonction d'ajout d'un utilisateur
function user_image_upload($user_id , $db_connexion){

}