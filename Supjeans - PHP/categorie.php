<?php
define("USER", "root");
define("PASSWORD", "");
define("dbd", "mysql:host=localhost;dbname=supjeans");
header('Content-Type: text/html;charset=UTF-8');

$bdd = new PDO(dbd, USER, PASSWORD);
$sql = "SELECT Id from categorie where Nom = :Nam";
$ID = $bdd->prepare($sql);
$ID->execute(array(
    ":Nam" => $_GET['Categorie']
));
$data = $ID->fetch();
$sql = 'SELECT * FROM objets where Categorie =  :ID';
$Motus = $bdd->prepare($sql);
$Motus->execute(array(
    ":ID" => $data['Id']
));
foreach ($Motus as $row) {
    ?>

    <div style="width: 24% !important;" class="col-md-4">
        <a href="<?php echo "/Supjeans/Item/" . utf8_encode($row['Nom']) . "/" ?>" class="font-weight-normal text-muted">
            <img src="/Supjeans/<?php echo $row['Image'] ?>" alt='<?php echo utf8_encode($row['Nom']) ?>'
                 class="img-fluid rounded p-4">
            <h3><?php echo utf8_encode($row['Nom']) ?></h3>
            <h3><?php echo $row['Prix'] ?>€</h3>
        </a>

    </div>
    <?php
}