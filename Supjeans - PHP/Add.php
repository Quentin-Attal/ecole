<?php
session_cache_expire(60*24);
session_set_cookie_params("86400","/");

session_start();
if (isset($_GET['Test'])) {
    if (isset($_SESSION[$_GET['Test']."a"])) {
        $_SESSION[$_GET['Test']."a"]++;
        echo $_SESSION[$_GET['Test']."a"];
    } else {
        $_SESSION[$_GET['Test']."a"] = 1;
    }

}
elseif (isset($_GET['NoTest'])) {

    if (isset($_SESSION[$_GET['NoTest']."a"])) {
        $_SESSION[$_GET['NoTest']."a"]--;
        echo $_SESSION[$_GET['NoTest']."a"];
    } else {
        $_SESSION[$_GET['NoTest']."a"] = 0;
    }
    if (isset($_SESSION[$_GET['NoTest']."a"]) && $_SESSION[$_GET['NoTest']."a"] == 0){
        unset($_SESSION[$_GET['NoTest']."a"]);
    }

}
else{
    header("Location: /Supjeans/error 404");
}