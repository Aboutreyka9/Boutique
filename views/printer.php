<?php 

require "../config/const.php";
include '../models/Connexion.php';
include '../controllers/Soutra.php';
include '../controllers/ControllerPrinter.php';

 $output = '
    <section style="margin:5em; display: flex;flex-direction: column;flex-wrap: nowrap;
    justify-content: center;align-items: center;align-content: center;" class="empty-state">
    <!-- .empty-state-container -->
    <div class="empty-state-container">
        <div class="state-figure">
        <img class="img-fluid" src="'. ASSETS.'images/illustration/img-2.png" alt="" style="max-width: 320px">
        </div>
        <h2 style="font-size:3em" class="state-header"> Page Not found! </h2>
        <p style="font-size:2em" class="state-description lead text-muted">Desolé cette page n\'existe pas. </p>
    </div>
</section>
    ';

if (isset($_GET['val']) && $_GET['val'] == 1234567890) {
    

   $page = $_GET['pg'];

   switch ($page) {
    case 'employe': 
    ControllerPrinter::listeEmploye();
    break;
    case 'client': 
    ControllerPrinter::listeClient();
    break;
    case 'fournisseur': 
    ControllerPrinter::listeFournisseur();
    break;
    case 'achat': 
    ControllerPrinter::listeAchat();
    break;
    case 'vente': 
    ControllerPrinter::listeVente();
    break;
    case 'inventaire':  
    ControllerPrinter::listeBilan();
    break;
    case 'article': 
    ControllerPrinter::listeArticle();
    break;  
    case 'hist_achat': 
    ControllerPrinter::listeArticleAchat();
    break;  
    case 'hist_vente': 
    ControllerPrinter::listeArticleVente();
    break;    
    default:
    http_response_code(400);

    //  echo $output; 
     break;
   }
    // ControllerPrinter::download();
}else{
   
    // echo $output;
    http_response_code(400);

}
