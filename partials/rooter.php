<?php
session_start();
date_default_timezone_set('Africa/Abidjan');
require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();
require_once "../config/const.php";
require_once "../config/helpers.php";
require_once "../config/action.php";
require_once "../models/Connexion.php";
require_once "../models/Employe.php";
require_once '../controllers/Soutra.php';
require_once "../controllers/ControllerEntrepot.php";
require_once "../controllers/ControllerEmploye.php";
require_once "../controllers/ControllerClient.php";
require_once "../controllers/ControllerFournisseur.php";
require_once "../controllers/ControllerCategorie.php";
require_once "../controllers/ControllerFamille.php";
require_once "../controllers/ControllerMark.php";
require_once "../controllers/ControllerUnite.php";
require_once "../controllers/ControllerArticle.php";
require_once "../controllers/ControllerAchat.php";
require_once "../controllers/ControllerVente.php";
require_once "../controllers/ControllerCommande.php";
require_once "../controllers/ControllerConfig.php";
require_once "../controllers/ControllerDashboard.php";
require_once "../controllers/ControllerDepense.php";
require_once "../controllers/ControllerMailer.php";

// setlocale(LC_TIME, 'fr_FR.utf8', 'fra');
// $sql = self::getConnexion()->query(" SET lc_time_names = 'fr_FR' ;");

// date_default_timezone_set('Africa/Abidjan');

// Dashbord
ControllerDashboard::getAllDashboardAdmin();

// Configuration
ControllerConfig::ajouter_info();
ControllerConfig::ajouter_contact();
ControllerConfig::changeImageLogo();
ControllerConfig::loadDate();
ControllerConfig::switchClient();
ControllerConfig::switchFournisseur();
ControllerConfig::switchDelete();
ControllerConfig::switchUnite();
ControllerConfig::updateTaxe();

// Emplyer
ControllerEmploye::authentification();
ControllerEmploye::logout();
ControllerEmploye::ajouter_employe();
ControllerEmploye::modifier_login_employe();
ControllerEmploye::liste_employe();
ControllerEmploye::getEmploye();
ControllerEmploye::suppresion_employe();

// CLIENT
ControllerClient::ajouter_client();
ControllerClient::liste_client();
ControllerClient::getClient();
ControllerClient::suppresion_client();
ControllerClient::getClientForVente();

// FOURNISSEUR
ControllerFournisseur::ajouter_fournisseur();
ControllerFournisseur::liste_fournisseur();
ControllerFournisseur::getfournisseur();
ControllerFournisseur::suppresion_fournisseur();
ControllerFournisseur::get_fournisseur_info();
ControllerFournisseur::getFournisseurForAchat();


// ENTREPOT
ControllerEntrepot::ajouter_entrepot();
ControllerEntrepot::ajouter_panier_transfert();
ControllerEntrepot::getEntrepot();
ControllerEntrepot::liste_entrepot();
ControllerEntrepot::modifier_entrepot();
ControllerEntrepot::getEntrepotForTransfert();
ControllerEntrepot::changeStatutEntrepot();


// CATEGORIE
ControllerCategorie::ajouter_categorie();
ControllerCategorie::liste_categorie();
ControllerCategorie::getCategorie();
ControllerCategorie::suppresion_categorie();

// FAMILLE
ControllerFamille::ajouter_famille();
ControllerFamille::liste_famille();
ControllerFamille::getFamille();
ControllerFamille::suppresion_famille();

// MARK
ControllerMark::ajouter_mark();
ControllerMark::liste_mark();
ControllerMark::getMark();
ControllerMark::suppresion_mark();

//UNITE
ControllerUnite::ajouter_unite();
ControllerUnite::liste_unite();
ControllerUnite::getUnite();
ControllerUnite::suppresion_unite();

// ARTICLE
ControllerArticle::ajouter_article();
ControllerArticle::liste_article();
ControllerArticle::getArticle();
ControllerArticle::suppresion_article();
ControllerArticle::modalAttributionArticle();
ControllerArticle::createAntrepotArticle();

// ACHAT
ControllerAchat::ajouter_panier_achat();
ControllerAchat::ajouter_achat();
ControllerAchat::liste_detail_achat_fournisseur();
ControllerAchat::getCanvasMonthAchat();
ControllerAchat::getAchat();
ControllerAchat::suppresion_achat();
ControllerAchat::btn_remove_achat_detail();
ControllerAchat::getCanvasfournisseur();
ControllerAchat::getDataDateRangeFilterAchat();
ControllerAchat::ajouter_versement_achat();

ControllerAchat::validation_achat();
ControllerAchat::encaissement_achat();
ControllerAchat::annulation_achat();
ControllerAchat::retourner_achat();

// ControllerAchat::ajouter_depense();
// DEPENSES
ControllerDepense::ajouter_depense();
ControllerDepense::ajouter_depense();
ControllerDepense::getDataDateRangeFilterDepense();
// 
// ControllerAchat::ajouter_depense();
// ControllerAchat::getDepense();
// ControllerAchat::suppresion_depense();
// ControllerAchat::getDataDateRangeFilterDepense();

// VERSEMENT
ControllerClient::ajouter_versement();

// VENTE
ControllerVente::ajouter_panier_vente();
ControllerVente::ajouter_vente();
ControllerVente::liste_vente();
ControllerVente::liste_detail_vente_client();
ControllerVente::getVente();
ControllerVente::getEncaissementvente();
ControllerVente::verifQteArticleVente();
ControllerVente::verifDetail();
ControllerVente::suppresion_vente();
ControllerVente::btn_remove_vente_detail();
ControllerVente::getDataDateRangeFilterInventaire();
ControllerVente::ajouter_versement_vente();


ControllerVente::validation_vente();
ControllerVente::encaissement_vente();
ControllerVente::annulation_vente();
ControllerVente::retourner_vente();

ControllerVente::getCanvasMonth();
ControllerVente::getCanvasWeek();
ControllerVente::getCanvasEmployeMonth();
ControllerVente::getCanvasMontantByArticle();
ControllerVente::getCanvasCLient();
ControllerVente::getDataDateRangeFilterVente();

// COMMANDE
ControllerCommande::ajouter_panier_commande();
ControllerCommande::ajouter_commande();
ControllerCommande::valider_commande();
ControllerCommande::getcommande();
ControllerCommande::verifQteArticlecommande();
ControllerCommande::verifDetail();
ControllerCommande::suppresion_commande();
ControllerCommande::btn_remove_commande_detail();
