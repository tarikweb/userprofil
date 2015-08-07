<?php
// fonction d'affichage du produit avec son id

function edit_product($id,$db_connexion){

	try{
    $statement = $db_connexion->prepare("SELECT * FROM produit WHERE id_produit=:produit");
    $statement->execute(array(":produit" => $id));
    $result = $statement->fetch();
    return $result;

	}catch(PDOException $e){
      echo $e->getMessage();
	}

}