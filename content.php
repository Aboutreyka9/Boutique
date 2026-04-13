<?php
switch (@$_GET['pg']) {

	// BLOC EMPLOYER
	case 'employe':
		include 'views/employe.php';
		break;
	case 'profile':
		include 'views/accueil.php';
		break;
	case 'profile_employe':
		include 'views/profile.php';
		break;
	case 'parametre':
		include 'views/parametre.php';
		break;
	case 'configuration':
		include 'views/configuration.php';
		break;
	// BLOC CLIENT
	case 'client':
		include 'views/client.php';
		break;
	case 'client_profile':
		include 'views/client_profile.php';
		break;
	// FOURNISSEUR
	case 'fournisseur':
		include 'views/fournisseur.php';
		break;
	case 'fournisseur_profile':
		include 'views/fournisseur_profile.php';
		break;
	// BLOC CATEGORIE
	case 'categorie':
		include 'views/categorie.php';
		break;
	// FAMILLE
	case 'famille':
		include 'views/famille.php';
		break;
	// MARK
	case 'mark':
		include 'views/mark.php';
		break;

	// UNITE
	case 'unite':
		include 'views/unite.php';
		break;

	// ARTICLE
	case 'article':
		include 'views/article.php';
		break;

	// Achat
	case 'achat':
		include 'views/achat.php';
		break;
	case 'ajouter_achat':
		include 'views/ajouter_achat.php';
		break;
	case 'detail_achat':
		include 'views/detail_achat.php';
		break;
	case 'approvision':
		include 'views/approvision.php';
		break;
	case 'view_achat_by_article':
		include 'views/view_achat_by_article.php';
		break;
	case 'depense':
		include 'views/depense.php';
		break;

	// VENTE
	case 'vente':
		include 'views/vente.php';
		break;
	case 'ajouter_vente':
		include 'views/ajouter_vente.php';
		break;
	case 'detail':
		include 'views/detail.php';
		break;
	case 'retour':
		include 'views/retour.php';
		break;
	case 'view_vente_by_article':
		include 'views/view_vente_by_article.php';
		break;

	// AUDIT CORRECTION
	case 'audit':
		include 'views/audit.php';
		break;
	//case 'ajouter_vente': include 'views/ajouter_vente.php';break;
	//case 'detail': include 'views/detail.php';break;
	//case 'retour': include 'views/retour.php';break;
	//case 'view_vente_by_article': include 'views/view_vente_by_article.php';break;

	// RESERVATION
	case 'commande':
		include 'views/commande.php';
		break;
	case 'commande_detail':
		include 'views/commande_detail.php';
		break;

	// INVENTAIRE
	case 'inventaire':
		include 'views/inventaire.php';
		break;

	// ENTREPOT
	case 'entrepot':
		include 'views/entrepot.php';
		break;
	case 'detail_entrepot':
		include 'views/detail_entrepot.php';
		break;

	// HISTARIQUE
	case 'hist_vente':
		include 'views/hist_vente.php';
		break;
	case 'hist_achat':
		include 'views/hist_achat.php';
		break;

	// CORBEILLE
	case 'arc_emplye':
		include 'views/arc_emplye.php';
		break;
	case 'arc_fournisseur':
		include 'views/arc_fournisseur.php';
		break;
	case 'arc_client':
		include 'views/arc_client.php';
		break;
	case 'arc_categorie':
		include 'views/arc_categorie.php';
		break;
	case 'arc_mark':
		include 'views/arc_mark.php';
		break;
	case 'arc_famille':
		include 'views/arc_famille.php';
		break;
	case 'arc_achat':
		include 'views/arc_achat.php';
		break;
	case 'arc_vente':
		include 'views/arc_vente.php';
		break;

	case 'test':
		include 'views/test.php';
		break;

	case 'dashbord':
		include 'views/dashbord.php';
		break;

	case '/':
		include 'views/dashbord.php';
		break;
	case 'transfert':
		include 'views/transfert.php';
		break;


	default:
		include 'views/404.php';
		break;
}
