<?php 
include 'includes/db.inc.php';
$id = (isset($_GET["id"]))?$_GET["id"]:"";
$cart = $_SESSION["cart"];
$ids = array();
foreach($cart as $key => $c){
   $ids[$key] = $c["id"];
}
$key = array_search($id , $ids);
unset($cart[$key]);
$_SESSION["cart"] = $cart;
header("Location:produit.php?id=$id");
