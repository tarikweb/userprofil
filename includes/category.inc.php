<?php
// fonction edition d'une catégorie
function category_edit($id, $db_connexion){
$statement = $db_connexion->query("SELECT * FROM categorie where id_categorie = $id;");
$categorie = $statement->fetch();
return $categorie;
}

function category_children($categories, $level = 1, $db_connexion){
	$plus = str_repeat('--',$level); // répéte autant de fois la chaine '--' 
	$level++;
    foreach($categories as $categorie){
       echo "<li><a href='?id=".$categorie["id_categorie"]."'>$plus".utf8_encode($categorie["nom"])."</a></li>";
       $query = "SELECT * FROM categorie where id_parent=:id_categorie and niveau=:level";//
       $statement = $db_connexion->prepare($query);
       $statement->bindParam(":id_categorie",$categorie["id_categorie"]);
       $statement->bindParam(":level",$level);  
       // Liaison param :nom , et $_POST["nom"]
       $statement->execute();
       // Execution de la requête préparée 
       $results = $statement->fetchAll(); 
       // Methode fetch de l'objet statement  
       if($results)
       category_children($results, $level , $db_connexion); 
       // Appel à la fonction d'une manière récursive
    }
}
