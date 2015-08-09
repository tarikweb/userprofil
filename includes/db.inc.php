<?php
function sec_session_start() {
    $session_name = 'sec_session_id';   // Attribue un nom de session
    $secure = false;
    // Cette variable empêche Javascript d’accéder à l’id de session
    $httponly = true;
    // Force la session à n’utiliser que les cookies
    if (ini_set('session.use_only_cookies', 1) === FALSE) {
        exit();
    }
    // Récupère les paramètres actuels de cookies
    $cookieParams = session_get_cookie_params();
    session_set_cookie_params($cookieParams["lifetime"],
        $cookieParams["path"], 
        $cookieParams["domain"], 
        $secure,
        $httponly);
    // Donne à la session le nom configuré plus haut
    session_name($session_name);
    session_start();            // Démarre la session PHP 
    session_regenerate_id();    // Génère une nouvelle session et efface la précédente
}
sec_session_start(); // démarrage de la session unique pour chaque visiteur
// identifiants de connexion
$db_host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "base3";

try {
    $db_connexion = new PDO("mysql:host=$db_host;dbname=$db_name;", $db_user, $db_pass);
    // conexxion pdo 
}
catch (PDOException $e) {
    echo $e->getMessage();
    // detection d'erreurs exceptionnelles  
}

