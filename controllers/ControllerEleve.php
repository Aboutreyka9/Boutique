<?php

class ControllerEleve {


    public static function save_eleve1() {

        if (isset($_POST['save_eleve1'])) {
            $output = 0;
            $_SESSION['eleve']=[];
            extract($_POST);

            if (empty($statut_eleve)) {
                $output = 'Veuillez choisir une statut';
            } elseif (empty($qualite_eleve)) {
                $output = 'Veuillez choisir type qualite';
            }  elseif (empty($mat_eleve)) {
                $output = 'Veuillez entrer le matricule';
            } 
            elseif (empty($nom_eleve)) {
                $output = 'Veuillez entrer le  nom';
            }
            elseif (empty($prenom_eleve)) {
                $output = 'Veuillez entrer le  prenom';
            }
            elseif (empty($sexe_eleve)) {
                $output = 'Veuillez choisir le sexe';
            }
            elseif (empty($date_naiss)) {
                $output = 'Veuillez entrer le  date de naissance';
            }
            elseif (empty($lieu_naiss)) {
                $output = 'Veuillez entrer le  lieu de naissance';
            }
            elseif (empty($annee_sco)) {
                $output = 'Veuillez choisir l\'annéee scolaire';
            }else{
                
                if (!empty($tel_eleve) && !empty(Soutra::libelleExiste('eleve','tel_eleve',$tel_eleve)) ){
                    $output = "Désolé le numero existe déjà";
                }elseif(Soutra::libelleExiste('eleve','mat_eleve',$mat_eleve)){
                    $output = "Désolé ce matricule existe déjà";
                }
                else{ 
                $_SESSION['eleve']= $_POST;
                $output = 1;
                }
            }

            // echo $nom;
            echo $output;
         }
        }

        public static function save_eleve2() {

            if (isset($_POST['save_eleve2'])) {
                $output = 0;
                $_SESSION['parent'] = [];
                extract($_POST);
    
                if (empty($nom_pere)) {
                    $output = '<strong style="color:red;text-align:center">Veuillez entrer le nom du père</strong>';
                } elseif (empty($nom_mere)) {
                    $output = '<strong style="color:red;text-align:center">Veuillez entrer le nom de la mère</strong>';
                } 
               else{

                $_SESSION['parent']=$_POST;
                    // $_SESSION['eleve'][]= $_POST;
                    $output = 1;
                }
                echo $output;
             }
            }

    public static function btn_modifier_dossier() {

        if (isset($_POST['btn_modifier_dossier'])) {

            $output = 0;
            extract($_POST);
            
            $data_dossier = [
                'extrait' => $extrait,
                'livret' => $livret,
                'carnet' => $carnet,
                'fiche_inscrire' => $fiche_inscrire,
                'photo' => $photo,
                'bulletin' => $bulletin,
                'fiche_trans' => $fiche_trans,
                'chemise' => $chemise,
                'ID_inscrire' => $ID_inscrire,
            ];

            if (Soutra::update('dossier',$data_dossier)) { 
                $output = "Insertion pro";
            }else { 
                $output = "Echec popo";
                
            }
            
            echo $output;
            }
        }
            
    public static function btn_inscription() {
        if (isset($_POST['inscrire_eleve'])) {
            date_default_timezone_set('Africa/Abidjan');
            $eleve =$_SESSION['eleve'];
            $parent =$_SESSION['parent'];
            //$ran = rand(1000, 9000);
            $dataEleve = array(
                'nom_eleve' => strtoupper(htmlspecialchars(trim($eleve['nom_eleve']))),
                'prenom_eleve' => strtoupper(htmlspecialchars(trim($eleve['prenom_eleve']))),
                'mat_eleve' => strtoupper(htmlspecialchars(trim($eleve['mat_eleve']))),
                'date_naiss' => $eleve['date_naiss'],
                'lieu_naiss' => htmlspecialchars(trim(ucfirst($eleve['lieu_naiss']))),
                'sexe_eleve' => $eleve['sexe_eleve'],
                'tel_eleve' => $eleve['tel_eleve'],
                'email_eleve' => $eleve['email_eleve'],
                'statut_eleve' => $eleve['statut_eleve'],
                'qualite_eleve' => $eleve['qualite_eleve'],
                'nom_pere' => strtoupper(htmlspecialchars(trim($parent['nom_pere']))),
                'tel_pere' => htmlspecialchars(trim($parent['tel_pere'])),
                'nom_mere' => strtoupper(htmlspecialchars(trim($parent['nom_mere']))),
                'tel_mere' => htmlspecialchars(trim($parent['tel_mere'])),
            );
            // unset($_SESSION['eleve'],$_SESSION['parent']);

    if (Soutra::insert('eleve', $dataEleve)) {
        $ID_eleve = Soutra::lastInsertId();
        $code = substr(date('Y'), 2).'-'.date("dHis") .'-'.'ECO';

        $dataInscrire = array(
            'ID_inscrire'=>$code,
            'ID_classe'=>$_POST['classe'],
            'ID_eleve'=>$ID_eleve,
            'ID_annee'=>$eleve['annee_sco'],
            'montant_inscrire'=>$_POST['montant'],
            'date_inscrire'=> date('Y-m-d H:i:s')
        );

        if (Soutra::insert('inscrire', $dataInscrire)) {
            $dataVersement = array(
                'montant_versement'=>0,
                'ID_inscrire'=>$code,
                'ID_employe'=>$_SESSION['ISPWB'],
                'date_versement'=> date('Y-m-d H:i:s')
            );

            if (Soutra::insert('versement', $dataVersement)) {
                Soutra::insert('dossier', ['ID_inscrire' => $code]);
            unset($_SESSION['eleve'],$_SESSION['parent']);

                echo '1blo'.$code.'blo<strong  class="alert alert-success">Numero d\'inscription : '.$code.'</strong >';
            }else{
                echo '2blo<strong  class="alert alert-danger">Erreur table Versement !</strong >';
            }
        }else{
            echo '2blo<strong  class="alert alert-danger">Erreur table inscrire !</strong >';
        } 
    }else{
        echo '2blo<strong  class="alert alert-danger">Erreur table Elève !</strong >';
    }




            
        }
    }

    public static function liste_eleve_by_classe_bulletin() {
        if (isset($_POST['liste_eleve_by_classe_bulletin'])) {
            $niveau = $_POST['niveau_b'];
            $annee = $_POST['annee_b'];
            $classe = $_POST['classe_b'];
            $semestre = $_POST['semestre_b'];
            $output = '';

            if (empty($annee)) {
                $output = '<strong style="color:red;text-align:center">Veuillez choisir une année academique</strong>';
            } elseif (empty($niveau)) {
                $output = '<strong style="color:red;text-align:center">Veuillez choisir un niveau</strong>';
            } elseif (empty($classe)) {
                $output = '<strong style="color:red;text-align:center">Veuillez choisir une classe</strong>';
            } else {
                if (empty(Soutra::getAllByItem6("eleve", "inscrire", "ID_eleve", "ID_eleve", "ID_annee", "ID_classe", $annee, $classe))) {
                    $output = '<strong style="color:red;text-align:center">Pas d\'inscrit dans cette classe pour l\'année academique ' . (Soutra::libelle("annee", "libelle_annee", "ID_annee", $annee) - 1) . '-' . Soutra::libelle("annee", "libelle_annee", "ID_annee", $annee
                            ) . ' !</strong>';
                } else {
                    $output = '<div class="panel">
                      <h5>Filière : ' . Soutra::libelle("filiere", "libelle_filiere", "ID_filiere", Soutra::libelle("classe", "ID_filiere", "ID_classe", $classe
                            )) . ' <i class="fa fa-arrow-right"></i> Classe : ' . Soutra::libelle("classe", "libelle_classe", "ID_classe", $classe
                            ) . '</h5>';
                    $output .= '<hr>
                        
                        <div class="panel-body table-responsive">
                            <table class="table table-hover table-striped" id="">
                                <thead>
                                <tr>
                                    <th>Numero Ins</th>
                                    <th>Nom et prénoms</th>';
                    $output .= ' 
                                                <th>Date naissance</th>
                                                <th>Lieu naissance</th>
                                                <th>Statut</th>';
                    $output .= '<th>Actions</th>';


                    $output .= '</tr></thead><tbody>';
                    foreach (Soutra::getAllByItem6("eleve", "inscrire", "ID_eleve", "ID_eleve", "ID_annee", "ID_classe", $annee, $classe) as $row) {

                        $output .= '
                            <tr>
                            <td>' . $row['ID_inscrire'] . '</td>
                            <td>' . $row['nom_eleve'] . ' ' . $row['prenom_eleve'] . '</td>';
                        $output .= '
                                    <td>' . $row['date_naiss'] . '</td>
                                    <td>' . $row['lieu_naiss'] . '</td>
                                    <td>' . $row['statut_eleve'] . '</td>
                                ';

                        $output .= ' <td>
                                <button ID_an="'.$annee.'" ID="' . $row['ID_eleve'] . '" semestre="' . $semestre . '" class="btn btn-info btn-sm btn_tirer_bulletin">
                                    <i class="fa fa-print"></i> Tirer bulletin
                                </button>
                            </td>';
                        $output .= ' </tr>
                        ';
                    }
                    $output .= '</tbody></table></div></div>';
                }
            }
            echo $output;
        }
    }

    public static function liste_eleve_by_classe_bulletin_rech() {
        if (isset($_POST['liste_eleve_by_classe_bulletin_rech'])) {
            $niveau = $_POST['niveau_b'];
            $annee = $_POST['annee_b'];
            $classe = $_POST['classe_b'];
            $semestre = $_POST['semestre_b'];
            $search = $_POST['search_b'];
            $output = '';

            if (empty($annee)) {
                $output = '<strong style="color:red;text-align:center">Veuillez choisir une année academique</strong>';
            } elseif (empty($niveau)) {
                $output = '<strong style="color:red;text-align:center">Veuillez choisir un niveau</strong>';
            } elseif (empty($classe)) {
                $output = '<strong style="color:red;text-align:center">Veuillez choisir une classe</strong>';
            } else {
                if (empty(Soutra::getAllByItem7("eleve", "inscrire", "ID_eleve", "ID_eleve", "ID_annee", "ID_classe", $annee, $classe, $search))) {
                    $output = '<strong style="color:red;text-align:center">Pas d\'inscrit dans cette classe pour l\'année academique ' . (Soutra::libelle("annee", "libelle_annee", "ID_annee", $annee) - 1) . '-' . Soutra::libelle("annee", "libelle_annee", "ID_annee", $annee
                            ) . ' !</strong>';
                } else {
                    $output = '<div class="panel">
                      <h5>Filière : ' . Soutra::libelle("filiere", "libelle_filiere", "ID_filiere", Soutra::libelle("classe", "ID_filiere", "ID_classe", $classe
                            )) . ' <i class="fa fa-arrow-right"></i> Classe : ' . Soutra::libelle("classe", "libelle_classe", "ID_classe", $classe
                            ) . '</h5>';
                    $output .= '<hr>
                        
                        <div class="panel-body table-responsive">
                            <table class="table table-hover table-striped" id="">
                                <thead>
                                <tr>
                                    <th>Numero Ins</th>
                                    <th>Nom et prénoms</th>';
                    $output .= ' 
                                                <th>Date naissance</th>
                                                <th>Lieu naissance</th>
                                                <th>Statut</th>';
                    $output .= '<th>Actions</th>';


                    $output .= '</tr></thead><tbody>';
                    foreach (Soutra::getAllByItem7("eleve", "inscrire", "ID_eleve", "ID_eleve", "ID_annee", "ID_classe", $annee, $classe, $search) as $row) {

                        $output .= '
                            <tr>
                            <td>' . $row['ID_inscrire'] . '</td>
                            <td>' . $row['nom_eleve'] . ' ' . $row['prenom_eleve'] . '</td>';
                        $output .= '
                                    <td>' . $row['date_naiss'] . '</td>
                                    <td>' . $row['lieu_naiss'] . '</td>
                                    <td>' . $row['statut_eleve'] . '</td>
                                ';

                        $output .= ' <td>
                                <button  ID_an="'.$annee.'" ID="' . $row['ID_eleve'] . '" semestre="' . $semestre . '" class="btn btn-info btn-sm btn_tirer_bulletin">
                                    <i class="fa fa-print"></i> Tirer bulletin
                                </button>
                            </td>';
                        $output .= ' </tr>
                        ';
                    }
                    $output .= '</tbody></table></div></div>';
                }
            }
            echo $output;
        }
    }

    public static function liste_eleve_by_classe_rein() {
        if (isset($_POST['liste_eleve_by_classe_rein'])) {
            $niveau = $_POST['niveau_b'];
            $annee = $_POST['annee_b'];
            $classe = $_POST['classe_b'];
            $output = '';

            if (empty($annee)) {
                $output = '<strong style="color:red;text-align:center">Veuillez choisir une année academique</strong>';
            } elseif (empty($niveau)) {
                $output = '<strong style="color:red;text-align:center">Veuillez choisir un niveau</strong>';
            } elseif (empty($classe)) {
                $output = '<strong style="color:red;text-align:center">Veuillez choisir une classe</strong>';
            } else {
                if (empty(Soutra::getAllByItem6("eleve", "inscrire", "ID_eleve", "ID_eleve", "ID_annee", "ID_classe", $annee, $classe))) {
                    $output = '<strong style="color:red;text-align:center">Pas d\'inscrit dans cette classe pour l\'année academique ' . (Soutra::libelle("annee", "libelle_annee", "ID_annee", $annee) - 1) . '-' . Soutra::libelle("annee", "libelle_annee", "ID_annee", $annee
                            ) . ' !</strong>';
                } else {
                    $output = '<div class="panel">
                      <h5>Filière : ' . Soutra::libelle("filiere", "libelle_filiere", "ID_filiere", Soutra::libelle("classe", "ID_filiere", "ID_classe", $classe
                            )) . ' <i class="fa fa-arrow-right"></i> Classe : ' . Soutra::libelle("classe", "libelle_classe", "ID_classe", $classe
                            ) . '';
                    if ($_SESSION["IDTYPE"] == 6)
                        $output .= '<a href="#" classe="' . $classe . '" annee="' . $annee . '" title="Exporter la liste de classe" class="btn btn-ligth liste_classe_pdf"> <i class="fa fa-file-pdf-o"></i> Exporter en pdf</a></h5>';
                    elseif ($_SESSION["IDTYPE"] == 5)
                        $output .= '<a href="#" classe="' . $classe . '" annee="' . $annee . '" title="Exporter la liste de classe" class="btn btn-ligth liste_classe_pdf"> <i class="fa fa-file-pdf-o"></i> Exporter en pdf</a></h5>';
                    else
                        $output .= '<a href="#" classe="' . $classe . '" annee="' . $annee . '" title="Exporter la liste de classe" class="btn btn-ligth liste_classe_pdf"> <i class="fa fa-file-pdf-o"></i> Exporter en pdf</a></h5>';
                    $output .= '<hr>
                        
                        <div class="panel-body table-responsive">
                            <table class="table table-hover table-striped" id="liste_client">
                            <thead>
                                <tr>
                                    <th>N°</th>
                                    <th>Nom et prénoms</th>
                                    <th>Date naissance</th>
                                    <th>Lieu naissance</th>
                                    <th>Statut</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>';
                    $i = 0;
                    foreach (Soutra::getAllByItem6("eleve", "inscrire", "ID_eleve", "ID_eleve", "ID_annee", "ID_classe", $annee, $classe) as $row) {
                        $i++;
                        $output .= '
                        <tr>
                            <td>' . $i . '</td>
                            <td>' . $row['nom_eleve'] . ' ' . $row['prenom_eleve'] . '</td>
                            <td>' . $row['date_naiss'] . '</td>
                            <td>' . $row['lieu_naiss'] . '</td>
                            <td>' . $row['statut_eleve'] . '</td>
                            <td>
                                <button ID="' . $row['ID_eleve'] . '" NOM="' . $row['nom_eleve'] . ' ' . $row['prenom_eleve'] . '" class="btn btn-info btn-sm btn_rein_eleve">
                                    <i class="fa fa-refresh"></i> Reinscrire
                                </button>
                            </td>
                        </tr>
                        ';
                    }
                    $output .= '</tbody></table></div></div>';
                }
            }
            echo $output;
        }
    }

    public static function liste_eleve_by_classe() {
        if (isset($_POST['liste_eleve_by_classe'])) {
            $niveau = $_POST['niveau_b'];
            $annee = $_POST['annee_b'];
            $classe = $_POST['classe_b'];
            $output = '';

            if (empty($annee)) {
                $output = '<strong style="color:red;text-align:center">Veuillez choisir une année academique</strong>';
            } elseif (empty($niveau)) {
                $output = '<strong style="color:red;text-align:center">Veuillez choisir un niveau</strong>';
            } elseif (empty($classe)) {
                $output = '<strong style="color:red;text-align:center">Veuillez choisir une classe</strong>';
            } else {
                $infos = Soutra::getEleveClasseNiveau($classe,$niveau,$annee);
                $en_cour = Soutra::libelle("annee", "libelle_annee", "ID_annee", $annee);

                if (empty($infos)) {
                    $output = '<strong style="color:red;text-align:center">Pas d\'inscrit dans cette classe pour l\'année academique ' . ($en_cour - 1) . '-' . $en_cour . ' !</strong>';
                } else {
                    $output = '<div class="row outer_ins">
            <div class="col-md-12 inner_ins">
            <div class="panel">
                <div class="panel-body table-responsive element">
                    <table class="table table-hover table-sm table-striped" id="">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Matricule</th>
                                <th>Date-ins</th>
                                <th>Nom et prénoms</th>
                                <th>Classe</th>
                                <th>Date-Nais</th>
                                <th>Qualité</th>
                                <th>Statut</th>
                                <th>Option</th>
                            <tr/>
                        <thead>
                        <tbody>';
                            $i = 0;
                             foreach ($infos as $row){ 
                                $i++;
                                
                            $date_inscrire = new DateTime($row['date_inscrire']);
                            $date_naiss = new DateTime($row['date_naiss']);

                    $output .= '
                    <tr>
                        <td>' . $i . '</td>
                        <td>' . $row['mat_eleve'] . '</td>
                        <td>' . $date_inscrire->format('d/m/Y') . '</td>
                        <td>' . $row['nom_eleve'].' '.$row['prenom_eleve'] . '</td>
                        <td>' . $row['libelle_classe'] . '</td>
                        <td>' . $date_naiss->format('d/m/Y') . '</td>
                        <td>' . $row['qualite_eleve'] . '
                        <td>' . $row['statut_eleve'] . '
                    </td>';
                         $output .= ' <td>
                         <a href="home.php?pg=info/&pl=341be97d9aff90c9978347f66f945b77&hg=97650b0da4e13c8f577cd67e0b73a78f&el='.$row['ID_eleve'].'&hg=97650b0da4e13c8f577cd67e0b73a78f&ip=254lkhfdtdfdgffyghfgseqr35gf/" ID="' . $row['ID_eleve'] . '" IDC="' . $row['ID_classe'] . '" IDINS="' . $row['ID_inscrire'] . '" class="btn btn-info btn-sm btn_frm_modifier_eleve">
                         <i class="fa fa-eye"></i> Info
                     </a>
                            <button ID="' . $row['ID_eleve'] . '" class="btn btn-danger btn-sm btn_supprimer_eleve">
                                <i class="fa fa-trash"></i> Supprimer
                            </button>
                            
                        </td>
                    </tr>';

             } 

        $output .= '</tbody>
                </table>
            </div>
        </div>
    </div>
</div>';


                }
            }
            echo $output;
        }
    }

    public static function liste_eleve_versement() {
        if (isset($_POST['liste_eleve_by_classe'])) {
            $niveau = $_POST['niveau_b'];
            $annee = $_POST['annee_b'];
            $classe = $_POST['classe_b'];
            $output = '';

            if (empty($annee)) {
                $output = '<strong style="color:red;text-align:center">Veuillez choisir une année academique</strong>';
            } elseif (empty($niveau)) {
                $output = '<strong style="color:red;text-align:center">Veuillez choisir un niveau</strong>';
            } elseif (empty($classe)) {
                $output = '<strong style="color:red;text-align:center">Veuillez choisir une classe</strong>';
            } else {
                $infos = Soutra::getEleveClasseNiveau($classe,$niveau,$annee);
                $en_cour = Soutra::libelle("annee", "libelle_annee", "ID_annee", $annee);

                if (empty($infos)) {
                    $output = '<strong style="color:red;text-align:center">Pas d\'inscrit dans cette classe pour l\'année academique ' . ($en_cour - 1) . '-' . $en_cour . ' !</strong>';
                } else {
                    $output = '<div class="row outer_ins">
            <div class="col-md-12 inner_ins">
            <div class="panel">
                <div class="panel-body table-responsive element">
                    <table class="table table-hover table-sm table-striped" id="liste_client">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Matricule</th>
                                <th>Date-ins</th>
                                <th>Nom et prénoms</th>
                                <th>Classe</th>
                                <th>Date-Nais</th>
                                <th>Qualité</th>
                                <th>Statut</th>
                                <th>Option</th>
                            <tr/>
                        <thead>
                        <tbody>';
                            $i = 0;
                             foreach ($infos as $row){ 
                                $i++;
                                
                            $date_inscrire = new DateTime($row['date_inscrire']);
                            $date_naiss = new DateTime($row['date_naiss']);

                    $output .= '
                    <tr>
                        <td>' . $i . '</td>
                        <td>' . $row['mat_eleve'] . '</td>
                        <td>' . $date_inscrire->format('d/m/Y') . '</td>
                        <td>' . $row['nom_eleve'].' '.$row['prenom_eleve'] . '</td>
                        <td>' . $row['libelle_classe'] . '</td>
                        <td>' . $date_naiss->format('d/m/Y') . '</td>
                        <td>' . $row['qualite_eleve'] . '
                        <td>' . $row['statut_eleve'] . '
                    </td>';
                         $output .= ' <td>
                         <a href="home.php?pg=info/&pl=341be97d9aff90c9978347f66f945b77&hg=97650b0da4e13c8f577cd67e0b73a78f&el='.$row['ID_eleve'].'&hg=97650b0da4e13c8f577cd67e0b73a78f&ip=254lkhfdtdfdgffyghfgseqr35gf/" ID="' . $row['ID_eleve'] . '" IDC="' . $row['ID_classe'] . '" IDINS="' . $row['ID_inscrire'] . '" class="btn btn-info btn-sm btn_frm_modifier_eleve">
                         <i class="fa fa-eye"></i> Info
                     </a>
                            <button ID="' . $row['ID_eleve'] . '" class="btn btn-danger btn-sm btn_supprimer_eleve">
                                <i class="fa fa-trash"></i> Supprimer
                            </button>
                            
                        </td>
                    </tr>';

             } 

        $output .= '</tbody>
                </table>
            </div>
        </div>
    </div>
</div>';


                }
            }
            echo $output;
        }
    }
    public static function btn_search_eleve_vesement() {
        if (isset($_POST['btn_search_eleve_vesement'])) {
            $search = htmlspecialchars(trim($_POST['search']));
            $output = "";

            $eleve = Soutra::getEleveInfoLike($search);
            if (empty($eleve)) {
                $output = " Aucun eleve correspondant";

            }else{
            $ver = Soutra::getVersementEleve($eleve['ID_eleve']);

            $mpayer = 0;
            $scolarite = 0;
            $mp = 0;
            foreach ($ver as $row) {
                $mpayer += $row['montant_versement'];
                $scolarite = $row['montant_inscrire'];
                $drdv = $row['date_echeance'];
            }

            $output = '
            <form class="frm_versement" action="" method="post">
        <div class="row">
        <div class="col-lg-4 form-group">
                <label for="libelle_classe">Nom & Prenoms</label>
                <input disabled type="text" class="form-control" value="'.$eleve['nom_eleve'] .'  '.$eleve['prenom_eleve'] .'" id="libelle_classe" />
            </div>
            <div class="col-lg-4 form-group">
                <label for="libelle_classe">Matrcule</label>
                <input disabled type="text" class="form-control" value="'. $eleve['mat_eleve'] .'" id="libelle_classe" />
            </div>
            <div class="col-lg-4 form-group">
                <label for="libelle_classe">Scolarité</label>
                <input disabled type="text" class="form-control" value="'. $eleve['libelle_niveau'] .'" id="libelle_classe" />
            </div>
            <div class="col-lg-4 form-group">
                <label for="libelle_classe">Scolarité</label>
                <input disabled type="text" class="form-control" value="'. number_format($scolarite) .'" id="libelle_classe" />
            </div>
            <input type="hidden" name="ID_inscrire" class="form-control" value="'. $row['ID_inscrire'].'" />
            <input type="hidden" name="btn_ajouter_vers" class="form-control" value="1" />

            <div class="col-lg-4 form-group">
                <label for="libelle_classe">Reste</label>
                <input disabled type="text" class="form-control" value="'. number_format($scolarite - $mpayer) .'" id="libelle_classe" />
            </div>
            <div class="col-lg-4 form-group">
                <label for="libelle_classe">Date Rdv</label>
                <input disabled type="text" class="form-control" value="'. Soutra::date_format($drdv).'" id="libelle_classe" />
            </div>
            <div class="col-lg-12 form-group">
                <label for="libelle_classe">Montant <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="montant_versement" id="montant_versement" />
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 form-group message"></div>
            <div class="col-lg-4 form-group text-right">
                <button class="btn btn-danger btn-sm btn_retour_classe">
                    <i class="fa fa-arrow-left"></i> Retour
                </button>
                <button type="submit" name="btn_versement" class="btn btn-primary btn-sm btn_versement">
                    <i class="fa fa-check-circle"></i> Valider
                </button>
            </div>
        </div>
        </form>';
        }
            
            
            echo $output;
        }
    }

    public static function liste_inscrire_by_day() {

            $output = '';
            $date = date('Y-m-d');

                $infos = Soutra::getEleveInscrire($date,1);
                // var_dump($infos); die();
                // $en_cour = Soutra::libelle("annee", "libelle_annee", "ID_annee", );

                if (empty($infos)) {
                    $output = '<strong style="color:red;text-align:center">Aucune donnée pour le moment  !</strong>';
                    
                } else {
                    $output = '<div class="row">
            <div class="col-md-12">
            <div class="panel">
                <div class="panel-body table-responsive ">
                    <table class="table table-hover table-sm table-striped" id="my-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Matricule</th>
                                <th>Date-ins</th>
                                <th>Nom et prénoms</th>
                                <th>Classe</th>
                                <th>Date-Nais</th>
                                <th>Qualité</th>
                                <th>Statut</th>
                                <th>Option</th>
                            <tr/>
                        <thead>
                        <tbody>';
                            $i = 0;
                             foreach ($infos as $row){ 
                                $i++;
                                
                            $date_inscrire = new DateTime($row['date_inscrire']);
                            $date_naiss = new DateTime($row['date_naiss']);

                    $output .= '
                    <tr>
                        <td>' . $i . '</td>
                        <td>' . $row['mat_eleve'] . '</td>
                        <td>' . $date_inscrire->format('d/m/Y') . '</td>
                        <td>' . $row['nom_eleve'].' '.$row['prenom_eleve'] . '</td>
                        <td>' . $row['libelle_classe'] . '</td>
                        <td>' . $date_naiss->format('d/m/Y') . '</td>
                        <td>' . $row['qualite_eleve'] . '
                        <td>' . $row['statut_eleve'] . '
                    </td>';
                         $output .= ' <td>
                         <a href="home.php?pg=info/&pl=341be97d9aff90c9978347f66f945b77&hg=97650b0da4e13c8f577cd67e0b73a78f&el='.$row['ID_eleve'].'&hg=97650b0da4e13c8f577cd67e0b73a78f&ip=254lkhfdtdfdgffyghfgseqr35gf/" ID="' . $row['ID_eleve'] . '" IDC="' . $row['ID_classe'] . '" IDINS="' . $row['ID_inscrire'] . '" class="btn btn-info btn-sm btn_frm_modifier_eleve">
                         <i class="fa fa-eye"></i> Info
                     </a>
                            <button ID="' . $row['ID_eleve'] . '" class="btn btn-danger btn-sm btn_supprimer_eleve">
                                <i class="fa fa-trash"></i> Supprimer
                            </button>
                            
                        </td>
                    </tr>';

             } 

        $output .= '</tbody>
                </table>
            </div>
        </div>
    </div>
</div>';


                }
            
            return $output;
        
    }

    public static function eleve_by_classe_rein() {
        if (isset($_POST['eleve_by_classe_rein'])) {
            $niveau = $_POST['niveau_b'];
            $annee = $_POST['annee_b'];
            $classe = $_POST['classe_b'];
            $search = $_POST['search_b'];
            $output = '';

            if (empty($annee)) {
                $output = '<strong style="color:red;text-align:center">Veuillez choisir une année academique</strong>';
            } elseif (empty($niveau)) {
                $output = '<strong style="color:red;text-align:center">Veuillez choisir un niveau</strong>';
            } elseif (empty($classe)) {
                $output = '<strong style="color:red;text-align:center">Veuillez choisir une classe</strong>';
            } else {
                if (empty(Soutra::getAllByItem7("eleve", "inscrire", "ID_eleve", "ID_eleve", "ID_annee", "ID_classe", $annee, $classe, $search))) {
                    $output = '<strong style="color:red;text-align:center">Pas d\'inscrit dans cette classe pour l\'année academique ' . (Soutra::libelle("annee", "libelle_annee", "ID_annee", $annee) - 1) . '-' . Soutra::libelle("annee", "libelle_annee", "ID_annee", $annee
                            ) . ' !</strong>';
                } else {
                    $output = '<div class="panel">
                      <h5>Filière : ' . Soutra::libelle("filiere", "libelle_filiere", "ID_filiere", Soutra::libelle("classe", "ID_filiere", "ID_classe", $classe
                            )) . ' <i class="fa fa-arrow-right"></i> Classe : ' . Soutra::libelle("classe", "libelle_classe", "ID_classe", $classe
                            ) . '';
                    if ($_SESSION["IDTYPE"] == 6)
                        $output .= '<a href="#" classe="' . $classe . '" annee="' . $annee . '" title="Exporter la liste de classe" class="btn btn-ligth liste_classe_pdf"> <i class="fa fa-file-pdf-o"></i> Exporter en pdf</a></h5>';
                    elseif ($_SESSION["IDTYPE"] == 5)
                        $output .= '<a href="#" classe="' . $classe . '" annee="' . $annee . '" title="Exporter la liste de classe" class="btn btn-ligth liste_classe_pdf"> <i class="fa fa-file-pdf-o"></i> Exporter en pdf</a></h5>';
                    else
                        $output .= '<a href="#" classe="' . $classe . '" annee="' . $annee . '" title="Exporter la liste de classe" class="btn btn-ligth liste_classe_pdf"> <i class="fa fa-file-pdf-o"></i> Exporter en pdf</a></h5>';
                    $output .= '<hr>
                        <div class="panel-body table-responsive">
                            <table class="table table-hover table-striped" id="liste_eleve">
                             <thead>
                                <tr>
                                    <th>N°</th>
                                    <th>Nom et prénoms</th>
                                    <th>Date naissance</th>
                                    <th>Lieu naissance</th>
                                    <th>Statut</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>';
                    $i = 0;
                    foreach (Soutra::getAllByItem7("eleve", "inscrire", "ID_eleve", "ID_eleve", "ID_annee", "ID_classe", $annee, $classe, $search) as $row) {
                        $i++;
                        $output .= '
                        <tr>
                            <td>' . $i . '</td>
                            <td>' . $row['nom_eleve'] . ' ' . $row['prenom_eleve'] . '</td>
                            <td>' . $row['date_naiss'] . '</td>
                            <td>' . $row['lieu_naiss'] . '</td>
                            <td>' . $row['statut_eleve'] . '</td>
                            <td>
                                <button ID="' . $row['ID_eleve'] . '" NOM="' . $row['nom_eleve'] . ' ' . $row['prenom_eleve'] . '" class="btn btn-info btn-sm btn_rein_eleve">
                                    <i class="fa fa-refresh"></i> Reinscrire
                                </button>
                            </td>
                        </tr>
                        ';
                    }
                    $output .= '</tbody></table></div></div>';
                }
            }
            echo $output;
        }
    }

    public static function eleve_by_classe() {
        if (isset($_POST['eleve_by_classe'])) {
            $niveau = $_POST['niveau_b'];
            $annee = $_POST['annee_b'];
            $classe = $_POST['classe_b'];
            $search = $_POST['search_b'];
            $output = '';

            if (empty($annee)) {
                $output = '<strong style="color:red;text-align:center">Veuillez choisir une année academique</strong>';
            } elseif (empty($niveau)) {
                $output = '<strong style="color:red;text-align:center">Veuillez choisir un niveau</strong>';
            } elseif (empty($classe)) {
                $output = '<strong style="color:red;text-align:center">Veuillez choisir une classe</strong>';
            } else {
                if (empty(Soutra::getAllByItem7("eleve", "inscrire", "ID_eleve", "ID_eleve", "ID_annee", "ID_classe", $annee, $classe, $search))) {
                    $output = '<strong style="color:red;text-align:center">Pas d\'inscrit dans cette classe pour l\'année academique ' . (Soutra::libelle("annee", "libelle_annee", "ID_annee", $annee) - 1) . '-' . Soutra::libelle("annee", "libelle_annee", "ID_annee", $annee
                            ) . ' !</strong>';
                } else {
                    $output = '<div class="panel">
                      <h5>Filière : ' . Soutra::libelle("filiere", "libelle_filiere", "ID_filiere", Soutra::libelle("classe", "ID_filiere", "ID_classe", $classe
                            )) . ' <i class="fa fa-arrow-right"></i> Classe : ' . Soutra::libelle("classe", "libelle_classe", "ID_classe", $classe
                            ) . '';
                    if ($_SESSION["IDTYPE"] == 6)
                        $output .= '<a href="#" classe="' . $classe . '" annee="' . $annee . '" title="Exporter la liste de classe" class="btn btn-ligth liste_classe_pdf"> <i class="fa fa-file-pdf-o"></i> Exporter en pdf</a></h5>';
                    elseif ($_SESSION["IDTYPE"] == 5)
                        $output .= '<a href="#" classe="' . $classe . '" annee="' . $annee . '" title="Exporter la liste de classe" class="btn btn-ligth liste_classe_pdf"> <i class="fa fa-file-pdf-o"></i> Exporter en pdf</a></h5>';
                    else
                        $output .= '<a href="#" classe="' . $classe . '" annee="' . $annee . '" title="Exporter la liste de classe" class="btn btn-ligth liste_classe_pdf"> <i class="fa fa-file-pdf-o"></i> Exporter en pdf</a></h5>';
                    $output .= '<hr>
                        
                        <div class="panel-body table-responsive">
                             <table class="table table-hover table-striped" id="liste_client">
                                <thead>
                                <tr>
                                    <th>Numero Ins</th>
                                    <th>Nom et prénoms</th>
                                    
                                    ';
                    if ($_SESSION["IDTYPE"] == 5) {
                        $output .= ' 
                                             <th>Scolarité (Fcfa)</th>
                                             <th>Payé (Fcfa)</th>
                                             <th>Reste (Fcfa)</th>
                                         ';
                    } else {
                        $output .= ' 
                                                <th>Date naissance</th>
                                                <th>Lieu naissance</th>
                                                <th>Sexe</th>
                                                <th>Statut</th>
                                            ';
                    }

                    if ($_SESSION["IDTYPE"] == 6) {
                        $output .= '<th>Nom Parent</th>';
                        $output .= '<th>Téléphone Parent</th>';
                        $output .= '<th></th>';
                    } else {
                        $output .= '<th>Actions</th>';
                    }

                    $output .= '</tr></thead><tbody>';
                    foreach (Soutra::getAllByItem7("eleve", "inscrire", "ID_eleve", "ID_eleve", "ID_annee", "ID_classe", $annee, $classe, $search) as $row) {
                        $somPaye = Soutra::getSommeByIns($row['ID_inscrire']);
                        $reste = ($row['montant_sco'] - $somPaye);
                        $output .= '
                            <tr>
                            <td>' . $row['ID_inscrire'] . '</td>
                            <td>' . $row['nom_eleve'] . ' ' . $row['prenom_eleve'] . '</td>';
                        if ($_SESSION["IDTYPE"] == 5) {
                            $output .= '
                                    <td>' . number_format($row['montant_sco']) . '</td>
                                    <td>' . number_format($somPaye) . '</td>
                                    <td>' . number_format($reste) . '</td>
                                ';
                        } else {
                            $output .= '
                                    <td>' . $row['date_naiss'] . '</td>
                                    <td>' . $row['lieu_naiss'] . '</td>
                                    <td>' . $row['sexe_eleve'] . '</td>
                                    <td>' . $row['statut_eleve'] . '</td>
                                ';
                        }
                        if ($_SESSION["IDTYPE"] == 5) {
                            $output .= ' <td>';
                            if ($row['montant_sco'] == $somPaye)
                                $output .= '<button class="btn btn-success btn-sm"><i class="fa fa-lock"></i> Soldé</button>';
                            else
                                $output .= '
                                    <input ID="' . $row['ID_eleve'] . '" placeholder="Montant à verser" class="montant-' . $row['ID_inscrire'] . '">
                                        
                                    <button ID="' . $row['ID_eleve'] . '" IDC="' . $row['ID_classe'] . '" IDINS="' . $row['ID_inscrire'] . '" class="btn btn-info btn-sm btn_versement">
                                        <i class="fa fa-money"></i> Verser
                                    </button>
                                </td>';
                        } elseif ($_SESSION["IDTYPE"] == 6) {
                            $output .= '
                                    <td>' . $row['nom_tuteur'] . '</td>
                                    <td>' . $row['tel_tuteur'] . '</td>';
                            if (empty($row['photo']))
                                $output .= ' <td>
                                                <button ID="' . $row['ID_eleve'] . '" IDC="' . $row['ID_classe'] . '" NOM="' . $row['nom_eleve'] . ' ' . $row['prenom_eleve'] . '" class="btn btn-info btn-sm btn_frm_photo_eleve">
                                                    <i class="fa fa-picture-o"></i> Photo
                                                </button>
                                            </td>';
                            else
                                $output .= '
                                    <td><img src="' . $row['photo'] . '" width="50px" height="50px" class="img-thumbnail"></td>';
                        } else {
                            $output .= ' <td>
                                <button ID="' . $row['ID_eleve'] . '" class="btn btn-danger btn-sm btn_supprimer_eleve">
                                    <i class="fa fa-trash"></i> Supprimer
                                </button>
                                <button ID="' . $row['ID_eleve'] . '" IDC="' . $row['ID_classe'] . '" IDINS="' . $row['ID_inscrire'] . '" class="btn btn-info btn-sm btn_frm_modifier_eleve">
                                    <i class="fa fa-edit"></i> Modifier
                                </button>
                            </td>';
                        }
                        $output .= ' </tr>
                        ';
                    }
                    $output .= '</tbody></table></div></div>';
                }
            }
            echo $output;
        }
    }

    public static function niveau_combobox_eleve($ID) {
        $output = '<option value="' . $ID . '">' . Soutra::libelle("niveau", "libelle_niveau", "ID_niveau", $ID) . '</option>';
        foreach (Soutra::getAll("niveau", "libelle_niveau") as $row) {
            if ($row['ID_type_employe'] != 1) {
                $output .= '
                    <option value="' . $row['ID_niveau'] . '">
                        ' . $row['libelle_niveau'] . '
                    </option>';
            }
        }
        $output .= "</select>";
        echo $output;
    }

    public static function filiere_combobox_eleve($ID) {
        $output = '<option value="' . $ID . '">' . Soutra::libelle("filiere", "libelle_filiere", "ID_filiere", $ID) . '</option>';
        foreach (Soutra::getAll("filiere", "libelle_filiere") as $row) {

            $output .= '
                    <option value="' . $row['ID_filiere'] . '">
                        ' . $row['libelle_filiere'] . '
                    </option>';
        }
        $output .= "</select>";
        echo $output;
    }

    public static function classe_combobox_eleve($ID) {
        $output = '<option value="' . $ID . '">' . Soutra::libelle("classe", "libelle_classe", "ID_classe", $ID) . '</option>';
        foreach (Soutra::getAll("classe", "libelle_classe") as $row) {

            $output .= '
                    <option value="' . $row['ID_classe'] . '">
                        ' . $row['libelle_classe'] . '
                    </option>';
        }
        $output .= "</select>";
        echo $output;
    }

    public static function btn_modifier_inscription() {
        if (isset($_POST['modifier_inscrire_eleve'])) {
            //$ran = rand(1000, 9000);
            //var_dump($_POST);die();
            $dataEleve = array(
                'nom_eleve' => strtoupper(htmlspecialchars(trim($_POST['nom']))),
                'prenom_eleve' => htmlspecialchars(trim(ucfirst($_POST['prenom']))),
                'date_naiss' => $_POST['date'],
                'lieu_naiss' => htmlspecialchars(trim(ucfirst($_POST['lieu']))),
                'sexe_eleve' => $_POST['sexe'],
                'tel_eleve' => $_POST['tel'],
                'email_eleve' => $_POST['email'],
                'statut_eleve' => $_POST['statut'],
                'nom_tuteur' => strtoupper(htmlspecialchars(trim($_POST['nom_t']))),
                'tel_tuteur' => $_POST['tel_t'],
                'fonction_tuteur' => htmlspecialchars(trim(ucfirst($_POST['fonction_t']))),
                'ID_eleve' => htmlspecialchars(trim(ucfirst($_POST['ID_eleve'])))
            );


            if (!empty($_POST['tel'])) {
                if (Soutra::verif_type($_POST['tel']) && mb_strlen($_POST['tel']) == 10 && Soutra::exite("eleve", "tel_eleve", $_POST['tel']) && Soutra::libelle("eleve", "ID_eleve", "tel_eleve", $_POST['tel']) == $_POST['ID_eleve']) {
                    if (!empty($_POST['email'])) {
                        if (Soutra::verif_email($_POST['email']) && Soutra::exite("eleve", "email_eleve", $_POST['email']) && Soutra::libelle("eleve", "ID_eleve", "email_eleve", $_POST['email']) == $_POST['ID_eleve']) {
                            if (!empty($_POST['tel_t'])) {
                                if (Soutra::verif_type($_POST['tel_t']) && mb_strlen($_POST['tel_t']) == 10) {
                                    //a coller
                                    require 'modification.php';
                                } else {
                                    echo '<strong class="alert alert-danger">Le numéro du tuteur/parent n\'est pas un bon format :' . $_POST['tel_t'] . '</strong>';
                                }
                            } else {
                                //a coller
                                require 'modification.php';
                            }
                        } else {
                            echo '<strong class="alert alert-danger">L\'adresse e-mail de l\'étudiant existe déjà ou n\'est pas un bon format :' . $_POST['email'] . '</strong>';
                        }
                    } else {
                        //a coller
                        require 'modification.php';
                    }
                } else {
                    echo '<strong class="alert alert-danger">Le numéro de l\'étudiant existe déjà ou n\'est pas un bon format :' . $_POST['tel'] . '</strong>';
                }
            } else {
                //a coller
                require 'modification.php';
            }
        }
    }

    public static function btn_supprimer_eleve() {
        if (isset($_POST['btn_supprimer_eleve'])) {
            $ID = $_POST['id_e'];
            $data = array(
                'ID_eleve' => $ID
            );
             $ID_inscrire = Soutra::getField("ID_inscrire","ID_eleve",$ID);
            $data2 = array(
                'ID_inscrire' => $ID_inscrire 
            );
            $data3 = array(
                'ID_inscrire' => $ID_inscrire 
            );
            $photo = Soutra::getItem('eleve', 'photo', 'ID_eleve', $ID);
            if (empty($photo)) {
               if (Soutra::delete("eleve", $data)) {
                     if (Soutra::delete("eleve", $data) && Soutra::delete("inscrire", $data2) && Soutra::delete("versement", $data3) ) {
                            echo 1;
                     } else {
                            echo 'Etudiant : Erreur de suppression 2 !';
                     }
                } else {
                    echo 'Etudiant : Erreur de suppression 1 !';
                }
            }else{
                unlink(Soutra::getItem('eleve', 'photo', 'ID_eleve', $ID));
                 if (Soutra::delete("eleve", $data)) {
                     if (Soutra::delete("eleve", $data) && Soutra::delete("inscrire", $data2) && Soutra::delete("versement", $data3) ) {
                            echo 1;
                     } else {
                            echo 'Etudiant : Erreur de suppression 2 !';
                     }
                } else {
                    echo 'Etudiant : Erreur de suppression 1 !';
                }
            }
            
           /* $sup = unlink(Soutra::libelle('eleve', 'photo', 'ID_eleve', $ID));
            if ($sup == 1) {
                if (Soutra::delete("eleve", $data)) {
                    echo 1;
                } else {
                    echo 'Etudiant : Erreur de suppression !';
                }
            } else {
                echo 'Etudiant : Erreur de lien !';
            }*/
        }
    }

    public static function nombreInscritParAn() {
        if (isset($_POST['inscritAn'])) {
            echo Soutra::getAllInscrit();
        }
    }

    public static function verif_echeance($montant) {
        if ($montant ) {
            // $d = new DateTime();
        }
    }


    public static function btn_ajouter_versement() {
        if (isset($_POST['btn_ajouter_vers'])) {
            date_default_timezone_set('Africa/Abidjan');
            $montant = htmlspecialchars(trim($_POST['montant_versement']));
            $ID_inscrire = htmlspecialchars(trim($_POST['ID_inscrire']));
            $montant_sco = Soutra::libelle("inscrire", "montant_inscrire", "ID_inscrire", $ID_inscrire);
            $result = "";
            //le tableau client
            $dataVersement = array(
                'montant_versement' => $montant,
                'ID_employe' => $_SESSION['ISPWB'],
                'date_versement' => date('Y-m-d H:i:s'),
                'date_echeance' => date('Y-m-d'),
                'ID_inscrire' => $ID_inscrire
            );

            //var_dump($data);exit();
            if (empty($montant) || !Soutra::verif_type($montant)) {
                echo 'Veuillez entrer un montant en chiffres';
            } elseif ($montant > $montant_sco) {
                echo 'Impossible car :Le montant à verser -> ' . $montant . ' ; Montant scolarité -> ' . $montant_sco;
            } elseif (($montant + Soutra::getSommeByIns($ID_inscrire)) > $montant_sco) {
                echo 'Impossible car :Le montant versé + montant à verser -> ' . ($montant + Soutra::getSommeByIns($ID_inscrire)) . ' ; Montant projet -> ' . $montant_sco;
            } elseif (Soutra::insert("versement", $dataVersement)) {
                echo 1;
            } else {
                echo 'Echec d\'ajout de versement !';
            }
        }
    }

    public static function versement_by_classe() {
        if (isset($_POST['versement_by_classe'])) {
            $niveau = $_POST['niveau_b'];
            $annee = $_POST['annee_b'];
            $classe = $_POST['classe_b'];
            $output = '';

            if (empty($annee)) {
                $output = '<strong style="color:red;text-align:center">Veuillez choisir une année academique</strong>';
            } elseif (empty($niveau)) {
                $output = '<strong style="color:red;text-align:center">Veuillez choisir un niveau</strong>';
            } elseif (empty($classe)) {
                $output = '<strong style="color:red;text-align:center">Veuillez choisir une classe</strong>';
            } else {
                if (empty(Soutra::getAllByItem6("eleve", "inscrire", "ID_eleve", "ID_eleve", "ID_annee", "ID_classe", $annee, $classe))) {
                    $output = '<strong style="color:red;text-align:center">Pas d\'inscrit dans cette classe pour l\'année academique ' . (Soutra::libelle("annee", "libelle_annee", "ID_annee", $annee) - 1) . '-' . Soutra::libelle("annee", "libelle_annee", "ID_annee", $annee
                            ) . ' !</strong>';
                } else {
                    $output = '<div class="panel">
                      <h5>Filière : ' . Soutra::libelle("filiere", "libelle_filiere", "ID_filiere", Soutra::libelle("classe", "ID_filiere", "ID_classe", $classe
                            )) . ' <i class="fa fa-arrow-right"></i> Classe : ' . Soutra::libelle("classe", "libelle_classe", "ID_classe", $classe
                            ) . '
                          <a href="#" classe="' . $classe . '" annee="' . $annee . '" title="Exporter la liste de classe" class="btn btn-ligth liste_classe_pdf"> <i class="fa fa-file-pdf-o"></i> Exporter en pdf</a></h5>
                        <hr>
                        
                        <div class="panel-body table-responsive">
                            <table class="table table-hover table-striped" id="liste_client">
                                <thead>
                                <tr>
                                    <th>Numero Ins</th>
                                    <th>Nom et prénoms</th>
                                    
                                    ';
                    if ($_SESSION["IDTYPE"] == 5) {
                        $output .= ' 
                                             <th>Scolarité (Fcfa)</th>
                                             <th>Payé (Fcfa)</th>
                                             <th>Reste (Fcfa)</th>
                                         ';
                    } else {
                        $output .= ' 
                                                <th>Date naissance</th>
                                                <th>Lieu naissance</th>
                                                <th>Sexe</th>
                                                <th>Statut</th>
                                            ';
                    }

                    $output .= '<th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                     ';
                    $somSco = 0;
                    $somReste = 0;
                    $somP = 0;
                    foreach (Soutra::getAllByItem6("eleve", "inscrire", "ID_eleve", "ID_eleve", "ID_annee", "ID_classe", $annee, $classe) as $row) {
                        $somPaye = Soutra::getSommeByIns($row['ID_inscrire']);
                        $reste = ($row['montant_sco'] - $somPaye);
                        $somSco = $somSco + $row['montant_sco'];
                        $somReste = $somReste + $reste;
                        $somP = $somP + $somPaye;
                        $output .= '
                            <tr>
                            <td>' . $row['ID_inscrire'] . '</td>
                            <td>' . $row['nom_eleve'] . ' ' . $row['prenom_eleve'] . '</td>';
                        if ($_SESSION["IDTYPE"] == 5) {
                            $output .= '
                                    <td>' . number_format($row['montant_sco']) . '</td>
                                    <td>' . number_format($somPaye) . '</td>
                                    <td>' . number_format($reste) . '</td>
                                ';
                        } else {
                            $output .= '
                                    <td>' . $row['date_naiss'] . '</td>
                                    <td>' . $row['lieu_naiss'] . '</td>
                                    <td>' . $row['sexe_eleve'] . '</td>
                                    <td>' . $row['statut_eleve'] . '</td>
                                ';
                        }
                        if ($_SESSION["IDTYPE"] == 5) {
                            $output .= '
                                  <td>
                                    <button IDINS ="' . $row['ID_inscrire'] . '" MTT = "' . $row['montant_sco'] . '" ET ="' . $row['nom_eleve'] . ' ' . $row['prenom_eleve'] . '" class="btn btn-dark btn-sm btn_modifier_sco">
                                        <i class="fa fa-edit"></i> Modifier scolarité
                                    </button>
                                  </td>';
                        } else {
                            $output .= ' <td>
                                <button ID="' . $row['ID_eleve'] . '" class="btn btn-danger btn-sm btn_supprimer_eleve">
                                    <i class="fa fa-trash"></i> Supprimer
                                </button>
                                <button ID="' . $row['ID_eleve'] . '" IDC="' . $row['ID_classe'] . '" IDINS="' . $row['ID_inscrire'] . '" class="btn btn-info btn-sm btn_frm_modifier_eleve">
                                    <i class="fa fa-edit"></i> Modifier
                                </button>
                            </td>';
                        }
                        $output .= ' </tr>
                        ';
                    }
                    $output .= '</tbody>
                            <tfoot>
                               <tr>
                                 <th></th>
                                 <th></th>
                                 <th>Total Scolarité (Fcfa)</th>
                                 <th>Total Payé (Fcfa)</th>
                                 <th>Total Reste (Fcfa)</th>
                                 <th></th>
                              </tr>
                               <tr>
                                 <td></td>
                                 <td></td>
                                 <td>' . number_format($somSco) . '</td>
                                 <td>' . number_format($somP) . '</td>
                                 <td>' . number_format($somReste) . '</td>
                                 <td></td>
                              </tr>
                            </tfoot>
                            </table></div></div>';
                }
            }
            echo $output;
        }
    }

    public static function versement_by_Eleve($id) {
        $output = '';

        $output .= '
        <div class="table-responsive">
            <table class="table table-hover table-striped" id="liste_client">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Numero Ins</th>
                        <th>Montant versé (Fcfa)</th>
                        <th>Date versement</th>
                        <th>Fin echeance</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
        ';

        $somSco = 0;
        $somReste = 0;
        $somP = 0;
        $i = 0;
        $versement = Soutra::getVersementEleve($id);
        foreach ($versement as $row) {
            // $somPaye = Soutra::getSommeByIns($row['ID_inscrire']);
            // $reste = ($row['montant_sco'] - $somPaye);
            $somSco = $row['montant_inscrire'];
            // $somReste = $somReste + $reste;
            $somP += $row['montant_versement'];
            $date_versement =  Soutra::date_format($row['date_versement']);
            $date_rdv =   Soutra::date_format($row['date_echeance']);

            $i ++;
            $output .= '
                <tr>
                    <td>' . $i . '</td>
                        <td>' . $row['inscrire'] . '</td>
                        <td>' . number_format($row['montant_versement'] ). '</td>
                        <td>' . $date_versement. '</td>
                        <td>' . $date_rdv . '</td>
                        <td>
                        <button ID="' . $row['ID_versement'] . '" IDC="' . $row['ID_versement'] . '" IDINS="' . $row['ID_inscrire'] . '" class="btn btn-info btn-sm btn_frm_modifier_eleve">
                            <i class="fa fa-edit"></i> Modifier
                        </button>
                    </td>
                </tr>
            ';
        }



        $somReste = $somSco - $somP ;
        $btnVer = ($somReste != 0) ? ' <a href="home.php?pg=verEle/&pl=341be97d9aff90c9978347f66f945b77&hg=97650b0da4e13c8f577cd67e0b73a78f&el='.$id.'&hg=97650b0da4e13c8f577cd67e0b73a78f&ip=254lkhfdtdfdgffyghfgseqr35gf/"  class="btn btn-success btn-sm ">
        <i class="fa fa-money"></i> Versement
            </a>' : '';
        $output .=' <tbody>
        <tfoot>
                               <tr>
                                 <th></th>
                                 <th></th>
                                 <th>Total Scolarité (Fcfa)</th>
                                 <th>Total Payé (Fcfa)</th>
                                 <th>Total Reste (Fcfa)</th>
                                 <th></th>
                              </tr>
                               <tr>
                                 <td></td>
                                 <td></td>
                                 <td>' . number_format($somSco). '</td>
                                 <td>' . number_format($somP) . '</td>
                                 <td>' .  number_format($somReste) . '</td>
                                 <td>'.$btnVer.'</td>
                              </tr>
                            </tfoot>
                </table>
            </div>';
            echo $output;
    }

    public static function liste_versement() {
        $output = '';
        $date = date('Y-m-d');

        $output .= '
        <div class="table-responsive">
            <table class="table table-hover table-striped" id="liste_client">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Matricule77</th>
                        <th>Nom & Prenoms</th>
                        <th>Statut</th>
                        <th>Classe (Fcfa)</th>
                        <th>Montant versé (Fcfa)</th>
                        <th>Date versement</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
        ';

        $somSco = 0;
        $somReste = 0;
        $somP = 0;
        $i = 0;
        $versement = Soutra::listeVersementByClasse('date_versement',$date);
        foreach ($versement as $row) {
            $date_versement =  Soutra::date_format($row['date_versement']);
            $date_rdv =   Soutra::date_format($row['date_echeance']);

            $i ++;
            $output .= '
                <tr>
                    <td>' . $i . '</td>
                        <td>' . $row['mat_eleve'] . '</td>
                        <td>' . $row['nom_eleve'] . ' '.$row['prenom_eleve'].'</td>
                        <td>' . $row['statut_eleve'] . '</td>
                        <td>' . $row['libelle_classe'] . '</td>
                        <td>' . number_format($row['montant_versement'] ). '</td>
                        <td>' . $date_versement. '</td>
                        <td>
                        <button ID="' . $row['ID_versement'] . '" IDC="' . $row['ID_versement'] . '" IDINS="' . $row['ID_inscrire'] . '" class="btn btn-info btn-sm btn_frm_modifier_eleve">
                            <i class="fa fa-edit"></i> Modifier
                        </button>
                    </td>
                </tr>
            ';
        }



        $somReste = $somSco - $somP ;
        $btnVer = ($somReste != 0) ? ' <a href="home.php?pg=verEle/&pl=341be97d9aff90c9978347f66f945b77&hg=97650b0da4e13c8f577cd67e0b73a78f&el='.$somReste.'&hg=97650b0da4e13c8f577cd67e0b73a78f&ip=254lkhfdtdfdgffyghfgseqr35gf/"  class="btn btn-success btn-sm ">
        <i class="fa fa-money"></i> Versement
            </a>' : '';
        $output .=' <tbody>
                </table>
            </div>';
            echo $output;
    }

    public static function versement_by_classe_search() {
        if (isset($_POST['versement_by_classe_search'])) {
            $niveau = $_POST['niveau_b'];
            $annee = $_POST['annee_b'];
            $classe = $_POST['classe_b'];
            $search = $_POST['search_b'];
            $output = '';

            if (empty($annee)) {
                $output = '<strong style="color:red;text-align:center">Veuillez choisir une année academique</strong>';
            } elseif (empty($niveau)) {
                $output = '<strong style="color:red;text-align:center">Veuillez choisir un niveau</strong>';
            } elseif (empty($classe)) {
                $output = '<strong style="color:red;text-align:center">Veuillez choisir une classe</strong>';
            } else {
                if (empty(Soutra::getAllByItem7("eleve", "inscrire", "ID_eleve", "ID_eleve", "ID_annee", "ID_classe", $annee, $classe, $search))) {
                    $output = '<strong style="color:red;text-align:center">Pas d\'inscrit dans cette classe pour l\'année academique ' . (Soutra::libelle("annee", "libelle_annee", "ID_annee", $annee) - 1) . '-' . Soutra::libelle("annee", "libelle_annee", "ID_annee", $annee
                            ) . ' !</strong>';
                } else {
                    $output = '<div class="panel">
                      <h5>Filière : ' . Soutra::libelle("filiere", "libelle_filiere", "ID_filiere", Soutra::libelle("classe", "ID_filiere", "ID_classe", $classe
                            )) . ' <i class="fa fa-arrow-right"></i> Classe : ' . Soutra::libelle("classe", "libelle_classe", "ID_classe", $classe
                            ) . '
                          <a href="#" classe="' . $classe . '" annee="' . $annee . '" title="Exporter la liste de classe" class="btn btn-ligth liste_classe_pdf"> <i class="fa fa-file-pdf-o"></i> Exporter en pdf</a></h5>
                        <hr>
                        
                        <div class="panel-body table-responsive">
                            <table class="table table-hover table-striped" id="liste_client">
                                <thead>
                                <tr>
                                    <th>Numero Ins</th>
                                    <th>Nom et prénoms</th>
                                    
                                    ';
                    if ($_SESSION["IDTYPE"] == 5) {
                        $output .= ' 
                                             <th>Scolarité (Fcfa)</th>
                                             <th>Payé (Fcfa)</th>
                                             <th>Reste (Fcfa)</th>
                                         ';
                    } else {
                        $output .= ' 
                                                <th>Date naissance</th>
                                                <th>Lieu naissance</th>
                                                <th>Sexe</th>
                                                <th>Statut</th>
                                            ';
                    }

                    $output .= '<th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                     ';
                    $somSco = 0;
                    $somReste = 0;
                    $somP = 0;
                    foreach (Soutra::getAllByItem7("eleve", "inscrire", "ID_eleve", "ID_eleve", "ID_annee", "ID_classe", $annee, $classe, $search) as $row) {
                        $somPaye = Soutra::getSommeByIns($row['ID_inscrire']);
                        $reste = ($row['montant_sco'] - $somPaye);
                        $somSco = $somSco + $row['montant_sco'];
                        $somReste = $somReste + $reste;
                        $somP = $somP + $somPaye;
                        $output .= '
                            <tr>
                            <td>' . $row['ID_inscrire'] . '</td>
                            <td>' . $row['nom_eleve'] . ' ' . $row['prenom_eleve'] . '</td>';
                        if ($_SESSION["IDTYPE"] == 5) {
                            $output .= '
                                    <td>' . number_format($row['montant_sco']) . '</td>
                                    <td>' . number_format($somPaye) . '</td>
                                    <td>' . number_format($reste) . '</td>
                                ';
                        } else {
                            $output .= '
                                    <td>' . $row['date_naiss'] . '</td>
                                    <td>' . $row['lieu_naiss'] . '</td>
                                    <td>' . $row['sexe_eleve'] . '</td>
                                    <td>' . $row['statut_eleve'] . '</td>
                                ';
                        }
                        if ($_SESSION["IDTYPE"] == 5) {
                            $output .= '
                                  <td>
                                    <button IDINS ="' . $row['ID_inscrire'] . '" MTT = "' . $row['montant_sco'] . '" ET ="' . $row['nom_eleve'] . ' ' . $row['prenom_eleve'] . '" class="btn btn-dark btn-sm btn_modifier_sco">
                                        <i class="fa fa-edit"></i> Modifier scolarité
                                    </button>
                                  </td>';
                        } else {
                            $output .= ' <td>
                                <button ID="' . $row['ID_eleve'] . '" class="btn btn-danger btn-sm btn_supprimer_eleve">
                                    <i class="fa fa-trash"></i> Supprimer
                                </button>
                                <button ID="' . $row['ID_eleve'] . '" IDC="' . $row['ID_classe'] . '" IDINS="' . $row['ID_inscrire'] . '" class="btn btn-info btn-sm btn_frm_modifier_eleve">
                                    <i class="fa fa-edit"></i> Modifier
                                </button>
                            </td>';
                        }
                        $output .= ' </tr>
                        ';
                    }
                    $output .= '</tbody>
                            <tfoot>
                               <tr>
                                 <th></th>
                                 <th></th>
                                 <th>Total Scolarité (Fcfa)</th>
                                 <th>Total Payé (Fcfa)</th>
                                 <th>Total Reste (Fcfa)</th>
                                 <th></th>
                              </tr>
                               <tr>
                                 <td></td>
                                 <td></td>
                                 <td>' . number_format($somSco) . '</td>
                                 <td>' . number_format($somP) . '</td>
                                 <td>' . number_format($somReste) . '</td>
                                 <td></td>
                              </tr>
                            </tfoot>
                            </table></div></div>';
                }
            }
            echo $output;
        }
    }

    public static function modifier_scolarite() {
        if (isset($_POST['modifier_scolarite'])) {
            $montant = htmlspecialchars(trim($_POST['montant_sco']));
            $ID = htmlspecialchars(trim($_POST['ID_sco']));
            if (empty($montant) || !ctype_digit($montant)) {
                echo '<strong class="text-danger">Veuillez entrer un montant en chiffres !</strong>';
            } elseif (Soutra::getSommeByIns($ID) > $montant) {
                echo '<strong class="text-danger">Le montant total versé ne peut être plus grand que la scolarité !</strong>';
            } else {
                $data = array(
                    'montant_sco' => $montant,
                    'ID_inscrire' => $ID
                );
                if (Soutra::update("inscrire", $data)) {
                    echo 1;
                } else {
                    echo '<strong class="text-danger">Une erreur table inscrire ! </strong>';
                }
            }
        }
    }

    public static function versement_by_eleve_search() {
        if (isset($_POST['versement_by_eleve'])) {
            $niveau = $_POST['niveau_b'];
            $annee = $_POST['annee_b'];
            $classe = $_POST['classe_b'];
            $search = $_POST['search_b'];
            $output = '';

            if (empty($annee)) {
                $output = '<strong style="color:red;text-align:center">Veuillez choisir une année academique</strong>';
            } elseif (empty($niveau)) {
                $output = '<strong style="color:red;text-align:center">Veuillez choisir un niveau</strong>';
            } elseif (empty($classe)) {
                $output = '<strong style="color:red;text-align:center">Veuillez choisir une classe</strong>';
            } elseif (empty($search)) {
                $output = '<strong style="color:red;text-align:center">Veuillez un numéro d\'inscription !</strong>';
            } else {
                if (empty(Soutra::getAllByItem8($search, $classe))) {
                    $output = '<strong style="color:red;text-align:center">Pas d\'inscrit dans cette classe pour ce numéro inscription <i class="fa fa-arrow-right"></i> ' . $search . ' !</strong>';
                } else {
                    $nom = Soutra::libelle("eleve", "nom_eleve", "ID_eleve", Soutra::libelle("inscrire", "ID_eleve", "ID_inscrire", $search
                            )) . ' ' . Soutra::libelle("eleve", "prenom_eleve", "ID_eleve", Soutra::libelle("inscrire", "ID_eleve", "ID_inscrire", $search
                    ));
                    $output = '<div class="panel">
                      <h5><span class="text-danger">ETUDIANT</span> : ' . $nom . '  <i class="fa fa-arrow-right"></i> <span class="text-danger">CLASSE</span> : ' . Soutra::libelle("classe", "libelle_classe", "ID_classe", $classe
                            ) . '
                          <a href="#" search="' . $search . '" title="Exporter les versement en pdf" class="btn btn-ligth btn_list_vers" classe="' . $classe . '" annee="' . $annee . '" > <i class="fa fa-file-pdf-o"></i> Exporter en pdf</a></h5>
                        
                        <div class="panel-body table-responsive">
                            <table class="table table-hover table-striped" id="liste_client">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Date de versement</th>
                                    <th>Montant du versement (Fcfa)</th>
                                    <th></th>
                                    
                                    ';
                    $output .= '<th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                     ';
                    $i = 0;
                    foreach (Soutra::getAllByItem8($search, $classe) as $row) {
                        $i++;
                        $output .= '
                            <tr>
                            <td>' . $i . '</td>
                            <td>' . $row['date_versement'] . '</td>
                            <td>' . number_format($row['montant_versement']) . '</td>
                            <td></td>';

                        $output .= ' <td>
                                <button ID="' . $row['ID_versement'] . '" class="btn btn-danger btn-sm btn_supprimer_vers">
                                    <i class="fa fa-trash"></i> Supprimer
                                </button>
                                <button DT="' . $row['date_versement'] . '" ID="' . $row['ID_versement'] . '" MTT="' . $row['montant_versement'] . '" IDINS="' . $row['ID_inscrire'] . '" ET ="' . $row['nom_eleve'] . ' ' . $row['prenom_eleve'] . '" class="btn btn-info btn-sm btn_frm_modifier_vers">
                                    <i class="fa fa-edit"></i> Modifier
                                </button>
                            </td>';

                        $output .= ' </tr>
                        ';
                    }
                    $output .= '</tbody>
                            <tfoot>
                               <tr>
                                 <th>#</th>
                                 <th>Scolarité (Fcfa)</th>
                                 <th>Payé (Fcfa)</th>
                                 <th>Reste (Fcfa)</th>
                                 <th></th>
                              </tr>
                               <tr>
                                 <td></td>
                                 <td>' . number_format(Soutra::libelle("inscrire", "montant_sco", "ID_inscrire", $search)) . '</td>
                                 <td>' . number_format(Soutra::getSommeByIns($search)) . '</td>
                                 <td>' . number_format((Soutra::libelle("inscrire", "montant_sco", "ID_inscrire", $search) - Soutra::getSommeByIns($search))) . '</td>
                                 <td></td>
                              </tr>
                            </tfoot>
                            </table></div></div>';
                }
            }
            echo $output;
        }
    }

    public static function modifier_versement() {
        if (isset($_POST['modifier_versement'])) {

            $nouveau_montant = htmlspecialchars(trim($_POST['nouveau_montant']));
            $ancien_montant = htmlspecialchars(trim($_POST['ancien_montant']));
            $ID_inscrire = htmlspecialchars(trim($_POST['ID_inscrire']));
            $ID_versement = htmlspecialchars(trim($_POST['ID_versement']));
            $montant_sco = Soutra::libelle("inscrire", "montant_sco", "ID_inscrire", $ID_inscrire);
            $verif = (Soutra::getSommeByIns($ID_inscrire) - $ancien_montant);

            if (empty($nouveau_montant) || !ctype_digit($nouveau_montant)) {
                echo '<strong class="text-danger">Veuillez entrer un montant en chiffres !</strong>';
            } elseif (($verif + $nouveau_montant) > $montant_sco) {
                echo '<strong class="text-danger">Le montant total versé ne peut être plus grand que la scolarité !</strong>';
            } else {
                $data = array(
                    'montant_versement' => $nouveau_montant,
                    'ID_versement' => $ID_versement
                );
                if (Soutra::update("versement", $data)) {
                    echo 1;
                } else {
                    echo '<strong class="text-danger">Une erreur table versement ! </strong>';
                }
            }
        }
    }

    public static function btn_supprimer_vers() {
        if (isset($_POST['btn_supprimer_vers'])) {
            $ID = $_POST['id_versement'];
            $data = array(
                'ID_versement' => $ID
            );

            if (Soutra::delete("versement", $data)) {
                echo 1;
            } else {
                echo 'Etudiant : Erreur de suppression !';
            }
        }
    }

    public static function uploading() {
        if (isset($_POST['uplo'])) {
            if ($_FILES['file']['name'] != '') {
                $test = explode(".", $_FILES['file']['name']);
                $extension = end($test); //end() permet de prendre le dernier element d un tableau
                //$name = rand(100,999).'.'.$extension;
                $name = $_POST['idEleve'] . '.' . $extension;
                $location = '../images/' . $name;
                $data = array(
                    'photo' => $location,
                    'ID_eleve' => $_POST['idEleve']
                );
                if (Soutra::update('eleve', $data)) {
                    move_uploaded_file($_FILES['file']['tmp_name'], $location);
                    echo '<img src="' . $location . '" height="" width="" class="img-thumbnail" />';
                } else {
                    echo 'Erreur de photo';
                }
            }
        }
    }

    //reinscription d'etudiant
    public static function btn_reinscription() {
        if (isset($_POST['reinscrire'])) {
            date_default_timezone_set('Africa/Abidjan');
            $code = substr(date('Y'), 2) . '-' . date("dHis") . '-' . 'ISPW-B';
            extract($_POST);
            //var_dump($_POST); die();
            $dataInscrire = array(
                'ID_inscrire' => $code,
                'ID_classe' => htmlspecialchars($classe),
                'ID_eleve' => htmlspecialchars($eleve),
                'ID_annee' => htmlspecialchars($annee),
                'montant_sco' => htmlspecialchars($montant),
                'date_inscrire' => date('Y-m-d H:i:s')
            );

            if (empty($classe) || empty($annee) || empty($montant)) {
                echo '2blo<strong  class="alert alert-danger">Veuillez renseigner tous les champs !</strong >';
            } else {
                if (ctype_digit($montant)) {
                    if (!Soutra::exist2('inscrire', 'ID_eleve', 'ID_annee', $eleve, $annee)) {
                        if (Soutra::insert('inscrire', $dataInscrire)) {
                            $dataVersement = array(
                                'montant_versement' => 0,
                                'ID_inscrire' => $code,
                                'ID_employe' => $_SESSION['ISPWB'],
                                'date_versement' => date('Y-m-d H:i:s')
                            );
                            if (Soutra::insert('versement', $dataVersement)) {
                                echo '1blo<strong  class="text-success">Numero d\'inscription : ' . $code . '</strong >';
                            } else {
                                echo '2blo<strong  class="alert alert-danger">Erreur table Versement !</strong >';
                            }
                        } else {
                            echo '2blo<strong  class="alert alert-danger">Erreur table inscrire !</strong >';
                        }
                    } else {
                         echo '2blo<strong  class="alert alert-danger">Cet(te) étudiant(e) est déjà inscrit(e) !</strong >';
                    }
                } else {
                    echo '2blo<strong  class="alert alert-danger">Veuillez revoir la scolarité !</strong >';
                }
            }
        }
    }
    
    public static function liste_classe_notes() {
        if (isset($_POST['btn_list_classe_note'])) {
            extract($_POST);
            if (empty($anneeEmp)) {
                $output = '<strong class="text-danger">Veuillez choisir une année</strong>';
            }elseif(empty($niveauEmp)){
                 $output = '<strong class="text-danger">Veuillez choisir un niveau</strong>';
            }elseif(empty($classeEmp)){
                 $output = '<strong class="text-danger">Veuillez choisir une classe</strong>';
            }else{
                $output='<h4>Tirer la liste de classe ou la liste de notes</h4>';
                $output .='<a target="_blank" href="../etats/liste_n.php?pg='.sha1('guene_aicha').'&b='.sha1('bamba_lamine').'&p='.sha1('guene_aicha').'&c='.sha1('bamba_lamine').'&pg='.sha1('guene_aicha').'&b='.sha1('bamba_lamine').'/&an='.$anneeEmp.'&cl='.$classeEmp.'&ni='.$niveauEmp.'" class="btn btn-primary btn-sm"><span class="fa fa-print"></span> Liste de notes</a> ';
                $output .='<a target="_blank" href="../etats/liste_cla.php?pg='.sha1('guene_aicha').'&b='.sha1('bamba_lamine').'&p='.sha1('guene_aicha').'&c='.sha1('bamba_lamine').'&pg='.sha1('guene_aicha').'&b='.sha1('bamba_lamine').'/&an='.$anneeEmp.'&cl='.$classeEmp.'&ni='.$niveauEmp.'" class="btn btn-danger btn-sm"><span class="fa fa-print"></span> Liste de classe</a>';
            }
            echo $output;
        }
    }
    
     /************************* bloc test lourd *********************/
    
      // enregistrement de note de test lourd
     public static function liste_eleve_by_classe_test_lourd() {
        if (isset($_POST['liste_eleve_by_classe_test_lourd'])) {
            $niveau = $_POST['niveau_b'];
            $annee = $_POST['annee_b'];
            $classe = $_POST['classe_b'];
            $semestre = $_POST['semestre_b'];
            $output = '';

            if (empty($annee)) {
                $output = '<strong style="color:red;text-align:center">Veuillez choisir une année academique</strong>';
            } elseif (empty($niveau)) {
                $output = '<strong style="color:red;text-align:center">Veuillez choisir un niveau</strong>';
            } elseif (empty($classe)) {
                $output = '<strong style="color:red;text-align:center">Veuillez choisir une classe</strong>';
            } else {
                if (empty(Soutra::getAllByItem6("eleve", "inscrire", "ID_eleve", "ID_eleve", "ID_annee", "ID_classe", $annee, $classe))) {
                    $output = '<strong style="color:red;text-align:center">Pas d\'inscrit dans cette classe pour l\'année academique ' . (Soutra::libelle("annee", "libelle_annee", "ID_annee", $annee) - 1) . '-' . Soutra::libelle("annee", "libelle_annee", "ID_annee", $annee
                            ) . ' !</strong>';
                } else {
                    $output = '<div class="panel">
                      <h5>Filière : ' . Soutra::libelle("filiere", "libelle_filiere", "ID_filiere", Soutra::libelle("classe", "ID_filiere", "ID_classe", $classe
                            )) . ' <i class="fa fa-arrow-right"></i> Classe : ' . Soutra::libelle("classe", "libelle_classe", "ID_classe", $classe
                            ) .'</h5>';
                    $output .= '<hr>
                        
                        <div class="panel-body table-responsive">
                            <table class="table table-hover table-striped" id="liste_client">
                                <thead>
                                <tr>
                                    <th>Numero Ins</th>
                                    <th>Nom et prénoms</th>';
                    $output .= '<th>Actions</th>';


                    $output .= '</tr></thead><tbody>';
                    foreach (Soutra::getAllByItem6("eleve", "inscrire", "ID_eleve", "ID_eleve", "ID_annee", "ID_classe", $annee, $classe) as $row) {

                        $output .= '
                            <tr>
                            <td>' . $row['ID_inscrire'] . '</td>
                            <td>' . $row['nom_eleve'] . ' ' . $row['prenom_eleve'] . '</td>';
                        
                        $output .= ' <td>
                                <input type="text" class="noter_lamson_test form-control" blo="'.$row['ID_eleve'].'" value="00">
                                    
                            </td>';
                        $output .= ' </tr>
                        ';
                    }
                    $output .= '</tbody></table>'
                            . '<hr> <button class="btn btn-success btn_valider_test" ><i class="fa fa-check"></i> Valider</button>'
                            . '</div></div>';
                }
            }
            echo $output;
        }
    }
    
     public static function liste_eleve_by_classe_test_lourd_rech() {
        if (isset($_POST['liste_eleve_by_classe_test_lourd_rech'])) {
            $niveau = $_POST['niveau_b'];
            $annee = $_POST['annee_b'];
            $classe = $_POST['classe_b'];
            $semestre = $_POST['semestre_b'];
            $search = $_POST['search_b'];
            $output = '';

            if (empty($annee)) {
                $output = '<strong style="color:red;text-align:center">Veuillez choisir une année academique</strong>';
            } elseif (empty($niveau)) {
                $output = '<strong style="color:red;text-align:center">Veuillez choisir un niveau</strong>';
            } elseif (empty($classe)) {
                $output = '<strong style="color:red;text-align:center">Veuillez choisir une classe</strong>';
            } else {
                if (empty(Soutra::getAllByItem7("eleve", "inscrire", "ID_eleve", "ID_eleve", "ID_annee", "ID_classe", $annee, $classe, $search))) {
                    $output = '<strong style="color:red;text-align:center">Pas d\'inscrit dans cette classe pour l\'année academique ' . (Soutra::libelle("annee", "libelle_annee", "ID_annee", $annee) - 1) . '-' . Soutra::libelle("annee", "libelle_annee", "ID_annee", $annee
                            ) . ' !</strong>';
                } else {
                    $output = '<div class="panel">
                      <h5>Filière : ' . Soutra::libelle("filiere", "libelle_filiere", "ID_filiere", Soutra::libelle("classe", "ID_filiere", "ID_classe", $classe
                            )) . ' <i class="fa fa-arrow-right"></i> Classe : ' . Soutra::libelle("classe", "libelle_classe", "ID_classe", $classe
                            ) .'</h5>';
                    $output .= '<hr>
                        
                        <div class="panel-body table-responsive">
                            <table class="table table-hover table-striped" id="liste_client">
                                <thead>
                                <tr>
                                    <th>Numero Ins</th>
                                    <th>Nom et prénoms</th>';
                    $output .= '<th>Moyenne</th>';


                    $output .= '</tr></thead><tbody>';
                    foreach (Soutra::getAllByItem7("eleve", "inscrire", "ID_eleve", "ID_eleve", "ID_annee", "ID_classe", $annee, $classe, $search) as $row) {

                        $output .= '
                            <tr>
                            <td>' . $row['ID_inscrire'] . '</td>
                            <td>' . $row['nom_eleve'] . ' ' . $row['prenom_eleve'] . '</td>';

                        $output .= ' <td>
                                <input type="text" class="noter_lamson_test form-control" blo="'.$row['ID_eleve'].'" value="00">
                                    
                            </td>';
                        $output .= ' </tr>
                        ';
                    }
                    $output .= '</tbody></table>'
                            . '<hr> <button class="btn btn-success btn_valider_test" ><i class="fa fa-check"></i> Valider</button>'
                            . '</div></div>';
                }
            }
            echo $output;
        }
    }
      
    // modification de note de test lourd
    public static function liste_eleve_by_classe_test_lourd_modif() {
        if (isset($_POST['liste_eleve_by_classe_test_lourd_modif'])) {
            $niveau = $_POST['niveau_b'];
            $annee = $_POST['annee_b'];
            $classe = $_POST['classe_b'];
            $semestre = $_POST['semestre_b'];
            $output = '';

            if (empty($annee)) {
                $output = '<strong style="color:red;text-align:center">Veuillez choisir une année academique</strong>';
            } elseif (empty($niveau)) {
                $output = '<strong style="color:red;text-align:center">Veuillez choisir un niveau</strong>';
            } elseif (empty($classe)) {
                $output = '<strong style="color:red;text-align:center">Veuillez choisir une classe</strong>';
            } else {
                if (empty(Soutra::getAllByItem6("eleve", "inscrire", "ID_eleve", "ID_eleve", "ID_annee", "ID_classe", $annee, $classe))) {
                    $output = '<strong style="color:red;text-align:center">Pas d\'inscrit dans cette classe pour l\'année academique ' . (Soutra::libelle("annee", "libelle_annee", "ID_annee", $annee) - 1) . '-' . Soutra::libelle("annee", "libelle_annee", "ID_annee", $annee
                            ) . ' !</strong>';
                } else {
                    $output = '<div class="panel">
                      <h5>Filière : ' . Soutra::libelle("filiere", "libelle_filiere", "ID_filiere", Soutra::libelle("classe", "ID_filiere", "ID_classe", $classe
                            )) . ' <i class="fa fa-arrow-right"></i> Classe : ' . Soutra::libelle("classe", "libelle_classe", "ID_classe", $classe
                            ) .'</h5>';
                    $output .= '<hr>
                        
                        <div class="panel-body table-responsive">
                            <table class="table table-hover table-striped" id="liste_client">
                                <thead>
                                <tr>
                                    <th>Numero Ins</th>
                                    <th>Nom et prénoms</th>';
                    $output .= '<th>Actions</th>';


                    $output .= '</tr></thead><tbody>';
                    foreach (Soutra::getAllByItem6("eleve", "inscrire", "ID_eleve", "ID_eleve", "ID_annee", "ID_classe", $annee, $classe) as $row) {

                        $output .= '
                            <tr>
                            <td>' . $row['ID_inscrire'] . '</td>
                            <td>' . $row['nom_eleve'] . ' ' . $row['prenom_eleve'] . '</td>';
                        if(Soutra::getNoteTestLourd($row['ID_eleve'],$semestre,$annee)==null){
                            $output .= ' <td>
                                <input type="text" class="noter_lamson_test form-control" blo="'.$row['ID_eleve'].'" value="000">       
                            </td>';
                        }else{
                            $output .= ' <td>
                                <input type="text" class="noter_lamson_test form-control" blo="'.$row['ID_eleve'].'" value="'.Soutra::getNoteTestLourd($row['ID_eleve'],$semestre,$annee).'">
                                    
                            </td>';
                        }
                        
                        $output .= ' </tr>
                        ';
                    }
                    $output .= '</tbody></table>'
                            . '<hr> <button class="btn btn-primary btn_valider_test_modif" ><i class="fa fa-edit"></i> Modifier</button>'
                            . '</div></div>';
                }
            }
            echo $output;
        }
    }
    
     public static function liste_eleve_by_classe_test_lourd_modif_rech() {
        if (isset($_POST['liste_eleve_by_classe_test_lourd_modif_rech'])) {
            $niveau = $_POST['niveau_b'];
            $annee = $_POST['annee_b'];
            $classe = $_POST['classe_b'];
            $semestre = $_POST['semestre_b'];
            $search = $_POST['search_b'];
            $output = '';

            if (empty($annee)) {
                $output = '<strong style="color:red;text-align:center">Veuillez choisir une année academique</strong>';
            } elseif (empty($niveau)) {
                $output = '<strong style="color:red;text-align:center">Veuillez choisir un niveau</strong>';
            } elseif (empty($classe)) {
                $output = '<strong style="color:red;text-align:center">Veuillez choisir une classe</strong>';
            } else {
                if (empty(Soutra::getAllByItem7("eleve", "inscrire", "ID_eleve", "ID_eleve", "ID_annee", "ID_classe", $annee, $classe, $search))) {
                    $output = '<strong style="color:red;text-align:center">Pas d\'inscrit dans cette classe pour l\'année academique ' . (Soutra::libelle("annee", "libelle_annee", "ID_annee", $annee) - 1) . '-' . Soutra::libelle("annee", "libelle_annee", "ID_annee", $annee
                            ) . ' !</strong>';
                } else {
                    $output = '<div class="panel">
                      <h5>Filière : ' . Soutra::libelle("filiere", "libelle_filiere", "ID_filiere", Soutra::libelle("classe", "ID_filiere", "ID_classe", $classe
                            )) . ' <i class="fa fa-arrow-right"></i> Classe : ' . Soutra::libelle("classe", "libelle_classe", "ID_classe", $classe
                            ) .'</h5>';
                    $output .= '<hr>
                        
                        <div class="panel-body table-responsive">
                            <table class="table table-hover table-striped" id="liste_client">
                                <thead>
                                <tr>
                                    <th>Numero Ins</th>
                                    <th>Nom et prénoms</th>';
                    $output .= '<th>Moyenne</th>';


                    $output .= '</tr></thead><tbody>';
                    foreach (Soutra::getAllByItem7("eleve", "inscrire", "ID_eleve", "ID_eleve", "ID_annee", "ID_classe", $annee, $classe, $search) as $row) {

                        $output .= '
                            <tr>
                            <td>' . $row['ID_inscrire'] . '</td>
                            <td>' . $row['nom_eleve'] . ' ' . $row['prenom_eleve'] . '</td>';

                        if(Soutra::getNoteTestLourd($row['ID_eleve'],$semestre,$annee)==null){
                            $output .= ' <td>
                                <input type="text" class="noter_lamson_test form-control" blo="'.$row['ID_eleve'].'" value="000">       
                            </td>';
                        }else{
                            $output .= ' <td>
                                <input type="text" class="noter_lamson_test form-control" blo="'.$row['ID_eleve'].'" value="'.Soutra::getNoteTestLourd($row['ID_eleve'],$semestre,$annee).'">
                                    
                            </td>';
                        }
                        $output .= ' </tr>
                        ';
                    }
                    $output .= '</tbody></table>'
                            . '<hr> <button class="btn btn-primary btn_valider_test_modif" ><i class="fa fa-edit"></i> Modifier</button>'
                            . '</div></div>';
                }
            }
            echo $output;
        }
    }


}//fin de la classe
