<?php
require 'fpdf.php';
class ListeData extends  FPDF
{
    function header()
    {
        // Police Arial gras 15
        $this->SetY(7);
        $this->SetFont('Arial', 'i', 8);
        // Décalage
        // $this->Cell(80);
        // Titre encadré
        $this->Cell(0, 5, 'Espace g-stock', '', 0, 'L');

        // Saut de ligne
        // $this->Ln(7);
        $this->setY($this->getY()+5);
    }
    
    function Footer()
    {
        
        // Positionnement à 1,5 cm du bas
        $this->SetY(-15);
        // Police Arial italique 8
        $this->SetFont('Arial','I',8);
        // Numéro et nombre de pages
        $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'R');
    }


    // Affiche l'entete 

    function pageTitle($title)
    {
        $this->AliasNbPages();

        // Police Arial gras 15
        $this->SetFont('Arial', '', 16);
        // Décalage
        // $this->Cell(80);
        // Titre encadré
        $this->Cell(0, 5, $title, 'B', 0, 'C');

        // Saut de ligne
        // $this->Ln(7);
        $this->setY($this->getY()+10);
    }
 
    public function tHeader($header,$w)
    {
        for ($i = 0; $i < count($header); $i++) {
            $this->setFont('times', 'B', 12);
            // $this->setTextColor(0, 0, 0);
            $this->Cell($w[$i], 7, $header[$i], 'B', 0, 'C');
        }
        $this->Ln();
    }

    // $head = ["Designation", "P.U", "QTE", "P.TOTAL"];
    public function bodyEmploye(array $w,array $head,array $data = [])
    {

        // Largeurs des colonnes
        // En-tête
        $this->tHeader($head,$w);

        $this->setFont('Helvetica', '', 12);

        // Données

        $fill = false;
        $this->setFont('Times', '', 12);

        foreach ($data as $key => $value) {

            $this->Cell($w[0], 10, $value['code_employe'], '', 0, 'C');
            $this->Cell($w[1], 10, $value['nom_employe'], '', 0, 'C');
            $this->Cell($w[2], 10, $value['prenom_employe'], '', 0, 'C');
            $this->Cell($w[3], 10, $value['telephone_employe'] , '', 0, 'C');
            $this->Cell($w[3], 10, $value['role'] , '', 0, 'C');
            $this->Ln();
            $fill = !$fill;
        }
    }

    public function bodyClient(array $w,array $head,array $data = [])
    {

        // Largeurs des colonnes
        // En-tête
        $this->tHeader($head,$w);

        $this->setFont('Helvetica', '', 12);

        // Données

        $fill = false;
        $this->setFont('Times', '', 12);

        foreach ($data as $key => $value) {

            $this->Cell($w[0], 10, $value['code_client'], '', 0, 'C');
            $this->Cell($w[1], 10, $value['nom_client'], '', 0, 'C');
            $this->Cell($w[2], 10, $value['prenom_client'], '', 0, 'C');
            $this->Cell($w[3], 10, $value['telephone_client'] , '', 0, 'C');
            $this->Ln();
            $fill = !$fill;
        }
    }

    public function bodyFournisseur(array $w,array $head,array $data = [])
    {

        // Largeurs des colonnes
        // En-tête
        $this->tHeader($head,$w);

        $this->setFont('Helvetica', '', 12);

        // Données

        $fill = false;
        $this->setFont('Times', '', 12);

        foreach ($data as $key => $value) {

            $this->Cell($w[0], 10, $value['code_fournisseur'], '', 0, 'C');
            $this->Cell($w[1], 10, $value['nom_fournisseur'], '', 0, 'C');
            $this->Cell($w[2], 10, $value['telephone_fournisseur'] , '', 0, 'C');
            $this->Ln();
            $fill = !$fill;
        }
    }

    public function bodyAchat(array $w,array $head,array $data = [])
    {

        // Largeurs des colonnes
        // En-tête
        $this->tHeader($head,$w);

        $this->setFont('Helvetica', '', 12);

        // Données

        $fill = false;
        $this->setFont('Times', '', 12);

        foreach ($data as $key => $value) {

            $this->Cell($w[0], 10, $value['code_achat'], '', 0, 'C');
            $this->Cell($w[1], 10, $value['article'], '', 0, 'C');
            $this->Cell($w[2], 10, number_format($value['total'],0,","," ").' FCFA' , '', 0, 'C');
            $this->Cell($w[3], 10, $value['code_fournisseur'], '', 0, 'C');
            $this->Cell($w[4], 10, Soutra::date_format($value['created_at']), '', 0, 'C');
            $this->Ln();
            $fill = !$fill;
        }
    }

    public function bodyVente(array $w,array $head,array $data = [])
    {

        // Largeurs des colonnes
        // En-tête
        $this->tHeader($head,$w);

        $this->setFont('Helvetica', '', 12);

        // Données

        $fill = false;
        $this->setFont('Times', '', 12);

        foreach ($data as $key => $value) {

            $this->Cell($w[0], 10, $value['code_vente'], '', 0, 'C');
            $this->Cell($w[1], 10, $value['article'], '', 0, 'C');
            $this->Cell($w[2], 10, number_format($value['total'],0,","," ").' FCFA' , '', 0, 'C');
            $this->Cell($w[3], 10, $value['code_client'], '', 0, 'C');
            $this->Cell($w[4], 10, Soutra::date_format($value['created_at']), '', 0, 'C');
            $this->Ln();
            $fill = !$fill;
        }
    }

    public function bodyInventaire(array $w,array $head,array $data = [])
    {

        // Largeurs des colonnes
        // En-tête
        $this->tHeader($head,$w);

        $this->setFont('Helvetica', '', 12);

        // Données

        $fill = false;
        $this->setFont('Times', '', 12);

        foreach ($data as $key => $value) {

            $this->Cell($w[0], 10, $value['article'], '', 0, 'C');
            $this->Cell($w[1], 10,  number_format($value['depenses'],0,","," ").' FCFA', '', 0, 'C');
            $this->Cell($w[2], 10, number_format($value['ventes'],0,","," ").' FCFA', '', 0, 'C');
            $this->Cell($w[3], 10, $value['qte_reste'], '', 0, 'C');
            $this->Cell($w[4], 10, number_format($value['mt_reste'],0,","," ").' FCFA', '', 0, 'C');
            $this->Cell($w[5], 10, number_format( $value['gain'],0,","," ").' FCFA', '', 0, 'C');
            $this->Ln();
            $fill = !$fill;
        }
    }

    public function bodyArticle(array $w,array $head,array $data = [])
    {

        // Largeurs des colonnes
        // En-tête
        $this->tHeader($head,$w);

        $this->setFont('Helvetica', '', 12);

        // Données

        $fill = false;
        $this->setFont('Times', '', 12);

        foreach ($data as $key => $value) {

            $this->Cell($w[0], 10, $value['libelle_article'], '', 0, 'C');
            $this->Cell($w[1], 10,  $value['slug'], '', 0, 'C');
            $this->Cell($w[2], 10, $value['famille'], '', 0, 'C');
            $this->Cell($w[3], 10, $value['mark'], '', 0, 'C');
            $this->Cell($w[4], 10, number_format($value['prix_article'],0,","," ").' FCFA', '', 0, 'C');
            $this->Ln();
            $fill = !$fill;
        }
    }



    // Section Employe
    function employer($data)
    {
        $head = ["CODE EMPLOYE", "NOM", "PRENOM", "TELEPHONE","FONCTION"];
        $w = array(40, 43, 43, 35, 30);


        $this->bodyEmploye( $w, $head, $data);
    }

    function client($data)
    {
        $head = ["CODE CLIENT", "NOM", "PRENOM", "TELEPHONE"];
        $w = array(45, 45, 45, 45);


        $this->bodyClient( $w, $head, $data);
    }

    function fournisseur($data)
    {
        $head = ["CODE FOURNISSEUR", "NOM & PRENOM", "TELEPHONE"];
        $w = array(55, 80, 55);
        $this->bodyFournisseur( $w, $head, $data);
    }

    function achat($data)
    {
        $head = ["CODE ACHAT", "NB ARTICLE", "MONTANT","CODE FOURNISSEUR","DATE ACHAT"];

        $w = array(55, 20, 45,20, 45, 25);
        $this->bodyAchat( $w, $head, $data);
    }

    function vente($data)
    {
        $head = ["CODE VENTE", "NB ARTICLE", "MONTANT","CODE CLIENT","DATE VENTE"];
        $w = array(55, 20, 45,20, 45, 25);
        $this->bodyVente( $w, $head, $data);
        $this->PageNo();
    }

    function inventaire($data)
    {
        $head = ["ARTICLE", "DEPENSES", "VENTES","QTE RESTE","MT RESTE","GAIN"];
        $w = array(36, 30, 45,12, 45, 25);
        $this->bodyInventaire( $w, $head, $data);
    }

    function article($data)
    {
        $head = ["ARTICLE", "REFERENCE", "FAMILLE","MARQUE","PRIX VENTE"];
        $w = array(45, 30, 45,30, 45);
        $this->bodyArticle( $w, $head, $data);
    }
   
}
