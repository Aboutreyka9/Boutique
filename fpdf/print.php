<?php 

require './fpdf/fpdf.php';


class PDF extends  FPDF
{ 
	 function header()
	{
             // Police Arial gras 15
    $this->SetY(7);
    $this->SetFont('Arial','i',8);
    // Décalage
    // $this->Cell(80);
    // Titre encadré
    $this->Cell(0,5,'Espace g-stock','B',0,'L');
    // Saut de ligne
    $this->Ln(12);
    }

}
