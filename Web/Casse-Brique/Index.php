<?php

include_once "Page.php";

$page = new \Page\Page(basename(__FILE__));

?>

<body class="bg-dark">
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
            <table class="border border-primary table-bordered w-50 h-75 m-auto">
                <tbody  id="table">

                </tbody>
            </table>
        </div>
        <div></div>
    </div>
</main>

</body>

<script>
    window.onload = function(){
        CreateTable(document.getElementById("table"));
    };
    function CreateTable(element){
        let numbTr = 5;
        let numbTd = 6;
        for (let i = 0; i < numbTd; i++){
            let obj = document.createElement("tr");
            for (let j = 0; j < numbTr; j++){
                let color;
                switch (j) {
                    case 0:
                        color = "bg-primary";
                        break;
                    case 1:
                        color = "bg-secondary";
                        break;
                    case 2:
                        color = "bg-success";
                        break;
                    case 3:
                        color = "bg-danger";
                        break;
                    case 4:
                        color = "bg-warning";
                        break;
                    case 5:
                        color = "bg-info";
                        break;
                }
                let brique = document.createElement("td");
                brique.className += Math.floor(Math.random() * Math.floor(2)) === 1 ? color : "border-0";
                obj.appendChild(brique);
            }
            element.appendChild(obj);
        }
        for (let i = 0; i < numbTd-1; i++) {
            let bas = document.createElement("tr");
            let ghost = document.createElement("td");
            ghost.className = "border-0";
            bas.appendChild(ghost);
            element.appendChild(bas);
        }
        let bas = document.createElement("tr");
        let Barre = document.createElement("div");
        Barre.className += "border-0 position-relative bg-light";
        Barre.style += ";height: 100%; width: 66%;";
        Barre.id = "barre";
        bas.appendChild(Barre);
        element.appendChild(bas);
    }
    document.getElementById("table").parentNode.addEventListener("mousemove", function(event) {
        Move(event);
    });

    function Move(Element) {
        let obj = document.getElementById("table").parentNode;
        let barre = document.getElementById("barre");
        if ((Element.clientX - obj.offsetLeft - barre.offsetWidth / 2) >= 0 &&
            obj.offsetWidth + obj.offsetLeft >= Element.clientX + barre.offsetWidth / 2 ) {
            barre.style.left = (Element.clientX - obj.offsetLeft - barre.offsetWidth / 2) + 'px';
        }
        else if (obj.offsetWidth + obj.offsetLeft <= Element.clientX + barre.offsetWidth / 2){
            barre.style.left = obj.offsetWidth - 2 - barre.offsetWidth + 'px';
        }
        else if ((Element.clientX - obj.offsetLeft - barre.offsetWidth / 2) <= 0){
            barre.style.left = '0px';
        }
    }

</script>