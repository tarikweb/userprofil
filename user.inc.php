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
	
	$sql = 'SELECT * FROM users where id_user=:user';
	$stmt = $db_connexion->prepare($sql);
	$stmt->execute(array(":id_user" =>$user_id));
	$row_user = $stmt->fetch();
    var_dump();


	$from = "";


}
// fonction d'ajout d'un utilisateur
function user_image_upload($user_id , $db_connexion){

}