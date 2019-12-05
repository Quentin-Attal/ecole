<?php

namespace Page;


class Page
{
    private $name;

    function head()
    {
        echo "<html lang='fr'><head><title>" . $this->name . "</title><meta charset='UTF-16'>" .
            "<link rel=\"stylesheet\" href=\"https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css\" integrity=\"sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm\" crossorigin=\"anonymous\">" .
            "</head><body>";
    }


    public function Page()
    {
        $this->name = basename(__FILE__);
        $this->head();
    }
}