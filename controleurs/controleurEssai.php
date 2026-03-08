<?php
integrer($connexion);
$message="";	// on le met avant la validation du formulaire sinon dans vue.Essai.php il ne connaît pas la variable $message
if(isset($_POST['boutonValider'])) { // formulaire soumis

	$departement=$_POST['departement'];		// donnée du formulaire
	$mois_max=$_POST['mois_max'];			// donnée du formulaire
	$services=ServicesRandom($connexion);	// on choisit les services aléatoirement
	$messageServices="";					// variable qui nous servira plus tard pour l'affichage
	$messageCommunes="";					// variable qui nous servira plus tard pour l'affichage


	// CHOIX DES COMMUNES A L'AIDE DU DEPARTEMENT OU NON
	if($departement == "--Choisir un département--"){
		$communes=CommunesRandom($connexion);
	}
	else{
		$communes=CommunesRandomDep($connexion,$departement);
	}


	// LA DUREE DE LA PERIODE D'ESSAI
	if($mois_max == "Pas de limite choisi"){
		$choix = array(			//
		'3',					//
		'4',					// création d'une liste avec les différents choix possibles
		'6'						//
		);						//
		$total = count($choix);	// nombre d'élément dans la liste
		$nb = mt_rand(0, $total-1);	// nb tiré alétoirement
		$mois_max=$choix[$nb];
	}
	if($mois_max == 4){
		$choix = array(
		'3',
		'4'
		);
		$total = count($choix);
		$nb = mt_rand(0, $total-1);
		$mois_max=$choix[$nb];
	}
	//pour les autres cas ils se font sans avoir besoin d'être précisé ( 6 <=> pas de limite   |   3 <=> limite = 3 donc on change pas )


	// PARTIE SUR L'INSERTION DANS LA TABLE 'Periode_Essai'
	foreach ($services as $ser){
		foreach ($communes as $com){
			$insert = insertPeriodeEssai($connexion, $ser['libelle'], $mois_max." mois", $com['nomCo']);
			if (!$insert) {
				echo "Erreur lors de l'insertion : " . mysqli_error($connexion) . "<br>";	// si l'insertion ne marche pas on va renvoyer un message d'erreur
			}
		}
	}


	// PARTIE SUR L'AFFICHAGE DES INFORMATIONS
	foreach ($communes as $com){
		$messageCommunes=$messageCommunes.$com['nomCo'].", ";	// on concatène les différentes communes
	}
	foreach ($services as $ser){
		$messageServices=$messageServices.$ser['libelle'].", ";	// on concatène les différents services
	}
	// message final :
	if($departement == "--Choisir un département--"){
		$message="La période d'essai de la région Auvergne-Rhône-Alpes concernera les services $messageServices. Elle a été mise en place dans les communes : $messageCommunes pour une durée de $mois_max mois.";
	}
	else{
	$message="La période d'essai du département n°$departement concernera les services $messageServices. Elle a été mise en place dans les communes : $messageCommunes pour une durée de $mois_max mois.";
	}
}

$listeDepartement = getInstances($connexion, 'Departement') ;
?>
