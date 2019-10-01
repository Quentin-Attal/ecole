<?php
require('Page.php');
$Page = new Page();
$Page->Connexion();
$bdd = $Page->Bdd();

$sql = "SELECT * FROM `transaction history` WHERE Id = :Id ";


$select = $bdd->prepare($sql);
$session = substr($_SERVER['REQUEST_URI'], 14, -1);

$select->execute(
    array(
        "Id" => $session
    )
);
$Obj = $select->fetch();
$sql = "SELECT Role FROM `users` WHERE Email = :Id ";


$select = $bdd->prepare($sql);

$select->execute(
    array(
        "Id" => $_SESSION['Mail']
    )
);
$fetchA = $select->fetch();
if (isset($_SESSION['Mail'])) {
    if ($Obj['Users'] == $_SESSION['Mail'] || $fetchA['Role'] == 1) {
        require('fpdf.php');


        class PDF extends FPDF
        {
// En-tête
            function Header()
            {
                // Logo
                //$this->Image('logo.png',10,6,30);
                // Police Arial gras 15
                $this->SetFont('Arial', 'B', 15);
                // Décalage à droite
                $this->Cell(80);
                // Titre
                $this->Cell(30, 10, 'Supjeans', 1, 0, 'C');
                // Saut de ligne
                $this->Ln(20);
            }

// Pied de page
            function Footer()
            {
                // Positionnement à 1,5 cm du bas
                $this->SetY(-15);
                // Police Arial italique 8
                $this->SetFont('Arial', 'I', 8);
                // Numéro de page
                $this->Cell(0, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
            }
        }

// Instanciation de la classe dérivée
        $pdf = new PDF();
        $pdf->SetTitle('Receipt');
        $pdf->AliasNbPages();
        $pdf->AddPage();
        $pdf->SetFont('Times', '', 12);
        $pdf->Cell(0, 10, 'Date of buy: ' . date("l jS \of F Y", strtotime($Obj['Date'])), 0, 1);

        $pdf->Cell(0, 10, 'Delivery address: ' . $Obj['Address'], 0, 1);

        $pdf->Cell(60, 10, '', 1, 0, 'C');
        $pdf->Cell(60, 10, 'List of item buy', 1, 0, 'C');
        $pdf->Cell(60, 10, '', 1, 1, 'C');
        $pdf->Cell(60, 5, 'Name', 1, 0, 'C');
        $pdf->Cell(60, 5, 'Number', 1, 0, 'C');
        $pdf->Cell(60, 5, 'Total', 1, 1, 'C');

        $Mot = explode(",", $Obj['Produits']);
        $Price = explode(",", $Obj['Prix']);
        $inc = 0;

        for ($i = 0; $i < sizeof($Mot); $i += 2) {
            $pdf->Cell(60, 5, $Mot[$i], 1, 0, 'C');
            $pdf->Cell(60, 5, $Mot[$i + 1], 1, 0, 'C');
            $pdf->Cell(60, 5, $Price[$inc++] * $Mot[$i + 1], 1, 1, 'C');
        }
        $pdf->Cell(60, 5, '', 0, 0, 'C');
        $pdf->Cell(60, 5, '', 0, 0, 'C');
        $pdf->Cell(60, 5, '', 0, 1, 'C');
        $pdf->Cell(60, 5, '', 0, 0, 'C');
        $pdf->Cell(60, 5, '', 0, 0, 'C');
        $pdf->Cell(60, 5, 'Total Price: ' . $Obj['Total'], 0, 1, 'C');

        if ($fetchA['Role'] == 1) {
            $pdf->Output();
        } else {
            $pdf->Output('D', 'Order ' . $session . '.pdf');

        }

    } else {
        header("Location: /Supjeans/Account");
    }
} else {
    header("Location: /Supjeans/");
}
