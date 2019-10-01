<?php
if (!isset($bool)) {
} else {
    header("Location: /Supjeans/error 404.php");
}
include("Page.php");
$Title = "Pay";
$Page = new Page();
$Page->Connexion();
$Page->Head($Title);
$Page->Header();
if (isset($_SESSION['login'])) {
    $bdd = $Page->Bdd();
    $sql = "SELECT * FROM users WHERE Email = :mail ";


    $select = $bdd->prepare($sql);

    $select->execute(
        array(
            "mail" => $_SESSION['Mail']
        )
    );
    $Obj = $select->fetch();
    $ADD = $Obj['Delivery Address'];
    if ($Obj['Billing Address'] != "" && $Obj['Delivery Address'] != "") {
        $NameSession = ['login', "Last_Name", "Mail"];
        $info = 0;
        $total = 0;
        $Object = "";
        $Price = "";
        foreach ($_SESSION as $session => $val) {
            if (!in_array($session, $NameSession)) {

                $sql = "SELECT * FROM objets WHERE Id = :Id ";


                $select = $bdd->prepare($sql);
                $session = substr($session, 0, -1);

                $select->execute(
                    array(
                        "Id" => $session
                    )
                );

                $info++;
                $Obj = $select->fetch();
//                unset($_SESSION[$session."a"]);
                $Object .= "," . utf8_encode($Obj["Nom"]);
                $Object .= "," . $val;
                $Price .= "," . $Obj['Prix'] * $val;
                $Object = substr($Object, 1);
                $Price = substr($Price, 1);
                $total += $Obj['Prix'] * $val;
            }
        }
        if ($info == 0) {
            echo "<div class='text-center mx-auto px-3 py-3 pt-md-5 pb-md-4'>
<h1>You can't buy because you don't have product</h1>
</div>";
        } else {
            echo "<h1>Thank you for your purchase, you have pay " . $total . " €</h1>";
            $sql = "INSERT INTO `transaction history` VALUES (NULL,:MAIL,:PRODUIT,:PRIX,:TOTAL,:DAT,:COMP,:ADDR)";
            $select = $bdd->prepare($sql);
            $session = substr($session, 0, -1);

            $select->execute(
                array(
                    "MAIL" => $_SESSION['Mail'],
                    "PRODUIT" => $Object,
                    "PRIX" => $Price,
                    "TOTAL" => $total,
                    "DAT" => date("Y-m-d"),
                    "COMP" => 0,
                    "ADDR" => $ADD
                )
            );
        }

    } else {
        echo "<div class='text-center mx-auto px-3 py-3 pt-md-5 pb-md-4'><form method='post' action='/Supjeans/Account/'>
<p>You need to have an address register</p>
<input class=\"btn btn-lg btn-primary btn-block\" type=\"submit\" value=\"Go to account\" name=\"submit\">
</form></div>";
    }

} else {
    echo "<div class='text-center mx-auto px-3 py-3 pt-md-5 pb-md-4'><form method='post' action='/Supjeans/login/'>
<p>You need to login for purchase</p>
<input class=\"btn btn-lg btn-primary btn-block\" type=\"submit\" value=\"Go to login\" name=\"submit\">
</form></div>";
}