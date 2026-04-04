
<?php 
require '../fpdf/list_data.php';
include '../models/Connexion.php';
include '../controllers/Soutra.php';
use Dompdf\Dompdf;

if (isset($_GET['pg']) && !empty($_GET['pg'])) {

$dompdf = new Dompdf();

$page= $_GET['pg'];

        // if(isset($_GET['f']) && $_GET['f']  == 'p5'){
            $print = new ListeData("p", "mm", "A4");
            // $w = array(45, 24, 20, 39);

                // $print->addPage();
                // $print->setTextColor(0, 0, 0);
                // $print->docBody($w,$prod);
                // $print->output('',date('YmdHis').'.pdf');
        // }

        switch ($page) {
            case 'employes':
                $employe = Soutra::getAllEmployerToPrint();

                  
                // Exemple dynamique (employes)
                $title = "LISTE DES EMPLOYES";
                $headers = ["CODE EMPLOYE", "NOM", "PRENOM", "TELEPHONE", "ROLE"];
                $data = Soutra::getAllEmployerToPrint();

                $rows = array_map(function($c){
                    return [
                        $c['code_employe'],
                        $c['nom_employe'],
                        $c['prenom_employe'],
                        $c['telephone_employe'],
                        $c['role']
                    ];
                }, $data);

                $html = $print->generateHTMLList($title, $headers, $rows);

                $dompdf->loadHtml($html);
                $dompdf->setPaper('A4', 'portrait');
                $dompdf->render();
                $dompdf->stream("employe.pdf", ["Attachment" => false]); // false pour afficher dans le navigateur

                break;
                case 'clients':
                                    
                // Exemple dynamique (clients)
                $title = "LISTE DES CLIENTS";
                $headers = ["CODE CLIENT", "NOM", "PRENOM", "TELEPHONE"];
                $data = Soutra::getAllClient();

                $rows = array_map(function($c){
                    return [
                        $c['code_client'],
                        $c['nom_client'],
                        $c['prenom_client'],
                        $c['telephone_client']
                    ];
                }, $data);

                $html = $print->generateHTMLList($title, $headers, $rows);

                $dompdf->loadHtml($html);
                $dompdf->setPaper('A4', 'portrait');
                $dompdf->render();
                $dompdf->stream("clients.pdf", ["Attachment" => false]); // false pour afficher dans le navigateur



                break;
                case 'fournisseurs':
                $fournisseur = Soutra::getAllFournisseur();
                                  
                // Exemple dynamique (fournisseurs)
                $title = "LISTE DES FOURNISSEURS";
                $headers = ["CODE FOURNISSEUR", "NOM", "PRENOM", "TELEPHONE"];
                $data = Soutra::getAllFournisseur();

                $rows = array_map(function($c){
                    return [
                        $c['code_fournisseur'],
                        $c['nom_fournisseur'],
                        $c['prenom_fournisseur'],
                        $c['telephone_fournisseur']
                    ];
                }, $data);

                $html = $print->generateHTMLList($title, $headers, $rows);

                $dompdf->loadHtml($html);
                $dompdf->setPaper('A4', 'portrait');
                $dompdf->render();
                $dompdf->stream("fournisseur.pdf", ["Attachment" => false]); // false pour afficher dans le navigateur

                break;
                case 'ventes':
                                      
                // Exemple dynamique (ventes)
                $title = "LISTE DES VENTES";
                $headers = ["CODE VENTE", "ARTICLE","TOTAL", "CODE CLIENT", "DATE"];
                $data = Soutra::getAllListeVente();

                $rows = array_map(function($c){
                    return [
                        $c['code_vente'],
                        $c['article'],
                        $c['total'],
                        $c['code_client'],
                        $c['created_at']
                    ];
                }, $data);

                $html = $print->generateHTMLList($title, $headers, $rows);

                $dompdf->loadHtml($html);
                $dompdf->setPaper('A4', 'portrait');
                $dompdf->render();
                $dompdf->stream("ventes.pdf", ["Attachment" => false]); // false pour afficher dans le navigateur

                break;
                case 'achats':
                // Exemple dynamique (achats)
                $title = "LISTE DES ACHATS";
                $headers = ["CODE ACHAT", "ARTICLE","TOTAL", "CODE FOURNISSEUR"];
                $data = Soutra::getAllListeAchat();
                $rows = array_map(function($c){
                    return [
                        $c['code_achat'],
                        $c['article'],
                        $c['total'],
                        $c['code_fournisseur'],
                    ];
                }, $data);

                $html = $print->generateHTMLList($title, $headers, $rows);

                $dompdf->loadHtml($html);
                $dompdf->setPaper('A4', 'portrait');
                $dompdf->render();
                $dompdf->stream("achats.pdf", ["Attachment" => false]); // false pour afficher dans le navigateur

                break;
                case 'bilan':
                    $inventaire = Soutra::getComptabiliteBilant();
                // Exemple dynamique (bilan)
                $title = "BILAN";
                $headers = ["ARTICLES", "DEPENSES", "VENTES", "QTE REST", "M. REST", "GAIN"];
                $data = Soutra::getComptabiliteBilant();
                $rows = array_map(function($c){
                    return [
                        $c['article'],
                        $c['depenses'],
                        $c['ventes'],
                        $c['qte_reste'],
                        $c['mt_reste'],
                        $c['gain']
                    ];
                }, $data);

                $html = $print->generateHTMLList($title, $headers, $rows);

                $dompdf->loadHtml($html);
                $dompdf->setPaper('A4', 'portrait');
                $dompdf->render();
                $dompdf->stream("bilan.pdf", ["Attachment" => false]); // false pour afficher dans le navigateur

                break;
                case 'articles':
                    $data = Soutra::getAllarticle();
                    // var_dump($data);return;
                // Exemple dynamique (articles)
                $title = "ARTICLES";
                $headers = ["CODE", "DESIGNATION", "FAMILLE", "MARQUE", "ENTREPOT"];
                $rows = array_map(function($c){
                    return [
                        $c['code_article'],
                        $c['libelle_article'],
                        $c['famille'],
                        $c['mark'],
                        $c['entrepot']
                    ];
                }, $data);

                $html = $print->generateHTMLList($title, $headers, $rows);

                $dompdf->loadHtml($html);
                $dompdf->setPaper('A4', 'portrait');
                $dompdf->render();
                $dompdf->stream("articles.pdf", ["Attachment" => false]); // false pour afficher dans le navigateur

                break;
            
            default:
        http_response_code(400);
                
                break;
        }
        
    }else{
        http_response_code(400);
    }




 ?>