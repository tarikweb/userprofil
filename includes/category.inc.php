<?php
// fonction edition d'une catégorie
function category_edit($id, $db_connexion){
$statement = $db_connexion->query("SELECT * FROM categorie where id_categorie = $id;");
$categorie = $statement->fetch();
return $categorie;
}

function category_children($categories , $level){


}