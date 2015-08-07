<?php
// fonction edition d'une catégorie
function category_edit($id, $db_connexion){
$statement = $db_connexion->query("SELECT * FROM categorie where id_categorie = $id;");
$categorie = $statement->fetch();
return $categorie;
}

function category_children( $level = 1, $db_connexion){
         
	     $statement = $db_connexion->query("SELECT * FROM categorie where niveau=$level;");
         $categories = $statement->fetchAll();
         if ($categories){
         	++$level ;
         foreach($categories as $categorie){
              echo "<li><a href='?id=".$categorie["id_categorie"]."'>   ".utf8_encode($categorie["nom"])."</a>
                  </li>";
              // 2 eme niveau
              $query = "SELECT * FROM categorie where id_parent=:id_categorie";//
              $statement = $db_connexion->prepare($query);
              $statement->bindParam(":id_categorie",$categorie["id_categorie"]); // Liaison param :nom , et $_POST["nom"]
                  $statement->execute(); // Execution de la requête préparée 
                  $results = $statement->fetchAll(); // Methode fetch de l'objet statement 
                  if ($results){
                  foreach($results as $result){
                    echo "<li><a href='?id=".$result["id_categorie"]."'>".utf8_encode($result["nom"])."</a></li>";
                    category_children($level , $db_connexion);
                  }
             }
         }
         }	
         	
}