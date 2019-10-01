<?php
if (!isset($bool)){
    include("Page.php");
    $Page = new Page();
}
else{
    header("Location: /Supjeans/error 404.php");

}


if (isset($_POST['submit'])) {
    if (isset($_POST['name']) && isset($_POST['password'])) {
        if (!empty($_POST['name']) && !empty($_POST['password'])) {
            $name = htmlentities($_POST['name']);
            $pass = htmlentities($_POST['password']);
            $bdd = $Page->Bdd();

            $sql = "SELECT * FROM users WHERE Email = :Mail";

            $select = $bdd->prepare($sql);

            $select->execute(
                array(
                    "Mail" => $name
                )
            );
            $row = $select->fetch();
            if (isset($row['Email'])) {
                if (password_verify($pass, $row['Password'])) {
                    $_SESSION['login'] = 0;
                    $_SESSION['Last_Name'] = $row['Last_Name'];
                    $_SESSION['Mail'] = $row['Email'];

                    if (isset($_POST['remember'])) {
                        if (!empty($_POST['remember'])) {
                            $check = $_POST['remember'];
                            if ($check == 1) {
                                $_SESSION['login'] = 1;
                                setcookie("Last_Name", $row['Last_Name'], time() + 60 * 60 * 24 * 30);
                                setcookie("Mail", $row['Email'], time() + 60 * 60 * 24 * 30);

                            }
                        }

                    }
                }
                header("Location: /Supjeans");

            }
        }
    }
}

$Page->Connexion();
$Page->Head("Login");
$Page->Header1();
?>


    <form method="post" action="Login.php" class="form-signin text-center">
        <h1 class="h3 mb-3 font-weight-normal">Login</h1>
        <?php
        if (isset($_POST['name']) && isset($_POST['password'])) {
            ?>
            <p style="color: red">Bad credentials!</p>
            <?php
        }
        ?>
        <label for="inputEmail" class="sr-only">Email address</label>
        Mail <input id="inputEmail" type="email" name="name" class="form-control" placeholder="Mail" required="">
        <label for="inputPassword" class="sr-only">Password</label>
        Password <input id="inputPassword" class="form-control" type="password" name="password" required=""
                        placeholder="Password">
        <div class="checkbox mb-3">
            <label>
                <input type="checkbox" name="remember" value="1"> Remember me
            </label>
            <input class="btn btn-lg btn-primary btn-block" type="submit" value="log in" name="submit">
        </div>
        <div>
            <a href="/Supjeans/Register/">Or Register ?</a>
        </div>
    </form>



<?php
$Page->end();