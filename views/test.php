<?php

// --------------------------------------
// DEBUT ET FIN DE SEMAINE
// true week
// $dateTime = new DateTime('now');
// $monday = clone $dateTime->modify(('Sunday' == $dateTime->format('l')) ? 'Monday last week' : 'Monday this week');
// $sunday = clone $dateTime->modify('Sunday this week');

// var_dump($monday->format('Y-m-d')); // e.g. 2018-06-25
// var_dump($sunday->format('Y-m-d'));



// -------------------------------------------------

// DEBUT ET FINT MOIS 
// TRUE

// $date = new DateTime();
// $dateDeb = $date -> format('01/m/Y');
// $dateFin = $date -> format('t/m/Y');

// var_dump(date('H:i:s',strtotime('3 HOURS'))); 
// var_dump($dateFin);

// -----------------------------------------------
// COMPARER DEUX DATE 
// TRUE

// $date1 = "2022-11-15" ;
// $date2 = "2022-11-16";

// $dateTimestamp1 = strtotime($date1);
// $dateTimestamp2 = strtotime($date2);

// var_dump($dateTimestamp1); 
// var_dump($dateTimestamp2);






$dateTime = new DateTime('now');
$monday = clone $dateTime->modify(('Sunday' == $dateTime->format('l')) ? 'Monday last week' : 'Monday this week');
$sunday = clone $dateTime->modify('Sunday this week');

$debut = $monday->format('Y-m-d');
$fin = $sunday->format('Y-m-d');

// var_dump($debut);
// var_dump($fin);
// setlocale(LC_TIME, 'fr_FR.utf8', 'fra');


//  $total = Soutra::getCountNew("achat");
 $article = Soutra::getSingleAchatArticle(2);
// echo($total);
var_dump($article);
 
  
//  $total = Soutra::getTotalVenteByWeek();
//  $total = Soutra::getTotalVenteByEmployeInMonth();
//  $total = Soutra::getTotalVenteByWeek();

//  $total= Soutra::getSingleVenteArticle(122,1);
 
//  $entree = Soutra::getCompterSum('entree','qte','article_id',1);
//  $sortie = Soutra::getCompterSum('sortie','qte','article_id',1);
//  $info = Soutra::getInfoBoutique();
$i = 0;
 $prod = Soutra::getHistoriqueEntree();
//  $categorie = Soutra::libelle("categorie", "ID_categorie", "libelle_categorie", "cat 14") ;

//  foreach($prod as $p){
//   $i++;
//   break;
  
//  }




 //var_dump($prod);
//  var_dump($sortie);

///-----------------------------------------------------------

  // COMPARER LA DATE ACTUELLE AVEC UNE DATE DONNEE
  function dateDiff(String $dateDepart, string $duree, string $dateActu= '')
  {

  
    $retour = false;
    $dateActu = !empty($dateActu) ? $dateActu: date('d-m-Y H:i:s');
    $dateDepartTimestamp = strtotime($dateDepart);

//on calcule la date de fin
    $dateFin = date('d-m-Y', strtotime('+' . $duree . 'month', $dateDepartTimestamp));
    if (strtotime($dateFin) >= strtotime($dateActu)) {
        $retour = true;
    }

    return $retour;
  }
// var_dump(dateDiff('30-01-2023','1'));
// var_dump(Soutra::dateDiff('30/01/2023','3'));
// 21/11/2022


?>

              <!-- .page-title-bar -->
              <header class="page-title-bar">
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item active">
                      <a href="#!"><i class="breadcrumb-icon fa fa-angle-left mr-2"></i>Components</a>
                    </li>
                  </ol>
                </nav>
                <h1 class="page-title"> General Elements </h1>
              </header><!-- /.page-title-bar -->
              <!-- .page-section -->
              <div class="page-section">
              
                <!-- .section-block -->
                <div class="section-block">
                  <div class="row">
                    <!-- grid column -->
                    <div class="col-lg-12">
                      <!-- #accordion -->
                     <?php
                      for ($i=0; $i < 25; $i++) { ?>
                      

                            <div id="accordion" class="card-expansion">
                              <!-- .card -->
                              <section class="card card-expansion-item">
                                <header class="card-header border-0" id="heading<?= $i ?>">
                                  <button class="btn btn-reset collapsed" data-toggle="collapse" data-target="#collapse<?= $i ?>" aria-expanded="false" aria-controls="collapse<?= $i ?>"><span class="collapse-indicator mr-2"><i class="fa fa-fw fa-caret-right"></i></span> <span>Expandable Item #2</span></button>
                                  /jldjdjjdjdkjkdjlkj
                                </header>
                                <div id="collapse<?= $i ?>" class="collapse" aria-labelledby="heading<?= $i ?>" data-parent="#accordion">
                                  <div class="card-body pt-0">
                                  <div class="table-responsive bg-light py-3 px-2 border rounded">
                                        <!-- .table -->
                                        <table class="table table-hover">
                                        <!-- thead -->
                                        <thead>
                                        <tr>
                                            <th> CODE CMD </th>
                                            <th> MONTANT </th>
                                            <th> DATE </th>
                                            <th> ACTION </th>
                                        </tr>
                                        </thead><!-- /thead -->
                                        <!-- tbody -->
                                        <tbody>
                                            <?php 
                                            $p = 1;
                                            for ($j=0; $j < 5; $j++) { ?>
                                                
                                                <!-- tr -->
                                        <tr>
                                            <td>
                                                <a href="#">
                                                dd4544345
                                                </a>
                                            </td>
                                            <td>
                                            308.557.554
                                            </td>
                                            <td> 24/08/2022 </td>
                                            <td> 24 </td>
                                        </tr><!-- /tr -->

                                            <?php }
                                            ?>
                                      
                                        </tbody><!-- /tbody -->
                                    </table><!-- /.table -->
                                    </div><!-- /.table-responsive bg-light py-3 px-2 border rounded -->
                                    
                                  </div>
                                </div>
                              </section><!-- /.card -->
                          
                          </div><!-- /#accordion -->

                     <?php }
                     ?>
                       </div><!-- /grid column -->
                   </div><!-- /grid row -->
                </div><!-- /.section-block -->
                <hr class="my-5">
               </div><!-- /.page-section -->