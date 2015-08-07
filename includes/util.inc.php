<?php

// fonction pour redimensionner l'image
function resize_image($fichier, $extension = 'jpeg') {
    $largeur = 300; // nouvelle largeur souhaité 
    $hauteur = 400; // nouvelle hauteur souhaité
    // On change de répertoire pour pouvoir accéder simplement aux fichiers images
    chdir("upload");

    // on applique la fonction list afin de récupperer deux variables qui sont la hauteur / la largeur de la foto d'origine 

    list($hauteurImageSource, $largeurImageSource) = getimagesize($fichier);

    // on definit la fonction correspondante à la création de la ressource image GD selon l'extention fournit (3 cas : imagecreatefromjpeg , imagecreatefromgif , imagecreatefrompng) 
    if ($extension == ".jpg")
        $extension = ".jpeg";

    $functionCreateImage = "imagecreatefrom" . trim($extension, '.');
    // on récuppere la ressource image
    $imageSource = $functionCreateImage($fichier);

    // création une nouvelle image redimmensionnée 
    $imageFinale = imagecreatetruecolor($largeur, $hauteur);
    imagecopyresampled($imageFinale, $imageSource, 0, 0, 0, 0, $largeur, $hauteur, $largeurImageSource, $hauteurImageSource);

    $nomFichierFinal = "300x400_" . $fichier;
    $imageRender = "image" . trim($extension, '.');

    // ajout d'un @ au début de la fonction supprime les warning générés 
    @$imageRender($imageFinale, $nomFichierFinal, 100); // la fonction qui va créer la nouvelle foto en dure sur le serveur redimensionnée
    imagedestroy($imageSource);
    echo "Avatar redimensionné avec succés";
}
