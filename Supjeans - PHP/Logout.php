<?php
setcookie("Mail", "", 1);
setcookie("Last_Name", "", 1);
session_cache_expire(60*24);
session_set_cookie_params("86400","/");

session_start();
unset($_SESSION['login']);
unset($_SESSION['Last_Name']);
unset($_SESSION['Mail']);
header("Location: /Supjeans/");
