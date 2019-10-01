<?php
if (!isset($bool)) {
} else {
    header("Location: /Supjeans/error 404.php");

}

if (!isset($_GET['Data'])) {
    include("Page.php");
    $Title = "Account";
    $Page = new Page();
    $Page->Connexion();
    if ($Page->IsConnect()) {
        header("Location: /Supjeans/");
    }
    $Page->Head($Title);
    $Page->Header();
    ?>

    <div id="content" class="text-center">
        <div class="row">
            <div class="col-md-4" style="height: 400px">
                <button id="Data" onclick="Data(this.id)" class="btn btn-dark btn-block h-100">
                    Change your data
                </button>
            </div>
            <div class="col-md-4" style="height: 400px">
                <button id="Transaction" onclick="Data(this.id)" class="btn btn-dark btn-block h-100">
                    Last transaction
                </button>
            </div>
            <div class="col-md-4" style="height: 400px">
                <button id="Address" onclick="Data(this.id)" class="btn btn-dark btn-block h-100">
                    Our address
                </button>
            </div>
        </div>
    </div>

    <script>
        function Data(ID) {
            this.innerText = "";
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("content").innerHTML =
                        this.responseText;
                }
            };
            xhttp.open("GET", "/Supjeans/Account.php?Data=" + ID);
            xhttp.send();
        }
        <?php
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
        if ($Fetch['Role'] == 1){
        ?>

        function Add(ID) {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                }
            };
            xhttp.open("GET", "/Supjeans/Transaction/" + ID + "M/");
            xhttp.send();
            if (document.getElementById(ID + 'M').innerText === "Validate") {
                document.getElementById(ID + 'M').innerText = "Need validation";
            } else {
                document.getElementById(ID + 'M').innerText = "Validate";

            }
        }

        function Search(value) {
            let allClasses = [];

            let allElements = document.querySelectorAll('*');

            for (let i = 0; i < allElements.length; i++) {
                let classes = allElements[i].className.toString().split(/\s+/);
                for (let j = 0; j < classes.length; j++) {
                    let cls = classes[j];
                    if (cls && allClasses.indexOf(cls) === -1) {
                        allClasses.push(cls);
                    }
                }
            }
            for (let j = 0; j < allClasses.length; j++) {
                if (allClasses[j].includes("@") === true) {

                    let Classn = document.getElementsByClassName(allClasses[j]);

                    if (value === "") {
                        for (let i = 0; i < Classn.length; i++) {
                            Classn[i].style.display = ""; // depending on what you're doing
                        }
                    } else {
                        if (allClasses[j].includes(value) === false) {
                            for (let i = 0; i < Classn.length; i++) {
                                Classn[i].style.display = "none"; // depending on what you're doing
                            }
                        }
                    }
                }
            }

        }

        <?php

        }

        ?>


    </script>
    <?php
    $Page->end();

} else {

    if ($_GET['Data'] == 'none') {
        ?>
        <div class="row">

            <div class="col-md-4" style="height: 400px">
                <button id="Data" onclick="Data(this.id)" class="btn btn-dark btn-block h-100">
                    Change your data
                </button>
            </div>
            <div class="col-md-4" style="height: 400px">
                <button id="Transaction" onclick="Data(this.id)" class="btn btn-dark btn-block h-100">
                    Last transaction
                </button>
            </div>
            <div class="col-md-4" style="height: 400px">
                <button id="Address" onclick="Data(this.id)" class="btn btn-dark btn-block h-100">
                    Our address
                </button>
            </div>
        </div>
        <?php
    }

    if ($_GET['Data'] == 'Data') {
        include("Page.php");
        $Page = new Page();
        $bdd = $Page->Bdd();
        $sql = "SELECT * FROM users WHERE Email = :mail ";


        $select = $bdd->prepare($sql);

        $select->execute(
            array(
                "mail" => $_SESSION['Mail']
            )
        );
        $Obj = $select->fetch();
        ?>
        <div class="col-md-4">
            <button id="none" onclick="Data(this.id)" class="btn btn-primary btn-block">return</button>
        </div>
        <h3 class="border-bottom">Data</h3>
        <form method="post" action="/Supjeans/Account/" class="form-signin text-center">
            <h1 class="h3 mb-3 font-weight-normal">Your Data</h1>
            <label for="inputName" class="sr-only">Password</label>
            First Name<input id="Name" class="form-control" type="text" name="name" required=""
                             placeholder="John" value="<?php echo $Obj['Name'] ?>">
            <label for="inputLastName" class="sr-only">Password</label>
            Last Name<input id="LastName" class="form-control" type="text" name="Last_name" required=""
                            placeholder="Cena" value="<?php echo $Obj['Last_Name'] ?>">
            <label for="inputEmail" class="sr-only">Email address</label>

            Mail <input id="inputEmail" type="email" name="mail" class="form-control" placeholder="Mail"
                        required="" value="<?php echo $Obj['Email'] ?>">

            <label for="inputPassword" class="sr-only">Password</label>
            Your password <input id="inputPassword" class="form-control" type="password" name="password" required=""
                                 placeholder="Password">

            <br>
            <div class="mb-3">
                <input class="btn btn-lg btn-primary btn-block" type="submit" value="Change" name="submit">
            </div>
        </form>

        <?php
    }

    if ($_GET['Data'] == 'Transaction') {
        ?>
        <div class="col-md-4">
            <button id="none" onclick="Data(this.id)" class="btn btn-primary btn-block">return</button>
        </div>
        <h3 class="border-bottom">Transaction</h3>
        <?php
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
            $sql = "SELECT DISTINCT Users FROM `transaction history`";
            $select = $bdd->prepare($sql);

            $select->execute();
            ?>
            <input list="item" name="item" class="form-control" autocomplete="off" placeholder="Name Users..."
                   oninput="Search(this.value)">
            <datalist id="item">
                <?php
                foreach ($select as $row) {
                    echo "<option value='" . $row['Users'] . "'>" . $row['Users'];
                }
                ?>
            </datalist>

            <?php
            $sql = "SELECT * FROM `transaction history`  ORDER BY `transaction history`.`ID` DESC";
            $select = $bdd->prepare($sql);

            $select->execute();

        } else {
            $sql = "SELECT * FROM `transaction history` WHERE Users = :mail  ORDER BY `transaction history`.`ID` DESC";
            $select = $bdd->prepare($sql);

            $select->execute(
                array(
                    "mail" => $_SESSION['Mail']
                )
            );
        }

        echo "<table class=\"table\"><thead><tr>";
        if ($Fetch['Role'] == 1) {
            echo "<th scope=\"col\">Users name</th>";
        }
        echo "<th scope=\"col\">Your transaction number</th><th scope=\"col\">Date</th><th scope=\"col\">Total</th>
<th scope=\"col\">Status</th><th scope=\"col\">Invoice</th>";
        if ($Fetch['Role'] == 1) {
            echo "<th scope=\"col\">Modify</th><th scope=\"col\">Complete</th></tr></thead><tbody>";
        } else {
            echo "</tr></thead><tbody>";
        }

        foreach ($select as $row) {
            if ($Fetch['Role'] == 1) {
                echo "<tr class='" . $row['Users'] . "'><th>" . $row['Users'] . "</th>";
            } else {
                echo "<tr>";
            }
            echo "<th scope=\"row\">" . $row['ID'] . "</th><td>
 " . $row['Date'] . "</td><td>
 " . $row['Total'] . "</td><td id='" . $row['ID'] . "M'>
";
            if ($row['Complete'] == 0) {
                echo "Need validation";
            } else {
                echo "Validate";
            }
            echo "</td><td><a class='nav-link text-info bg-dark' href='/Supjeans/PDF/" . $row['ID'] . "/'>
<img src=\"/Supjeans/Image/pdf.gif\" alt=\"Facture\" class=\"icon\">
&nbsp;PDF
</a></td>";
            if ($Fetch['Role'] == 1) {
                echo "<td><a class='nav-link text-info bg-dark' href='/Supjeans/Transaction/" . $row['ID'] . "/'>
Modify
</a></td>
<td><button class='nav-link text-info bg-dark btn m-auto' onclick='Add(" . $row['ID'] . ")'>
Complete
</button></td>
</tr>";
            } else {
                echo "</tr>";
            }

        }

    }

    if ($_GET['Data'] == 'Address') {
        ?>
        <div class="col-md-4">
            <button id="none" onclick="Data(this.id)" class="btn btn-primary btn-block">return</button>
        </div>
        <h3 class="border-bottom">Address</h3>
        <?php
        include("Page.php");
        $Page = new Page();
        $bdd = $Page->Bdd();
        $sql = "SELECT * FROM users WHERE Email = :mail ";


        $select = $bdd->prepare($sql);

        $select->execute(
            array(
                "mail" => $_SESSION['Mail']
            )
        );
        $Obj = $select->fetch();
        echo "<form action='/Supjeans/Account' method='post' class=\"form-signin text-center\">
Billing Address<input type='text' name='BA' class=\"form-control\" value='" . $Obj['Billing Address'] . "'>
Delivery Address<input class=\"form-control\" type='text' name='DA' value='" . $Obj['Delivery Address'] . "'>
<br>
<input type='submit' name='Submit' class=\"btn btn-lg btn-primary btn-block\">
</form>";
    }
}

if (isset($_POST['DA']) && isset($_POST['BA']) && isset($_POST['Submit'])) {
    if (!empty($_POST['DA']) && !empty($_POST['BA'])) {
        $bdd = $Page->Bdd();
        $sql = "UPDATE `users` SET `Billing Address` = :BA, `Delivery Address` = :DA WHERE Email = :mail ";


        $select = $bdd->prepare($sql);

        $select->execute(
            array(
                "BA" => $_POST['BA'],
                "DA" => $_POST['DA'],
                "mail" => $_SESSION['Mail']
            )
        );
    }
}

if (isset($_POST['name']) && isset($_POST['Last_name']) && isset($_POST['password']) && isset($_POST['mail'])) {
    if (!empty($_POST['name']) && !empty($_POST['Last_name']) && !empty($_POST['password']) && !empty($_POST['mail'])) {
        $bdd = $Page->Bdd();
        $sql = "SELECT * FROM users WHERE Email = :mail";

        $select = $bdd->prepare($sql);

        $select->execute(
            array(
                "mail" => $_SESSION['Mail']
            )
        );
        $Data = $select->fetch();
        $name = htmlentities($_POST['name']);
        $pass = htmlentities($_POST['password']);
        $last_name = htmlentities($_POST['Last_name']);

        if (password_verify($pass, $Data['Password']) && filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)) {
            $sql = "UPDATE `users` SET `Name` = :N, `Last_Name` = :LN, Email = :EM WHERE Email = :mail ";


            $select = $bdd->prepare($sql);

            $select->execute(
                array(
                    "N" => $name,
                    "LN" => $last_name,
                    "EM" => $_POST['mail'],
                    "mail" => $_SESSION['Mail']
                )
            );
            $_SESSION['Last_Name'] = $_POST['Last_name'];
            $_SESSION['Mail'] = $_POST['mail'];
        }

    }
}
?>

