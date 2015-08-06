<?php

require_once 'db.inc.php';
include 'user.inc.php';

if (isset($_GET["logout"]) && ($_GET["logout"] == "true")) {
    user_logout($db_connexion);
    header("Location:index.php");
}

if (!isset($_SESSION["user_session"])) {
    header("location:index.php");
}