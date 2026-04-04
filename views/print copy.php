<?php 
require '../fpdf/pdf.php';
include '../models/Connexion.php';
include '../controllers/Soutra.php';

    $prod = "";
    $ref = "";
    $prod = Soutra::singleVente($_GET['id']);
    if (isset($_GET['id']) && !empty($prod)) {

        $info = Soutra::getInfoBoutique();
        foreach ($prod as $key => $value) {
            $ref = $value;
            break;
        }

        if(isset($_GET['f']) && $_GET['f']  == 'p5'){
            $print = new PDF("p", "mm", "A4");
            $w = array(45, 24, 20, 39);

                $print->addPage();
                $print->logo($ref,$info);
                $print->setTextColor(0, 0, 0);
                // $print->Cell(44,10,'*******************************',0,0,'L');
                // $print->Cell(83,10,'*******************************',0,1,'R');
                $print->docBody($w,$prod);
                $print->output('',date('YmdHis').'.pdf');
        }else{

            $print = new PDF("p", "mm", "A5");
            $w = array(45, 24, 20, 39);

                $print->addPage();
                $print->logo($ref,$info);
                $print->setTextColor(0, 0, 0);
                // $print->Cell(44,10,'******************************',0,0,'L');
                // $print->Cell(83,10,'*****************************',0,1,'R');
                $print->docBody($w,$prod);
                $print->footDesign();
                $print->output('',date('YmdHis').'.pdf');

        }
        
    }else{
        http_response_code(400);
    }
 ?>