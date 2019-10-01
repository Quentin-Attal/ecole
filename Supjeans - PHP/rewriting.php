<?php
include("Page.php");
$Page = new Page();
$bdd = $Page->Bdd();
$sql = "SELECT Nom FROM categorie";
$statement = $bdd->query($sql);
$bool = false;
$Other = ['Index', 'Account', 'Login', 'Register', 'Command', 'Logout','Pay','PDF','Transaction'];
foreach ($Other as $row) {
    if (preg_match('/' . $row . '/', $_SERVER['REDIRECT_URL'], $match)) {
        // Modification du code retour, pour que les moteurs de recherche indexent nos pages !
        header("Status: 200 OK", false, 200);
        $bool = true;
        require $row . '.php';
    }
}
if (!$bool) {
    foreach ($statement as $row) {
        if (preg_match('/' . $row["Nom"] . '/', $_SERVER['REDIRECT_URL'], $match) && !$bool) {
            // Modification du code retour, pour que les moteurs de recherche indexent nos pages !
            header("Status: 200 OK", false, 200);
            $bool = true;
            require 'Index.php';
        }
    }
}
$Other = ['Not', 'Search'];
foreach ($Other as $row) {
    if (strpos($_SERVER['REDIRECT_URL'], '/' . $row . '/') !== false && !$bool) {
        // Modification du code retour, pour que les moteurs de recherche indexent nos pages !
        header("Status: 200 OK", false, 200);
        $bool = true;
        require 'Index.php';
    }
}
if (!$bool) {
    $sql = "SELECT Nom FROM objets";
    $statement = $bdd->query($sql);
    foreach ($statement as $row) {
        if (preg_match('/' . $row["Nom"] . '/', $_SERVER['REDIRECT_URL'], $match) && !$bool) {
            // Modification du code retour, pour que les moteurs de recherche indexent nos pages !
            header("Status: 200 OK", false, 200);
            $bool = true;
            require 'Index.php';
        }
    }
}


if (!$bool) {
    require 'Error 404.php';
}
