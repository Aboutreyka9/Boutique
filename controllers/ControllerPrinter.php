<?php
class ControllerPrinter extends Connexion{
    public static function download()
    {
        
        header("Content-Type:application/xls");
        header("Content-Disposition:attachment;filename=download.xls");
        
        $output = '';
        $output .= '
        <table>
    <tr>
      <th> CODE </th>
      <th> NOMBRE ARTICLE </th>
      <th> MONTANT </th>
      <th> FOURNISSEUR </th>
      <th> DATE </th>
    </tr>
        ';
        $achat = Soutra::getAllListeAchat();    
        
        foreach ($achat as $row) {

            $output .= '
            <tr>
               <td>' . $row['code_achat'] . '</td>
               <td>' . $row['article'] . '</td>
               <td>' .$row['total'] . '</td>
               <td>' . $row['code_fournisseur'] . '</td>
               <td>' . Soutra::date_format($row['created_at']) . '</td>
                </tr>
                ';
        }
        $output.= '
        </table>
        ';
        echo $output;
    }
    public static function listeEmploye()
    {
        
        $date = date('Ymdhis');
        header("Content-Type:application/vnd.ms-excel");
        header("Content-Disposition:attachment;filename=$date.xls");
        
        $output = '';
        $output .= '
        <table>
    <tr>
    <th> CODE-EMP </th>
    <th> NOM </th>
    <th> PRENOMS </th>
    <th> TELEPHONE </th>
    <th> FONCTION </th>
    </tr>
        ';
    $emp = Soutra::getAllEmployerToPrint();

        
        foreach ($emp as $row) {

            $output .= '
            <tr>
            <td>'. $row['code_employe'] . '</td>
            <td>' . $row['nom_employe'] . '</td>
            <td>' . $row['prenom_employe'] . '</td>
            <td>' . $row['telephone_employe'] . '</td>
            <td>' . $row['role']. '</td>
            </tr>
                ';
        }
        $output.= '
        </table>
        ';
        echo $output;
    }
    public static function listeFournisseur()
    {
        $date = date('Ymdhis');
        header("Content-Type:application/xls");
        header("Content-Disposition:attachment;filename=$date.xls");
        
        $output = '';
        $output .= '
        <table>
    <tr>
    <th> CODE FOURNISSEUR </th>
    <th> NOM & PRENOM</th>
    <th> TELEPHONE </th>
    <th> DATE ENREGISTRER </th>
    </tr>
        ';
        $fournisseur = Soutra::getAllFournisseur();    
        
        foreach ($fournisseur as $row) {

            $output .= '
            <tr>
               <td>' . $row['code_fournisseur'] . '</td>
               <td>' . $row['nom_fournisseur'] . '</td>
               <td>' .$row['telephone_fournisseur'] . '</td>
               <td>' . Soutra::date_format($row['created_at']) . '</td>
                </tr>
                ';
        }
        $output.= '
        </table>
        ';
        echo $output;
    }
    public static function listeClient()
    {
        $date = date('Ymdhis');
        header("Content-Type:application/xls");
        header("Content-Disposition:attachment;filename=$date.xls");
        
        $output = '';
        $output .= '
        <table>
    <tr>
    <th> CODE-CL </th>
    <th> NOM </th>
    <th> PRENOMS </th>
    <th> TELEPHONE </th>
    <th> DATE-ENR </th>
    </tr>
        ';
        $client = Soutra::getAllClient();    
        
        foreach ($client as $row) {

            $output .= '
            <tr>
            <td>' . $row['code_client'] . ' </td>
            <td>' . $row['nom_client'] . '</td>
            <td>' . $row['prenom_client'] . '</td>
            <td>' . $row['telephone_client'] . '</td>
            <td>' . Soutra::date_format($row['created_at']) . '</td>
                </tr>
                ';
        }
        $output.= '
        </table>
        ';
        echo $output;
    }
    public static function listeArticle()
    {
        $date = date('Ymdhis');
        header("Content-Type:application/xls");
        header("Content-Disposition:attachment;filename=$date.xls");
        
        $output = '';
        $output .= '
        <table>
    <tr>
    <th> LIBELLE </th>
    <th> SLUG </th>
    <th> FAMILLE </th>
    <th> MARK </th>
    <th> PRIX </th>
    </tr>
        ';
        $article = Soutra::getAllarticle();

        
        foreach ($article as $row) {

            $output .= '
            <tr>
            <td>' . $row['libelle_article'] . '</td>
            <td>' . $row['slug'] . '</td>
            <td>' . $row['famille'] . '</td>
            <td>' . $row['mark'] . '</td>
            <td>' . number_format($row['prix_article'],0,","," ") . '</td>
                </tr>
                ';
        }
        $output.= '
        </table>
        ';
        echo $output;
    }
    public static function listeAchat()
    {
        $date = date('Ymdhis');
        header("Content-Type:application/xls");
        header("Content-Disposition:attachment;filename=$date.xls");
        
        $output = '';
        $output .= '
        <table>
    <tr>
      <th> CODE </th>
      <th> NOMBRE ARTICLE </th>
      <th> MONTANT </th>
      <th> FOURNISSEUR </th>
      <th> DATE </th>
    </tr>
        ';
        $achat = Soutra::getAllListeAchat();    
        
        foreach ($achat as $row) {

            $output .= '
            <tr>
               <td>' . $row['code_achat'] . '</td>
               <td>' . $row['article'] . '</td>
               <td>' .$row['total'] . '</td>
               <td>' . $row['code_fournisseur'] . '</td>
               <td>' . Soutra::date_format($row['created_at']) . '</td>
                </tr>
                ';
        }
        $output.= '
        </table>
        ';
        echo $output;
    }
    public static function listeVente()
    {
        $date = date('Ymdhis');
        header("Content-Type:application/xls");
        header("Content-Disposition:attachment;filename=$date.xls");
        
        $output = '';
        $output .= '
        <table>
    <tr>
      <th> CODE </th>
      <th> NOMBRE ARTICLE </th>
      <th> MONTANT </th>
      <th> CLIENT </th>
      <th> CODE CLIENT </th>
      <th> DATE </th>
    </tr>
        ';
        $vente = Soutra::getAllListeVente();    
        
        foreach ($vente as $row) {

            $output .= '
            <tr>
            <td>' . $row['code_vente'] . '</td>
            <td>' . $row['article'] . '</td>
            <td>' . $row['total'] . '</td>
            <td>' . $row['nom_client'] .' '. $row['prenom_client'] .'</td>
            <td>'. $row['code_client'] .' </td>
            <td>' . Soutra::date_format($row['created_at']) . '</td>
                </tr>
                ';
        }
        $output.= '
        </table>
        ';
        echo $output;
    }
    public static function listeBilan()
    {
        $date = date('Ymdhis');
        header("Content-Type:application/xls");
        header("Content-Disposition:attachment;filename=$date.xls");
        
        $output = '';
        $output .= '
        <table>
    <tr>
    <th> ARTICLE </th>
    <th> DEPENSES (FCFA)</th>
    <th> VENTES (FCFA)</th>
    <th>QTE RESTE </th>
    <th> MTT RESTE (FCFA)</th>
    <th> GAIN (FCFA) </th>
    </tr>
        ';
        $inventaire = Soutra::getComptabiliteBilant();    
        
        foreach ($inventaire as $key => $row) {

            $output .= '
            <tr>
            <td>'. $row['article'] .'</td>
            <td>'. $row['depenses'] .'</td>
            <td>'. $row['ventes'] .'</td>
            <td>'. $row['qte_reste'].' </td>
            <td>'.  $row['mt_reste']  .' </td>
            <td>'.  $row['gain'] .' </td>
                </tr>
                ';
        }
        $output.= '
        </table>
        ';
        echo $output;
    }

    public static function listeArticleVente()
    {
        $date = date('Ymdhis');
        header("Content-Type:application/xls");
        header("Content-Disposition:attachment;filename=$date.xls");
        
        $output = '';
        $output .= '
        <table>
    <tr>
      <th> ARTICLE </th>
      <th> PRIX UNITAIRE (FCFA)</th>
      <th> QUANTITE </th>
      <th> TOTAL (FCFA)</th>
      <th>DATE VENTE</th>
    </tr>
        ';
        $historique = Soutra::getHistoriqueSortie();    
        
        foreach ($historique as $key => $row) {

            $output .= '
            <tr>
            <td>'. $row['article'] .'</td>
            <td>'. $row['prix_vente'].'</td>
            <td>'. $row['qte'] .'</td>
            <td>'. $row['qte']*$row['prix_vente'].'</td>
            <td>'. Soutra::date_format($row['d_vente']).' </td>
                </tr>
                ';
        }
        $output.= '
        </table>
        ';
        echo $output;
    }
    public static function listeArticleAchat()
    {
        $date = date('Ymdhis');
        header("Content-Type:application/xls");
        header("Content-Disposition:attachment;filename=$date.xls");
        
        $output = '';
        $output .= '
        <table>
    <tr>
    <th> ARTICLE</th>
    <th> PRIX UNITAIRE (FCFA)</th>
    <th> QUANTITE </th>
    <th> TOTAL (FCFA)</th>
    <th>DATE ACHAT</th>
    </tr>
        ';
        $inventaire = Soutra::getHistoriqueEntree();    
        
        foreach ($inventaire as $key => $row) {

            $output .= '
            <tr>
            <td>'. $row['article'] .'</td>
            <td>'. $row['prix_achat'] .'</td>
            <td>'. $row['qte'] .'</td>
            <td>'. $row['qte']*$row['prix_achat'] .'</td>
            <td>'. Soutra::date_format($row['d_achat']).' </td>
                </tr>
                ';
        }
        $output.= '
        </table>
        ';
        echo $output;
    }
    
}