<?php
if (!isset($bool)) {
    include("Page.php");

    $Title = "Register";
    $Page = new Page();
} else {
    header("Location: /Supjeans/error 404.php");

}


if (isset($_POST['submit'])) {
    if (isset($_POST['name']) && isset($_POST['password']) && isset($_POST['password2']) &&
        isset($_POST['Last_name']) && isset($_POST['mail'])) {
        if (!empty($_POST['name']) && !empty($_POST['password']) && !empty($_POST['password2']) &&
            !empty($_POST['Last_name']) && !empty($_POST['mail'])) {
            $name = htmlentities($_POST['name']);
            $pass = htmlentities($_POST['password']);
            $last_name = htmlentities($_POST['Last_name']);
            $pass2 = htmlentities($_POST['password2']);
            $bdd = $Page->Bdd();
            $sql = "SELECT * FROM users WHERE Email = :mail ";


            $select = $bdd->prepare($sql);

            $select->execute(
                array(
                    "mail" => $_POST['mail']
                )
            );
            $Obj = $select->fetch();
            if (isset($Obj['Email'])) {
            } elseif (filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)) {
                $One = 0;
                if ($pass2 == $pass) {
                    $One = 1;
                    if (strlen($pass) >= 8 && preg_match('/[^a-zA-Z\d]/', $pass)
                        && preg_match('/\d/', $pass) && preg_match('/[a-z]/', $pass)
                        && preg_match('/[A-Z]/', $pass)) {
                        $bdd = $Page->Bdd();
                        $pass = password_hash($pass, PASSWORD_DEFAULT);

                        $sql = "INSERT INTO users (`Id`, `Email`, `Password`, `Billing Address`, 
                        `Delivery Address`, `Role`, `Name`, `Last_Name`)
                        VALUES (NULL, :Mail, :Pass, '', '', 0, :Na, :Lna)";


                        $select = $bdd->prepare($sql);

                        $select->execute(
                            array(
                                "Mail" => $_POST['mail'],
                                "Pass" => $pass,
                                "Na" => $name,
                                "Lna" => $last_name
                            )
                        );
                        $_SESSION['login'] = 0;
                        $_SESSION['Last_Name'] = $last_name;
                        $_SESSION['Mail'] = $_POST['mail'];

                    }
                }

            }


        }
    }
}

$Page->Connexion();


$Page->Head($Title);
$Page->Header1();


?>
    <form method="post" action="/Supjeans/Register.php" class="form-signin text-center">
        <h1 class="h3 mb-3 font-weight-normal">Register</h1>
        <label for="inputName" class="sr-only">Password</label>
        First Name<input id="Name" class="form-control" type="text" name="name" required=""
                         placeholder="John">
        <label for="inputLastName" class="sr-only">Password</label>
        Last Name<input id="LastName" class="form-control" type="text" name="Last_name" required=""
                        placeholder="Cena">
        <label for="inputEmail" class="sr-only">Email address</label>

        Mail <input id="inputEmail" type="email" name="mail" class="form-control" placeholder="Mail" required="">
        <?php
        if (isset($Obj['Email'])) {
            ?>
            <p style="color: red">Mail already use</p>
            <?php
        }
        ?>
        <label for="inputPassword" class="sr-only">Password</label>
        Password <input id="inputPassword" class="form-control" type="password" name="password" required=""
                        placeholder="Password">
        <small id="passwordHelpBlock" class="form-text text-muted">
            Your password must be 8-20 characters long, contain uppercase, lowercase, numbers and special characters
        </small>
        Confirm Password <input class="form-control" type="password" name="password2" required=""
                                placeholder="Password">
        <?php
        if (isset($One)) {
            if ($One == 0) {
                ?>
                <p style="color: red">Password are different</p>
                <?php
            } elseif ($One == 1) {
                ?>
                <p style="color: red">Password need to contains special characters, number,
                    uppercase and lowercase</p>
                <?php
            }
        }
        ?>
        <br>
        <div class="mb-3">
            <input class="btn btn-lg btn-primary btn-block" type="submit" value="Register" name="submit">
        </div>
        <div>
            <a href="/Supjeans/Login/">Or Login ?</a>
        </div>
    </form>
<?php
$Page->end();
