<?php


$IPage = 0;
if ($_SERVER['REQUEST_URI'] == "/Supjeans/" or strpos($_SERVER['REQUEST_URI'], '/Supjeans/Index.php') !== false) {
    include("Page.php");
    $Title = "Home";
    $Page = new Page();
    $bdd = $Page->Bdd();
}
if (isset($_GET['Categories'])) {
    $Title = $_GET['Categories'];
    $IPage = 1;
} elseif (isset($_GET['categories'])) {
    $Title = $_GET['categories'];
    $IPage = 1;
}
if (isset($_GET['Item'])) {
    $Title = $_GET['Item'];
    $IPage = 2;
} elseif (isset($_GET['item'])) {
    $Title = $_GET['item'];
    $IPage = 2;
}
$sql = "SELECT Nom FROM categorie";
$statement = $bdd->query($sql);
foreach ($statement as $row) {
    if ($_SERVER['REQUEST_URI'] == "/Supjeans/Category/" . $row['Nom'] . "/") {
        $Title = $row['Nom'];
        $IPage = 1;
    }
}
if (isset($_GET['item'])) {
    $sql = "SELECT Nom FROM `objets`";
    $statement = $bdd->prepare($sql);
    $statement->execute();
    $count2 = 0;
    foreach ($statement as $row) {
        if (strpos(utf8_encode($row['Nom']), $_GET['item']) !== false) {
            $count2++;
        }
        if ($count2 > 1) {
            break;
        }
    }
    if ($count2 == 1) {
        header("Location: /Supjeans/Item/" . $_GET['item'] . "/");
    } elseif ($count2 > 1) {
        header("Location: /Supjeans/Search/" . $_GET['item'] . "/");

    } else {
        header("Location: /Supjeans/Not/" . $_GET['item'] . "/");
    }
}
if (strpos($_SERVER['REQUEST_URI'], 'Search')) {
    $Title = 'Search';
    $IPage = 3;
}
if (strpos($_SERVER['REQUEST_URI'], 'Not')) {
    $Title = 'Nothing is found';
    $IPage = 4;
}
$sql = "SELECT * FROM objets";
$statement = $bdd->query($sql);
$count = 0;
$value = 0;
foreach ($statement as $row) {
    if (urldecode($_SERVER['REQUEST_URI']) == "/Supjeans/Item/" . utf8_encode($row['Nom']) . "/") {
        $Title = $row['Nom'];
        $count++;
        $value = $row['Id'];
        $IPage = 2;
    }
}


$Page->Connexion();
$Page->Head($Title);
$Page->Header();

$statement = $bdd->query($sql);
echo "<div><form action='/Supjeans/Index.php' method='get'>
<input list=\"item\" name=\"item\" class=\"form-control\" autocomplete='off' placeholder='Search item...'>";
echo "<datalist id=\"item\">";
$sql = "SELECT Nom FROM objets";
$statement = $bdd->query($sql);
foreach ($statement as $row) {
    echo "<option value='" . utf8_encode($row['Nom']) . "'>" . utf8_encode($row['Nom']);
}

echo "</datalist></form></div>";
$sql = "SELECT * FROM categorie";
$statement = $bdd->query($sql);
echo "<div class=\"nav-scroller py-1 mb-2\"><nav class=\"nav d-flex justify-content-between\">";
foreach ($statement as $row) {

    echo "<a class=\"p-2 text-muted\" href=\"/Supjeans/Category/" . $row['Nom'] . "/\">" . $row['Nom'] . "</a>";
}
echo "</nav></div>";
if ($IPage == 0) {

    for ($i = 0; $i < 4; $i++) {
        $sql = "SELECT Id FROM `objets`";
        $info = $bdd->prepare($sql);
        $info->execute();
        $max = 0;
        foreach ($info as $row) {
            $max = ($row['Id'] > $max) ? $row['Id'] : $max;
        }
        $rand = rand(0, $max - 1);
        $sql = "SELECT * FROM `objets` WHERE Id = :MAX";
        $sta = $bdd->prepare($sql);
        $sta->execute(array(
            "MAX" => intval($rand)
        ));
        $state = $sta->fetch();
        if (isset($state['Prix'])) {
            echo "<a href='/Supjeans/Item/" . utf8_encode($state['Nom']) . "/'>
<img src=\"/Supjeans/" . $state['Image'] . "\" alt=\"Image de " . utf8_encode($state['Nom']) . "\" class=\"img-fluid rounded p-4\"
             style=\"width: 24% !important;\"></a>";
        } else {
            $i--;
        }

    }
}

if ($IPage == 1) {
    ?>
    <div id="content" class="text-center row"></div>
    <script>
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("content").innerHTML =
                    this.responseText;
            }
        };
        xhttp.open("GET", "/Supjeans/categorie.php?Categorie=<?php echo urlencode($Title);?>");
        xhttp.send();

    </script>
    <?php
}

if ($IPage == 2) {
    ?>
    <div id="content" class="text-center"></div>

    <script>
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("content").innerHTML =
                    this.responseText;
            }
        };
        xhttp.open("GET", "/Supjeans/item2.php?Item=<?php echo $value;?>");
        xhttp.send();

        function Add() {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    alert("You have buy this item.")
                }
            };
            xhttp.open("GET", "/Supjeans/Add.php?Test=<?php echo $value;?>");
            xhttp.send();
        }
    </script>
    <?php
}

if ($IPage == 3) {
    $Mot = substr($_SERVER['REQUEST_URI'], 17);
    $Mot = substr($Mot, 0, -1);
    ?>
    <div id="content" class="text-center row"></div>
    <script>
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("content").innerHTML =
                    this.responseText;
            }
        };
        xhttp.open("GET", "/Supjeans/item2.php?Search=<?php echo $Mot?>");
        xhttp.send();

    </script>
    <?php
}

if ($IPage == 4) {
    ?>
    <div id="content" class="text-center">
        <h1 class="jumbotron">Nothing is found</h1>
    </div>

    <?php
}

$Page->end();
