<?php
define("USER", "root");
define("PASSWORD", "");
define("dbd", "mysql:host=localhost;dbname=supjeans");

$bdd = new PDO(dbd, USER, PASSWORD);
if (isset($_GET['Item'])) {
    $sql = 'SELECT * FROM objets where Id = :Id';
    $Motus = $bdd->prepare($sql);
    $Motus->execute(array(
        ":Id" => $_GET['Item']
    ));
    foreach ($Motus as $row) {
        ?>

        <img src="/Supjeans/<?php echo $row['Image'] ?>" alt='<?php echo utf8_encode($row['Nom']) ?>'
             class="img-fluid rounded p-4 w-50 float-left">
        <h3 class="border-bottom"><?php echo utf8_encode($row['Nom']) ?></h3>
        <p>Price: <?php echo $row['Prix'] ?>€</p>
        <p>Description: <?php echo $row['Description'] ?></p>

        <?php
        if ($row['Disponibilite'] == 0) {
            ?>
            <button onclick="Add()" class="btn btn-dark">Acheter <?php echo $row['Prix'] ?>€</button onclick>
            <?php
        }else{
            ?>
            <button onclick="Add()" disabled="" class="btn btn-dark">Acheter <?php echo $row['Prix'] ?>€</button onclick>
            <?php
        }
    }
} elseif (isset($_GET['Search'])) {
    $sql = 'SELECT * FROM objets';
    $Motus = $bdd->prepare($sql);
    $Motus->execute();
    foreach ($Motus as $row) {
        if (strpos(utf8_encode($row['Nom']), $_GET['Search']) !== false) {
            ?>

            <div style="width: 24% !important;" class="col-md-4">
                <a href="<?php echo "/Supjeans/Item/" . utf8_encode($row['Nom']) . "/" ?>"
                   class="font-weight-normal text-muted">
                    <img src="/Supjeans/<?php echo $row['Image'] ?>" alt='<?php echo utf8_encode($row['Nom']) ?>'
                         class="img-fluid rounded p-4">
                    <h3><?php echo $row['Nom'] ?></h3>
                    <h3><?php echo $row['Prix'] ?>€</h3>
                </a>

            </div>
            <?php
        }

    }
}


