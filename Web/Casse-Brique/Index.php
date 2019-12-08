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
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarHeader"
                    aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
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
        <div class="row h-75 w-100">
            <div class="col-3 m-auto text-md-center">
                <button class="btn btn-lg rounded">Start</button>
                <br><br>
                <button class="btn btn-lg rounded">Restart</button>
                <br><br>
                <p class="text-light">Nombre de vie restante : <span>3</span></p>
            </div>
            <div class="col-6 text-md-center">
                <div>
                    <table class="border border-primary table-bordered w-100 h-100">
                        <tbody id="table">
                        </tbody>
                    </table>
                </div>
                <p class="text-light">Score : <span>0</span></p>
            </div>
            <div class="col-3">
            </div>

        </div>
    </div>
</main>

</body>

<script>
    window.onload = function () {
        CreateTable(document.getElementById("table"));
    };
    let numbTr = 10;
    let numbTd = 7;
    let start = false;

    function CreateTable(element) {
        for (let i = 0; i < numbTd; i++) {
            let obj = document.createElement("tr");
            for (let j = 0; j < numbTr; j++) {
                let color;
                switch (j % 6) {
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
                        color = "bg-purple";
                        break;
                    case 4:
                        color = "bg-warning";
                        break;
                    case 5:
                        color = "bg-info";
                        break;
                    default:
                        color = "border-0";
                        break;
                }
                let brique = document.createElement("td");
                brique.className += Math.floor(Math.random() * Math.floor(2)) === 1 ? color : "border-0";
                obj.appendChild(brique);
            }
            element.appendChild(obj);
        }
        for (let i = 0; i < numbTd; i++) {
            let bas = document.createElement("tr");
            let ghost = document.createElement("td");
            ghost.className = "border-0";
            bas.appendChild(ghost);
            element.appendChild(bas);
        }
        let bas = document.createElement("tr");
        let Barre = document.createElement("div");
        Barre.className += "border-0 position-relative bg-light";
        Barre.style += ";height: 100%; width: 125%;";
        Barre.id = "barre";
        bas.appendChild(Barre);
        let Balle = document.createElement("div");
        Balle.id = "balle";
        Balle.className += "border-0 position-relative bg-danger rounded-circle";
        Balle.style += ";width: 1em;height:1em";
        document.getElementById("table").parentNode.parentNode.appendChild(Balle);
        element.appendChild(bas);
        Balle.style.left = Barre.offsetWidth / 2 - Balle.offsetWidth / 2 + 'px';
        Balle.style.bottom = Barre.offsetHeight + Balle.offsetHeight + 1 +  'px';
    }

    document.getElementById("table").parentNode.addEventListener("mousemove", function (event) {
        Move(event);
    });

    function Move(Element) {
        let ObjWidth = document.getElementById("table").parentNode;
        let ObjLeft = document.getElementById("table").parentNode.parentNode.parentNode;
        let barre = document.getElementById("barre");
        let Balle = document.getElementById("balle");

        if ((Element.clientX - ObjLeft.offsetLeft - barre.offsetWidth / 2) >= 0 &&
            ObjWidth.offsetWidth + ObjLeft.offsetLeft >= Element.clientX + barre.offsetWidth / 2) {

            barre.style.left = (Element.clientX - ObjLeft.offsetLeft - barre.offsetWidth / 2) + 'px';

        } else if (ObjWidth.offsetWidth + ObjLeft.offsetLeft <= Element.clientX + barre.offsetWidth / 2) {

            barre.style.left = ObjWidth.offsetWidth - 2 - barre.offsetWidth + 'px';

        } else if ((Element.clientX - ObjLeft.offsetLeft - barre.offsetWidth / 2) <= 0) {

            barre.style.left = '0px';
        }

        if (!start) {

            Balle.style.left = parseInt(barre.style.left) + barre.offsetWidth / 2 - Balle.offsetWidth / 2 + 'px';

        }
    }

</script>