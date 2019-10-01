<?php
if (!isset($bool)){
    include("Page.php");
    $Title = "Command";
    $Page = new Page();
    $Page->Connexion();
    $Page->Head($Title);
    $Page->Header();
    $bdd = $Page->Bdd();
}
else{
    header("Location: /Supjeans/error 404.php");

}

$NameSession = ['login', "Last_Name", "Mail"];
$info = 0;
$total = 0;
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
        $Obj = $select->fetch();
        $info++;
        $total += $Obj['Prix'] * $val;
        echo "<div class='h-25 border-bottom' id='" . $session . "'><div class='d-inline-block col-md-6'><img class='w-25 h-25' src='/Supjeans/" . $Obj['Image'] .
            "'></div>" . utf8_encode($Obj["Nom"]) . " " . "
            Number: <p class='d-inline-block' id='N" . $session . "'> " . $val . "  </p>
            Price:<p  id='P" . $session . "' class='d-inline-block'>&nbsp " . $Obj['Prix'] * $val . " </p>€
            <button class='btn btn-dark' onclick='Add(" . $session . ")'>Add</button> 
            <button class='btn btn-dark' onclick=\"Remove(" . $session . ")\">Remove</button><br></div>";
    }
}
if (!isset($_SESSION['login'])){
    echo "<div class='text-center mx-auto px-3 py-3 pt-md-5 pb-md-4'><form method='post' action='/Supjeans/login/'>
<p>You need to login for purchase</p>
<input class=\"btn btn-lg btn-primary btn-block\" type=\"submit\" value=\"Go to login\" name=\"submit\">
</form></div>";
}

if ($info == 0) {
    echo "<h1>You don't have a product in your card</h1>";
}
elseif (isset($_SESSION['login'])){
    echo "<div class='text-center mx-auto px-3 py-3 pt-md-5 pb-md-4'><form method='post' action='/Supjeans/Pay/'>
<input class=\"btn btn-lg btn-primary btn-block\" type=\"submit\" value=\"Go to pay\" name=\"submit\">
</form></div>";
}
?>
    <script>
        function Add(value) {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("N"+value).innerHTML =
                        this.responseText;
                    let Numb = Number(document.getElementById("P"+value).innerText) +
                        (Number(document.getElementById("P"+value).innerText) / (Number(this.responseText) - 1));
                    document.getElementById("P"+value).innerHTML = "&nbsp&nbsp"+ String(Numb);

                }
            };
            xhttp.open("GET", "/Supjeans/Add.php?Test=" + value);
            xhttp.send();
        }

        function Remove(value) {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("N"+value).innerHTML =
                        this.responseText;
                    let Numb = Number(document.getElementById("P"+value).innerText) -
                        (Number(document.getElementById("P"+value).innerText) / (Number(this.responseText) + 1));
                    document.getElementById("P"+value).innerHTML = "&nbsp&nbsp"+ String(Numb);
                    if (Number(this.responseText) === 0){
                        document.getElementById(value).parentNode.removeChild(document.getElementById(value)) ;
                    }
                }
            };
            xhttp.open("GET", "/Supjeans/Add.php?NoTest=" + value);
            xhttp.send();

        }
    </script>
<?php
$Page->end();