<?php

session_cache_expire(60*24);
session_set_cookie_params("86400","/");

session_start();
class Page
{
    public function Header()
    {
        ?>
        <header>
            <div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom shadow-sm">
                <a class="my-0 mr-md-auto font-weight-normal  text-center" href="/Supjeans">Supjeans </a>

                <?php
                if (isset($_SESSION['login'])) {
                    ?>
                    <a class="btn mr-sm-2" href="/Supjeans/Command/">&#8681; Card</a>

                    <a class="btn btn-outline-primary mr-sm-2" href="/Supjeans/Account/">
                        <span style="font-size: 0.8em"> Hello
                        <?php echo $_SESSION['Last_Name'] ?></span>
                        <br>
                        <span>Your Account</span>
                    </a>
                    <a class="btn btn-outline-primary" href="/Supjeans/Logout/">Logout</a>
                    <?php
                } else {
                    ?>
                    <a class="btn mr-sm-2" href="/Supjeans/Command/">&#8681; Card</a>
                    <a class="btn btn-outline-primary mr-sm-2" href="/Supjeans/Login/">Login</a>
                    <a class="btn btn-outline-primary" href="/Supjeans/Register/">Register</a>
                    <?php
                }
                ?>
            </div>

        </header>
        <?php
    }

    public function Header1()
    {
        ?>
        <header>
            <div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom shadow-sm">
                <a class="my-0 mr-md-auto font-weight-normal  text-center" href="/Supjeans">Supjeans </a>
            </div>
        </header>
        <?php
    }

    public function Connexion()
    {
        if (isset($_SESSION['login'])) {
            if ($_SESSION['login'] == 0) {
                if (basename($_SERVER['PHP_SELF']) == "Login.php"){
                    header("Location: /Supjeans/");
                }
            }
        } elseif (isset($_COOKIE['remember'])) {
            $_SESSION['login'] = 0;
            $_SESSION['Mail'] = $_COOKIE['Mail'];
            $_SESSION['Last_Name'] = $_COOKIE['Last_Name'];
            if (basename($_SERVER['PHP_SELF']) == "Login.php"){
                header("Location: /Supjeans/");
            }
        }
    }

    public function Head($Title)
    {
        ?>
        <!DOCTYPE html>
        <html lang="fr">
        <head>
            <title><?php echo $Title ?></title>
            <meta charset="utf-16"/>
            <link href="/Supjeans/signin.css" rel="stylesheet">

            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
                  integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T"
                  crossorigin="anonymous">
        </head>
        <body class="container">
        <?php
    }

    public function end()
    {
        ?>
        </body>
        </html>
        <?php
    }

    public function IsConnect(){
        if (!isset($_SESSION['login'])){
            return true;
        }
        return false;
    }

    public function Bdd(){
        define("USER", "root");
        define("PASSWORD", "");
        define("dbd", "mysql:host=localhost;dbname=supjeans");

        $bdd = new PDO(dbd, USER, PASSWORD);
        return $bdd;

    }


}


