<?php

include_once "Page.php";

$page = new \Page\Page(basename(__FILE__));

?>

<body class="bg-light">
<header>
    <div class="navbar navbar-dark bg-dark shadow-sm">
        <div class="container d-flex justify-content-between">
            <a href="#" class="navbar-brand d-flex align-items-center">
                <strong>Casse-Brique</strong>
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarHeader" aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </div>
</header>
<main role="main">
    <h1 class="text-md-center col-lg p-2">
        Casse-Brique
    </h1>

    <div class="container-fluid m-auto p-2">
        <div>
            <table class="border-danger" onload="CreateTable();">
            </table>
        </div>
        <div></div>
    </div>
</main>

</body>

<script>
    function CreateTable(){
        console.log("hello");
    }
</script>