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
        <div class="row h-75 w-100" id="Element_left">
            <div class="col-3 m-auto text-md-center">
                <button class="btn btn-lg rounded" onclick="Start()">Start</button>
                <br><br>
                <button class="btn btn-lg rounded">Restart</button>
                <br><br>
                <p class="text-light">Nombre de vie restante : <span id="life">3</span></p>
            </div>
            <div class="col-6 text-md-center">
                <div>
                    <table class="border border-primary w-100 h-100">
                        <tbody id="table">
                        </tbody>
                    </table>
                </div>
                <p class="text-light">Score : <span id="score">0</span></p>
            </div>
            <div class="col-3">
            </div>

        </div>
    </div>
</main>

</body>

<script>

    let numbTr = 10;
    let numbTd = 7;
    let start = false;
    let Brique_class = [];
    document.getElementById("table").parentNode.addEventListener("mousemove", function (event) {
        Move(event);
    });

    window.onload = function () {
        CreateTable(document.getElementById("table"));
    };

    window.onresize = function () {
        if (start === false) {
            let Balle = document.getElementById("balle");
            let Barre = document.getElementById("barre");
            Balle.style.bottom = Barre.offsetHeight + Balle.offsetHeight + 1 + 'px';
        }
    };

    class Brique{
        constructor(obj){
            let Table = document.getElementById("table");
            this.Min_Width = obj.offsetLeft * 100 / Table.offsetWidth ;
            this.Max_Width = obj.offsetLeft * 100 / Table.offsetWidth + obj.clientWidth * 100 / Table.offsetWidth;
            this.Min_Height = obj.offsetTop * 100 / Table.offsetHeight ;
            this.Max_Height = obj.offsetTop * 100 / Table.offsetHeight + obj.clientHeight * 100 / Table.offsetHeight;
            this.obj = obj;
        }
        check_Height(){
            return [this.Min_Height,this.Max_Height];
        }
        check_Width(){
            return [this.Min_Width,this.Max_Width];
        }
        Object(){
            return this.obj;
        }
    }

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
        Barre.className += "border-0 position-relative bg-light rounded";
        Barre.id = "barre";
        Barre.style.left = '0px';
        bas.appendChild(Barre);
        let Balle = document.createElement("div");
        Balle.id = "balle";
        Balle.className += "border-0 position-relative bg-danger rounded-circle";
        document.getElementById("table").parentNode.parentNode.appendChild(Balle);
        element.appendChild(bas);
        Balle.style.left = Barre.offsetWidth / 2 - Balle.offsetWidth / 2 + 'px';
        Balle.style.bottom = Barre.offsetHeight + Balle.offsetHeight + 1 + 'px';

        for (let i = 0; element.parentNode.rows[i]; i++) {
            for (let j = 0; element.parentNode.rows[i].cells[j]; j++) {
                if (element.parentNode.rows[i].cells[j].className !== "border-0"){
                    Brique_class.push(new Brique(element.parentNode.rows[i].cells[j]));
                }
            }
        }

    }

    function Move(Element) {
        let ObjWidth = document.getElementById("table").parentNode;
        let ObjLeft = document.getElementById("table").parentNode.parentNode.parentNode;
        let barre = document.getElementById("barre");

        if ((Element.clientX - ObjLeft.offsetLeft - barre.offsetWidth / 2) >= 0 &&
            ObjWidth.offsetWidth + ObjLeft.offsetLeft >= Element.clientX + barre.offsetWidth / 2) {

            barre.style.left = (Element.clientX - ObjLeft.offsetLeft - barre.offsetWidth / 2) + 'px';

        } else if (ObjWidth.offsetWidth + ObjLeft.offsetLeft <= Element.clientX + barre.offsetWidth / 2) {

            barre.style.left = ObjWidth.offsetWidth - 2 - barre.offsetWidth + 'px';

        } else if ((Element.clientX - ObjLeft.offsetLeft - barre.offsetWidth / 2) <= 0) {

            barre.style.left = '0px';
        }

        if (start === false) {
            let Balle = document.getElementById("balle");
            Balle.style.left = parseInt(barre.style.left) + barre.offsetWidth / 2 - Balle.offsetWidth / 2 + 'px';

        }
    }

    function Start() {
        if (start === false) {
            start = true;
            Game();
        }
    }

    function Game() {
        let minBottom = document.getElementById("balle").style.bottom =
            parseInt(document.getElementById("balle").style.bottom) * 100 / document.getElementById("table").offsetHeight + "%";
        let minLeft = document.getElementById("balle").style.left =
            parseInt(document.getElementById("balle").style.left) * 100 / document.getElementById("table").offsetWidth + "%";
        let change_score = document.getElementById('score');
        let score = parseInt(change_score.innerText);
        let up = true;
        let game = true;
        let Balle = document.getElementById("balle");
        let Barre = document.getElementById("barre");
        let Table = document.getElementById("table");
        setInterval(function () {
            if (game) {
                if (parseInt(Balle.style.bottom) >= 100 - parseInt(minBottom)) {
                    up = false;
                } else if (parseInt(Balle.style.bottom) <= parseInt(minBottom)) {
                    if (parseInt(Barre.style.left) * 100 / Table.offsetWidth <= parseInt(Balle.style.left) + 2
                        && parseInt(Balle.style.left) - 2 <= (parseInt(Barre.style.left) * 100 / Table.offsetWidth +
                            Barre.clientWidth * 100 / Table.offsetWidth)) {
                        up = true;
                    } else {
                        game = false;
                    }
                }
                else{
                    for (let i = 0;i < Brique_class.length;i++){
                        if (up && parseInt(Balle.style.bottom) + 2 > 100 - Brique_class[i].check_Height()[1]
                            && Brique_class[i].check_Width()[0] <= parseInt(Balle.style.left) + 2
                            &&  parseInt(Balle.style.left) - 2 <=  Brique_class[i].check_Width()[1] ){
                            up = false;
                            Brique_class[i].Object().className = "border-0";
                            Brique_class.splice(i,1);
                            score += 10;
                            change_score.innerText = score.toString();

                            break;
                        }
                        else if (!up && parseInt(Balle.style.bottom) - 2 > 100 - Brique_class[i].check_Height()[0]
                            && Brique_class[i].check_Width()[0] <= parseInt(Balle.style.left) + 2
                            &&  parseInt(Balle.style.left) - 2 <=  Brique_class[i].check_Width()[1] ){
                            up = true;
                            Brique_class[i].Object().className = "border-0";
                            Brique_class.splice(i,1);
                            break;
                        }

                    }
                }
                if (up) {
                    Balle.style.bottom = parseInt(Balle.style.bottom) + 1 + "%";

                } else {
                    Balle.style.bottom = (parseInt(Balle.style.bottom) - 1) + "%";
                    if (Balle.offsetTop > Table.offsetHeight){
                        Balle.style.bottom = (parseInt(Balle.style.bottom) - 1) + "%";
                    }
                }
            }
        }, 10);
    }
</script>