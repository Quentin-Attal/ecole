<?php
if (!isset($bool)) {
} else {
    header("Location: /Supjeans/error 404.php");

}
include("Page.php");
$Page = new Page();
$bdd = $Page->Bdd();
$sql = "SELECT Role FROM users WHERE Email = :mail ";
$info = 0;

$select = $bdd->prepare($sql);

$select->execute(
    array(
        "mail" => $_SESSION['Mail']
    )
);
$Fetch = $select->fetch();
if ($Fetch['Role'] == 1) {
    if (strpos($_SERVER['REQUEST_URI'], "M", -2)) {
        $sql = "UPDATE `transaction history` SET Complete = !Complete WHERE ID = :id ";


        $select = $bdd->prepare($sql);
        $session = substr($_SERVER['REQUEST_URI'], 22, -2);

        $select->execute(
            array(
                'id' => $session
            )
        );
    } else {
        $session = substr($_SERVER['REQUEST_URI'], 22, -1);
        $sql = "SELECT * FROM `transaction history` WHERE ID = :id ";


        $select = $bdd->prepare($sql);

        $select->execute(
            array(
                'id' => $session
            )
        );
        $OBJ = $select->fetch();
        if (isset($OBJ['ID'])) {
            $Page->Connexion();
            $Page->Head("Modify Transaction");
            $Page->Header();

            if (isset($_POST['submit'])) {
                $ADDR = $_POST['ADDR'];
                $Mot = explode(",", $OBJ['Produits']);
                $Price = explode(",", $OBJ['Prix']);
                $error = 0;
                for ($i = 0; $i < sizeof($Mot); $i += 2) {
                    if (isset($_POST['Num' . $i])) {
                        continue;
                    } else {
                        $error = 1;
                        break;
                    }
                }
                if ($error == 0) {
                    $incr = 0;
                    $total = 0;
                    for ($i = 0; $i < sizeof($Mot); $i += 2) {
                        $Mot[$i + 1] = $_POST['Num' . $i];
                        $total += $Price[$incr++] * $Mot[$i + 1];
                        if ($Mot[$i + 1] == 0) {
                            unset($Mot[$i]);
                            unset($Mot[$i + 1]);
                            unset($Price[$incr - 1]);
                        }
                    }
                    $Mot = implode(',', $Mot);
                    $Price = implode(',', $Price);
                    $sql = "UPDATE `transaction history` SET Produits=:Produit,Prix=:Prix,Total=:Total,Address=:ADDR WHERE ID = :id ";


                    $select = $bdd->prepare($sql);

                    $select->execute(
                        array(
                            'Produit' => $Mot,
                            'Prix' => $Price,
                            'Total' => $total,
                            "ADDR" => $ADDR,
                            'id' => $session
                        )
                    );
                    header("Location: /Supjeans/Transaction/".$session."/");
                }

            }


            ?>
            <a id="Data" href="/Supjeans/Account/" class="btn btn-dark btn-block h-100">
                Return to account
            </a>
            <form method="post" action="/Supjeans/Transaction/<?php echo $session?>/" class="form-signin text-center">
                <h1 class="h3 mb-3 font-weight-normal">Modify Transaction number: <?php echo $OBJ['ID'] ?></h1>
                <h4>Users mail <?php echo $OBJ['Users'] ?></h4>
                <input type="Text" name="ADDR" value="<?php echo $OBJ['Address'] ?>">
                <br>
                <br>
                <?php
                $Mot = explode(",", $OBJ['Produits']);
                $Price = explode(",", $OBJ['Prix']);
                $inc = 0;
                for ($i = 0; $i < sizeof($Mot); $i += 2) {

                    echo "Item: " . $Mot[$i];
                    echo "<br>Number: <input name='Num" . $i . "' id='Num" . $i . "' onchange='Change(" . $i . ")' min='0' class=\"form-control d-inline w-25\" type=\"Number\" value='" . $Mot[$i + 1] . "'>";
                    echo "  Total: <p class=\"d-inline w-25\" id='" . $i . "'>" . $Price[$inc++] * $Mot[$i + 1] . "</p>";
                    echo " <br><br>";
                }
                ?>
                <p class="border-bottom"></p>
                All Total: <p class="d-inline w-25" id="Total"><?php echo $OBJ['Total'] ?></p>


                <br>
                <div class="mb-3">
                    <input class="btn btn-lg btn-primary btn-block" type="submit" value="Change" name="submit">
                </div>
            </form>
            <a id="Data" href="/Supjeans/PDF/<?php echo $session ?>/" class="btn btn-dark btn-block h-100">
                See pdf
            </a>
            <script>
                function Change(value) {
                    let max = <?php echo sizeof($Mot); ?>;
                    let total = 0;

                    let Numb = document.getElementById("Num" + value).value * 20;
                    document.getElementById(value).innerText = String(Numb);
                    for (let i = 0; i < max; i += 2) {
                        total += Number(document.getElementById(String(i)).innerText);
                    }
                    document.getElementById('Total').innerText = String(total);

                }

            </script>
            <?php
        } else {
            header("Location: /Supjeans/Account/.php");
        }
    }

} else {
    header("Location: /Supjeans/.php");

}