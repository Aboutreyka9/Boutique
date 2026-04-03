<?php
require 'fpdf.php';
class PDF extends  FPDF
{
    function header()
    {
        // Police Arial gras 15
        $this->SetY(7);
        $this->SetFont('Arial', 'i', 8);
        // Décalage
        // $this->Cell(80);
        // Titre encadré
        $this->Cell(0, 5, 'Espace g-stock', 'B', 0, 'L');
        // Saut de ligne
        // $this->Ln(7);
        $this->setY($this->getY()+10);
    }
    // Affiche l'entete 
    public function logo($ref,$info)
    {

        $this->setTextColor(100, 100, 100);
        $this->setTitle('fiche' . date('h'));
        
        // APP NAME
        // $this->Cell(1, 1, utf8_decode($ref), 0, 1);
        $getYFact = $this->getY();
        $this->setFont('Times', 'BI', 18);
        $this->setTextColor(10, 50, 55);
        $this->Cell(30, 6, 'Gest-Stock ', 0, 0, '');
        // APP LOGO
        // $this->image('../assets/images/ficon.png', 10, 24, 15, 15);
        $this->image($info['image'], 10, 24, 15, 15);

        // INFO EMPLOYE
        $this->setY($this->getY()+10);
        $this->setX(26);
        $getY = $this->getX();
        $this->setFont('Times', 'BI', 10);
        $this->Cell(13, 1, 'CMPT :', 0, 0, 'L');
        $this->Cell(11, 1, '00756896', 0, 2, '');
        $this->setX(27);
        $this->Cell(19, 10, utf8_decode('CAISSE N° :'), 0, 0, '');
        $this->Cell(11, 10, '0056547887', 0, 1, '');

        $getXFact = $this->getx();


        // DENOMINATION DE LA BOUTIQUE
        $this->setFont('arial', '', 12);
        $this->Cell(30, 8, $info['nom'], 0, 0, '');

          // INFO SUR ADRESSE MAGASIN
          if (!empty($info['adresse'])) {

            $this->setY($this->getY() +7);
            $this->setFont('Times', 'I', 11);
            $this->multiCell(90, 3, $info['adresse'], 0,'L');
        }

         // INFO DE CONTACT 1
         $this->setY($this->getY()+1);
         $this->setFont('Times', '', 10);
         $this->Cell(7, 6, "Cel:", 0, 0, '');
         $this->Cell(19, 6, $info['contact1'], 0, 0, '');
 
         // INFO CONTACT 2 
         if (!empty($info['contact2'])) {
             $this->Cell(10, 6, "/ ".$info['contact2'], 0, 0, '');
         }

        //  REGLAGE DU POINTEUR Y
        $getbeforTable = $this->getY();


        // NUMERO FACTURE
        $this->setY($getYFact +1);
        $this->setX(-70);
        $this->setFont('Times', '', 11);
        $this->Cell(25, 1, utf8_decode('FACTURE N°:'), 0, 0, '');
        $this->setFont('Times', 'B', 14);
        $this->Cell(1, 1, utf8_decode($ref['code_vente']), 0, 1);
        $this->SetY($getbeforTable);


        // NOM ET PRENOM CLIENT 
        $this->setY($getYFact +10);
        $this->setX(-75);
        $getYCel = $this->getY();

        
        $this->setFont('arial', 'I', 11);
        $this->Cell(11, 1, 'client:', 0, 0, '');
        $nom = $ref['nom_client'] . '  ' . $ref['prenom_client'];
        $TexteSize = round($this->GetStringWidth($nom));

        if($TexteSize > 60){     

            $nom = ucwords($ref['nom_client'].'  '. substr($ref['prenom_client'],0,1));
            $this->setFont('Times', '', 10);
            $this->Cell(1, 1, $nom, 0, 0, '');

        }else{

            $nom = ucwords($nom);
            $this->setFont('Times', 'B', 10);
            $this->Cell(25, 1, $nom, 0, 0, '');
        }

        // NUMERO CLIENT
        $this->setY($getYCel+5);
        $this->setX(-75);
        
        $this->setFont('arial', 'I', 11);
        $this->Cell(10, 1, 'Cel:', 0, 0, '');
        $this->setFont('Times', 'B', 12);
        $this->Cell(1, 1, $ref['telephone_client'], 0, 0, '');

        $getYDate = $this->getY();

        // Date ENREGISTREMENT
        $this->setY($getYDate+20);
        $this->setX(-60);
        
        $this->setFont('Times', 'I', 11);
        $this->Cell(12, 1, 'DATE:', 0, 0, '');
        // $this->setFont('Times', '', 12);
        $this->Cell(1, 1,  date('d-m-y H:i:s'), 0, 0, '');

        $this->SetY($getbeforTable+15);

    }

    public function tHeader($header,$w)
    {
        for ($i = 0; $i < count($header); $i++) {
            $this->setFont('', '', 14);
            $this->setTextColor(0, 0, 0);
            $this->Cell($w[$i], 7, $header[$i], 1, 0, 'C');
        }
        $this->Ln();
    }

    public function docBody(array $w,array $data = [])
    {

        // Largeurs des colonnes
        $header = ["Designation", "P.U", "QTE", "P.TOTAL"];
        // En-tête
        $tt = 0;
        $mt = 0;

        $this->tHeader($header,$w);

        $this->setTextColor(100, 100, 100);
        $this->setFont('Times', '', 12);

        // Données
        $mot = "Lorem";

        $fill = false;
        // foreach ($datas as $key => $value) {
        foreach ($data as $key => $value) {

            $this->Cell($w[0], 7, $value['libelle_article'], 'LR');
            $this->Cell($w[1], 7, number_format($value['prix_vente'], 0, ',', ' '), 'LR', 0, 'R');
            $this->Cell($w[2], 7, $value['qte'], 'LR', 0, 'R');
            $this->Cell($w[3], 7, number_format($value['prix_vente'] * $value['qte'], 0, ',', ' '), 'LR', 0, 'R');
            $tt += ($value['prix_vente'] * $value['qte']);
            $this->Ln();
            $fill = !$fill;
        }
        // }
        // Trait de terminaison
        $this->Cell(array_sum($w), 0, '', 'T');
        $this->ln(7);
        $this->tFooter($tt,count($data));
    }

    public function tFooter($tt,$nb)
    {

        $this->setTextColor(0, 0, 0);

        $this->setFont('Times', '', 11);
        $this->Cell(0, 5, "NOMBRE D'ARTICLES:", 0, 0, 'L');
        $this->Cell(0, 5, $nb, 0, 1, 'R');

        $this->SetY($this->getY()+2);

        $this->setFont('Times', '', 13);
        $this->Cell(1, 5, "TOTAL (FCFA)", 0, 0, '');
        $this->Cell(0, 5, number_format($tt,0,',',' '), 0, 1, 'R');
        // $getYNbAr = $this->getY();
        // $this->setFont('', '', 11);
        // $this->setTextColor(0, 0, 0);
        $this->SetY($this->getY()+3);
        $this->setFont('Times', '', 12);

        $this->Cell(1, 5, "Espece (FCFA):", 0, 0, '');
        $this->Cell(0, 5, number_format($tt,0,',',' '), 0, 1, 'R');

        $this->Cell(5, 8, "Rendu (FCFA):", 0, 0, '');
        $this->Cell(0, 8, number_format("0",'2'), 0, 1, 'R');
    }

    public function body()
    {
    }
    public function footDesign()
    {
        $this->setY(-26);
        $this->setTextColor(0, 0, 0);
        $this->setFont('Times', '', 11);
        $this->Cell(0, 2, 'Merci et Aurevoir ', 0, 1, 'C');
    }
}
