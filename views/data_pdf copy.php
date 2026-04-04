<?php 
require '../fpdf/list_data.php';
include '../models/Connexion.php';
include '../controllers/Soutra.php';

    // $prod = "";
    // $ref = "";
    // $prod = Soutra::singleVente($_GET['id']);

    if (isset($_GET['pg']) && !empty($_GET['pg'])) {

       $page= $_GET['pg'];

        // if(isset($_GET['f']) && $_GET['f']  == 'p5'){
            $print = new ListeData("p", "mm", "A4");
            // $w = array(45, 24, 20, 39);

                $print->addPage();
                $print->setTextColor(0, 0, 0);
                // $print->docBody($w,$prod);
                // $print->output('',date('YmdHis').'.pdf');
        // }

        switch ($page) {
            case 'employes':
                // var_dump("employe");
                $employe = Soutra::getAllEmployerToPrint();

                $print->pageTitle("LISTE DES EMPLOYES");
                $print->employer($employe);
                $print->output('',date('YmdHis').'.pdf',true);

                break;
                case 'clients':
                $client = Soutra::getAllClient();
                
                $print->pageTitle("LISTE DES CLIENTS");
                $print->client($client);
                $print->output('',date('YmdHis').'.pdf',true);
                break;
                case 'fournisseurs':
                $fournisseur = Soutra::getAllFournisseur();
                $print->pageTitle("LISTE DES FOURNISSEURS");
                $print->fournisseur($fournisseur);
                $print->output('',date('YmdHis').'.pdf',true);
                break;
                case 'ventes':
                    $vente = Soutra::getAllListeVente();
                    $print->pageTitle("LISTE DES VENTES");
                    $print->vente($vente);
                    $print->output('',date('YmdHis').'.pdf',true);
                break;
                case 'achats':
                    $achat = Soutra::getAllListeAchat();
                    $print->pageTitle("LISTE DES ACHATS");
                    $print->achat($achat);
                    $print->output('',date('YmdHis').'.pdf',true);
                break;
                case 'bilan':
                    $inventaire = Soutra::getComptabiliteBilant();
                    $print->pageTitle("LISTE DES RAPPORTS");
                    $print->inventaire($inventaire);
                    $print->output('',date('YmdHis').'.pdf',true);
                break;
                case 'articles':
                    $article = Soutra::getAllarticle();
                    $print->pageTitle("LISTE DES ARTICLES");
                    $print->article($article);
                    $print->output('',date('YmdHis').'.pdf',true);
                break;
            
            default:
        http_response_code(400);
                
                break;
        }
        
    }else{
        http_response_code(400);
    }
 ?>
<?php 
require '../fpdf/list_data.php';
include '../models/Connexion.php';
include '../controllers/Soutra.php';

    // $prod = "";
    // $ref = "";
    // $prod = Soutra::singleVente($_GET['id']);

    if (isset($_GET['pg']) && !empty($_GET['pg'])) {

       $page= $_GET['pg'];

        // if(isset($_GET['f']) && $_GET['f']  == 'p5'){
            $print = new ListeData("p", "mm", "A4");
            // $w = array(45, 24, 20, 39);

                $print->addPage();
                $print->setTextColor(0, 0, 0);
                // $print->docBody($w,$prod);
                // $print->output('',date('YmdHis').'.pdf');
        // }

        switch ($page) {
            case 'employes':
                // var_dump("employe");
                $employe = Soutra::getAllEmployerToPrint();

                $print->pageTitle("LISTE DES EMPLOYES");
                $print->employer($employe);
                $print->output('',date('YmdHis').'.pdf',true);

                break;
                case 'clients':
                $client = Soutra::getAllClient();
                
                $print->pageTitle("LISTE DES CLIENTS");
                $print->client($client);
                $print->output('',date('YmdHis').'.pdf',true);
                break;
                case 'fournisseurs':
                $fournisseur = Soutra::getAllFournisseur();
                $print->pageTitle("LISTE DES FOURNISSEURS");
                $print->fournisseur($fournisseur);
                $print->output('',date('YmdHis').'.pdf',true);
                break;
                case 'ventes':
                    $vente = Soutra::getAllListeVente();
                    $print->pageTitle("LISTE DES VENTES");
                    $print->vente($vente);
                    $print->output('',date('YmdHis').'.pdf',true);
                break;
                case 'achats':
                    $achat = Soutra::getAllListeAchat();
                    $print->pageTitle("LISTE DES ACHATS");
                    $print->achat($achat);
                    $print->output('',date('YmdHis').'.pdf',true);
                break;
                case 'bilan':
                    $inventaire = Soutra::getComptabiliteBilant();
                    $print->pageTitle("LISTE DES RAPPORTS");
                    $print->inventaire($inventaire);
                    $print->output('',date('YmdHis').'.pdf',true);
                break;
                case 'articles':
                    $article = Soutra::getAllarticle();
                    $print->pageTitle("LISTE DES ARTICLES");
                    $print->article($article);
                    $print->output('',date('YmdHis').'.pdf',true);
                break;
            
            default:
        http_response_code(400);
                
                break;
        }
        
    }else{
        http_response_code(400);
    }
 ?>