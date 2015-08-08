<?php 
require_once 'includes/db.inc.php';
include 'includes/user.inc.php';

if (isset($_POST["btn-login"])) {
    $username = $_POST["txt_uname_email"];
    $usermail = $_POST["txt_uname_email"];
    $userpass = $_POST["txt_password"];
    // user_login fonction qui permet d'authentifier un utilisateur
    if (user_login($username, $usermail, $userpass, $db_connexion)) {
        header("location:index.php");
    }
    else {
        header("Location:index.php?erreur=true");
    }
}