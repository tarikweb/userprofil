<?php

// fonction edition d'une catégorie
function category_edit($id, $db_connexion) {

    $statement = $db_connexion->query("SELECT * FROM categorie WHERE id_categorie = $id;");
    $categorie = $statement->fetch();
    return $categorie;
}

function category_children($id_parent = 0, $level = 1, $db_connexion) {
    static $last;
    $statement = $db_connexion->prepare("SELECT * FROM categorie where id_parent=:parent AND niveau=:niveau;");
    $statement->execute(array(":parent" => $id_parent, ":niveau" => $level));
    $categories = $statement->fetchAll();
    $level++;
    if ($categories) {
        foreach ($categories as $key => $categorie) {
            // répéte autant de fois la chaine '═'
            $plus = "├" . str_repeat('─', $level - 1);
            if ($level == 2 && $key === 0) {
                $plus = str_replace("├", "┌", $plus);
            }


            echo "<li>" . $plus . " <a href='index.php?id=" . $categorie["id_categorie"] . "'>" . utf8_encode($categorie["nom"]) . "</a></li>";
            $query = "SELECT * FROM categorie WHERE id_parent=:id_categorie AND niveau=:level";
            $statement = $db_connexion->prepare($query);
            $statement->bindParam(":id_categorie", $categorie["id_categorie"]);
            $statement->bindParam(":level", $level);
            // Liaison param :level , et $level
            $statement->execute();
            // Execution de la requête préparée 
            $results = $statement->fetchAll();
            // Méthode fetch de l'objet statement  
            if ($results) {
                category_children($categorie["id_categorie"], $level, $db_connexion);
            }
            else {
                $last = $categorie["id_categorie"];
            }
            // Appel à la fonction d'une manière récursive
        }
    }
}
