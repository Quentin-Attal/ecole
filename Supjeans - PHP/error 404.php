<?php
$Title = "Error";
if (!isset($bdd)){
    require_once 'Page.php';
    $Page = new Page();
}
$Page->Connexion();
$Page->Head($Title);
$Page->Header();

?>

<div>
    <h1>ERROR this page does not exist</h1>
    <a href="/Supjeans">Go to Home</a>
</div>

<?php

$Page->end();
