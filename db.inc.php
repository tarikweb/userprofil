<?php
session_start(); // démarrage de la session unique pour chaque visiteur
// identifiants de connexion
$db_host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name= "base3";

try{
  $db_connexion = new PDO("mysql:host=$db_host;dbname=$db_name;",$db_user,$db_pass);
  // conexxion pdo 
}catch(PDOException $e){
	echo $e->getMessage();
	// detection d'erreurs exceptionnelles  
}

