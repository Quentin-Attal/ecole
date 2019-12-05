<?php

namespace Page;


use Exception;
use PDO;

class Page
{
    private $name;

    private function head()
    {
        echo "<html lang='fr'><head><title>" . $this->name . "</title><meta charset='UTF-16'>" .
            "<link rel=\"stylesheet\" href=\"https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css\" integrity=\"sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm\" crossorigin=\"anonymous\">" .
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

    public function Page()
    {
        $this->name = basename(__FILE__);
        $this->head();
        echo "<body></body>";
    }
}