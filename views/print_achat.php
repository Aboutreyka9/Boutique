<?php
require '../vendor/autoload.php';
include '../models/Connexion.php';
include '../controllers/Soutra.php';

use Dompdf\Dompdf;

if (!isset($_GET['id'])) {
    http_response_code(400);
    exit("ID de achat manquant");
}

if (isset($_GET['statut'])) {
$statut =$_GET['statut']?? null;

}
// var_dump($statutLabel);return;

$achat = Soutra::singleAchat($_GET['id']);
$infoBoutique = Soutra::getInfoBoutique();
// var_dump($achat);return;
if (empty($achat)) {
    http_response_code(404);
    exit("achat non trouvée");
}

function generateProRecuHTML($infoBoutique, $achat) {
    $fournisseur = $achat[0];
    $total = array_sum(array_column($achat, 'prix_total'));
    $date = date('d/m/Y à H:i', strtotime($fournisseur['created_at']));

        $logoPath = !empty($infoBoutique['image']) 
        ? htmlspecialchars($infoBoutique['image'], ENT_QUOTES, 'UTF-8') 
        : '';

$image = file_get_contents($logoPath);
$logo = 'data:image/jpeg;base64,' . base64_encode($image);

    $html = '<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Facture - ' . htmlspecialchars($fournisseur['code_achat'], ENT_QUOTES, 'UTF-8') . '</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { 
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif; 
            font-size: 12px; 
            color: #222222; 
            line-height: 1.5;
            padding: 30px;
            margin-bottom: 100px;
        }
        .facture { 
            max-width: 700px; 
            margin: 0 auto; 
            border: 1px solid #d8d5d5;
            position: relative;
        }
        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-30deg);
            font-size: 120px;
            font-weight: bold;
            color: rgba(0, 0, 0, 0.06);
            white-space: nowrap;
            pointer-events: none;
            z-index: 0;
        }
        .watermark::before {
        
            content: "FACTURE";
        }
        .content { position: relative; z-index: 1; }
        .header { 
            padding: 20px;
            background: #f8f9fa;
        }
        .header-gauche { text-align: left; }
        .header-droite { text-align: right; }
        .header-gauche img { 
            max-height: 50px; 
        }
        .nom-boutique { 
            font-size: 18px; 
            font-weight: bold; 
            color: #1a1a1a;
            margin-bottom: 8px;
        }
        .coords { 
            font-size: 11px; 
            color: #555;
        }
        .info-facture { 
            display: flex; 
            justify-content: space-between;
            padding: 20px;
            border-bottom: 1px solid #ddd;
            margin-top: -12px;
        }
        .info-gauche, .info-droite { width: 48%; }
        .info-droite { text-align: right; }
        .info-droite div { margin: 3px 0; }
        .info-label { 
            font-weight: bold; 
            color: #555;
            display: inline-block;
            width: 100px;
        }
        .info-valeur { color: #222; }
        
        .articles { padding: 20px; }
        table { width: 100%; border-collapse: collapse; }
        thead th { 
            background: #b3b0b0;
            color: #fff;
            padding: 12px 10px;
            text-align: left;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        thead th:nth-child(2),
        thead th:nth-child(3),
        thead th:nth-child(4) { text-align: right; }
        tbody td { 
            padding: 12px 10px;
            border-bottom: 1px solid #eee;
        }
        tbody td:nth-child(2),
        tbody td:nth-child(3),
        tbody td:nth-child(4) { text-align: right; }
        
        .totaux { 
            padding: 20px;
            display: flex;
            justify-content: flex-end;
        }
        .totaux-table { width: 300px; }
        .totaux .ligne { 
            display: flex; 
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #eee;
        }
        .totaux .ligne:last-child { 
            border-bottom: 2px solid #e7e5e52e2;
            padding-top: 10px;
        }
        .totaux .libelle { font-weight: bold; color: #333; }
        .totaux .montant { font-weight: bold; }
        .totaux .total { font-size: 16px; color: #1a1a1a; }
        
        .footer {
            text-align: center; 
            padding: 20px;
            border-top: 1px solid #eeecec;
            background: #f8f9fa;

            position: fixed;
            bottom: 0;
            width: 100%;
            left:0;
            
        }
        .footer .merci { 
            font-size: 14px; 
            font-weight: bold; 
            color: #333;
            margin-bottom: 8px;
        }
        .footer .conseil { 
            font-size: 11px; 
            color: #777;
            margin-bottom: 10px;
        }
        .footer .contact { 
            font-size: 10px; 
            color: #999;
        }
        .barcode { 
            margin-top: 12px; 
            font-family: "Courier New", monospace;
            font-size: 11px;
            color: #666;
            letter-spacing: 2px;
        }
        
        @media print {
            body { padding: 0; }
            .facture { border: none; }
        }
    </style>
</head>
<body>
    <div class="facture">
        <div class="watermark"></div>
        <div class="content">
           
<div class="header">
    <table width="100%" style="border-collapse: collapse;">
        <tr>
            <!-- GAUCHE -->
            <td style="width: 65%; vertical-align: top;">
                <div class="nom-boutique">' . htmlspecialchars($infoBoutique['nom'] ?? 'MA BOUTIQUE', ENT_QUOTES, 'UTF-8') . '</div>
                
                <div class="coords">
                    ' . htmlspecialchars($infoBoutique['adresse'] ?? '', ENT_QUOTES, 'UTF-8') . '<br>
                    Tel: ' . htmlspecialchars($infoBoutique['contact1'] ?? '', ENT_QUOTES, 'UTF-8') . ' 
                    ' . (!empty($infoBoutique['contact2']) ? ' | ' . htmlspecialchars($infoBoutique['contact2'], ENT_QUOTES, 'UTF-8') : '') . '<br>
                    Email: ' . htmlspecialchars($infoBoutique['email'] ?? '', ENT_QUOTES, 'UTF-8') . '
                </div>

                ' . (!empty($logo) ? '<div style="margin-top:10px;"><img src="' . $logo . '" style="height:50px; widht:50px;"></div>' : '') . '
            </td>

            <!-- DROITE -->
            <td style="width: 35%; text-align: right; vertical-align: top;">
                <div style="font-size: 24px; font-weight: bold; margin-bottom: 10px;">FACTURE</div>

                <div>
                    <strong>N°:</strong> ' . htmlspecialchars($fournisseur['code_achat'], ENT_QUOTES, 'UTF-8') . '
                </div>

                <div>
                    <strong>Date:</strong> ' . $date . '
                </div>
            </td>
        </tr>
    </table>
</div>
            
         
<div class="info-facture">
    <table width="100%" style="border-collapse: collapse;">
        <tr>
            <!-- GAUCHE -->
            <td style="width: 50%; vertical-align: top; padding-right: 10px;">
                <div style="font-weight: bold; margin-bottom: 10px; color: #333; border-bottom: 1px solid #ddd; padding-bottom: 5px;">
                    INFORMATIONS FOURNISSEUR
                </div>

                <div><strong>Nom:</strong> ' . htmlspecialchars($fournisseur['nom_fournisseur'], ENT_QUOTES, 'UTF-8') . '</div>

                ' . (!empty($fournisseur['telephone_fournisseur']) ? '
                <div><strong>Téléphone:</strong> ' . htmlspecialchars($fournisseur['telephone_fournisseur'], ENT_QUOTES, 'UTF-8') . '</div>' : '') . '

                ' . (!empty($fournisseur['adresse_fournisseur']) ? '
                <div><strong>Adresse:</strong> ' . htmlspecialchars($fournisseur['adresse_fournisseur'], ENT_QUOTES, 'UTF-8') . '</div>' : '') . '
            </td>

            <!-- DROITE -->
            <td style="width: 50%; vertical-align: top; text-align: right; padding-left: 10px;">
                <div style="font-weight: bold; margin-bottom: 10px; color: #333; border-bottom: 1px solid #ddd; padding-bottom: 5px;">
                    MODE DE PAIEMENT
                </div>

                <div><strong>Mode:</strong> ' . htmlspecialchars($fournisseur['adresse_fournisseur'], ENT_QUOTES, 'UTF-8') . '</div>
            </td>
        </tr>
    </table>
</div>
            
            <div class="articles">
                <table>
                    <thead>
                        <tr>
                            <th>Article</th>
                            <th>Quantité</th>
                            <th>Prix Unitaire</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>';

    foreach ($achat as $item) {
        $html .= '<tr>
            <td>' . htmlspecialchars($item['libelle_article'], ENT_QUOTES, 'UTF-8') . '</td>
            <td>' . (int)$item['qte'] . '</td>
            <td>' . number_format($item['prix_achat'], 0, ",", " ") . ' Fcfa</td>
            <td>' . number_format($item['prix_total'], 0, ",", " ") . ' Fcfa</td>
        </tr>';
    }

    $html .= '</tbody>
                </table>
            </div>
            
            <div class="totaux">
                <div class="totaux-table">
                    <div class="ligne">
                        <span class="libelle">TOTAL À PAYER</span>
                        <span class="montant total">' . number_format($total, 0, ",", " ") . ' Fcfa</span>
                    </div>
                </div>
            </div>
            
            <div class="footer">
                <div class="merci">Merci pour votre confiance !</div>
                <div class="conseil">Veuillez conserver cette facture comme preuve d\'achat</div>
                <div class="contact">Pour toute question, contactez-nous au ' . htmlspecialchars($infoBoutique['contact1'] ?? '', ENT_QUOTES, 'UTF-8') . '</div>
                <div class="barcode">*** FACTURE N° ' . htmlspecialchars($fournisseur['code_achat'], ENT_QUOTES, 'UTF-8') . ' ***</div>
            </div>
        </div>
    </div>
</body>
</html>';

    return $html;
}

$html = generateProRecuHTML($infoBoutique, $achat);

$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("facture_" . $_GET['id'] . ".pdf", ["Attachment" => false]);