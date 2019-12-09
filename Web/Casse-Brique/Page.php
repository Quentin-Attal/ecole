<?php

namespace Page;


use Exception;
use PDO;

class Page
{
    private string $name;

    private function head()
    {
        echo "<html lang='fr'><head><title>" . $this->name . "</title><meta charset='UTF-16'>" .
            "<link rel='stylesheet' href=\"../Bootstratp/css/bootstrap.min.css\">" .
            "<link rel='stylesheet' href=\"../Element.css\">" .
            "</head>";
    }

    public function bdd(){
        define("LINK",     "mysql:host=localhost;dbname=test;charset=utf8");
        define("USER",    "root");
        define("PASSWORD", "");
        try {
            $bdd = new PDO(LINK, USER, PASSWORD);
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
        return $bdd;
    }


    function __construct() {
        $a = func_get_args();
        $i = func_num_args();
        if (method_exists($this,$f='__construct'.$i)) {
            call_user_func_array(array($this,$f),$a);
        }
        else{
            $this->name = "Page";
            $this->head();
        }

    }
    function __construct1($PageName) {
        $this->name = $PageName;
        $this->head();
    }
}