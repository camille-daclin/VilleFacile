<?php 

// connexion à la BD, retourne un lien de connexion
function getConnexionBD() {
	$connexion = mysqli_connect(SERVEUR, UTILISATRICE, MOTDEPASSE, BDD);
	if (mysqli_connect_errno()) {
	    printf("Échec de la connexion : %s\n", mysqli_connect_error());
	    exit();
	}
	mysqli_query($connexion,'SET NAMES UTF8'); // noms en UTF8
	return $connexion;
}


// déconnexion de la BD
function deconnectBD($connexion) {
	mysqli_close($connexion);
}


// retourne les instances d'une table $nomTable
function getInstances($connexion, $nomTable) {
	$requete = "SELECT * FROM $nomTable";
	$res = mysqli_query($connexion, $requete);
	$instances = mysqli_fetch_all($res, MYSQLI_ASSOC);
	return $instances;
}

//Fonction pour récupérer les instances de communes, triés par nom de commune, utilisé plus tard pour récupérer les noms de chaque commune
function getNomCo($connexion, $nomTable) {
	$requete = "SELECT * FROM $nomTable ORDER BY nomCo;";
	$res = mysqli_query($connexion, $requete);
	$instances = mysqli_fetch_all($res, MYSQLI_ASSOC);
	return $instances;
}


// fonction qui revoie le nombre de lignes dans la table
function NbInstances($connexion, $nomTable){
	$compteurNbInstances=0;
	$InstancesTable = getInstances($connexion, $nomTable);
	foreach($InstancesTable as $inst){
		$compteurNbInstances=$compteurNbInstances+1;
	}
	return $compteurNbInstances;
}


//Fonction d'intégration, afin d'intégrer la BDD dataset.Communes
function integrer($connexion){
	// Requête pour récupérer toutes les lignes de la table dataset.Communes où la région est égal à Auvergne Rhône-Alpes
	$requete = "SELECT * FROM dataset.Communes WHERE code_region=84;";
	$res = mysqli_query($connexion,$requete);
	$instances = mysqli_fetch_all($res, MYSQLI_ASSOC) ;
	$reqRegion = "INSERT INTO Region VALUES ";
	$reqDepartement = "INSERT INTO Departement VALUES ";
	$reqCommune = "INSERT INTO Commune VALUES ";
	
	// Initialisation des tableaux qui vont servir à vérifier si les données ont déjà été ajoutées
	$departementVerif = array ();
	$communeVerif = array ();
	$regionVerif = array();
	
	foreach ($instances as $i){
		//Echappement afin d'éviter les erreurs potentiels
		$commune = mysqli_escape_string($connexion,$i['nom_commune_complet']);
		$region = mysqli_escape_string($connexion,$i['nom_region']);
		$departement = mysqli_escape_string($connexion,$i['nom_departement']);
		
		// Vérification et insertion des régions, départements et communes si elles n'ont pas déjà été ajoutées
		if(!in_array($i['code_region'],$regionVerif)){
			$reqRegion .= " ('$region' , '" .$i['code_region']. "'),";
			$regionVerif[] = $i['code_region'];
		}
		if(!in_array($i['code_departement'],$departementVerif)){
			$reqDepartement .= " ('$departement', '" .$i['code_departement']. "'),";
			$departementVerif[] = $i['code_departement'];
		}
		if(!in_array($i['code_commune_INSEE'],$communeVerif)){
			$reqCommune .= " ('" .$i['code_commune']. "', '" .$i['code_postal']. "', '$commune','(" .$i['latitude']. ", " .$i['longitude']. ")', '" .$i['code_commune_INSEE']. "'),";
			$communeVerif[] = $i['code_commune_INSEE'];
		}

		
	}
	    // On remplace la virgule finale par un point virgule pour finir la requête
		$longueurRegion = strlen($reqRegion);
		$nouvelleRegion = substr_replace($reqRegion, ";", $longueurRegion - 1, 1);

		$longueurDepartement = strlen($reqDepartement);
		$nouveauDepartement= substr_replace($reqDepartement, ";", $longueurDepartement - 1, 1);

		$longueurCommune = strlen($reqCommune);
		$nouvelleCommune = substr_replace($reqCommune, ";", $longueurCommune - 1, 1);

		//On exécute les requête dans la BDD
		$resRegion = mysqli_query($connexion,$nouvelleRegion);
		$resDepartement = mysqli_query($connexion,$nouveauDepartement);
		$resCommune = mysqli_query($connexion,$nouvelleCommune);
}


// retourne les informations sur le service $libelle
function getService($connexion, $libelle) {
	$libelle = mysqli_real_escape_string($connexion, $libelle); 										// sécurisation de $libelle
	$requete = "SELECT * FROM Service WHERE libelle = '". $libelle . "'";
	$res = mysqli_query($connexion, $requete);
	$service = mysqli_fetch_all($res, MYSQLI_ASSOC);
	return $service;
}


// insère un nouveau service 
function insertService($connexion, $libelle,$description,$ouverture,$legislation) {
	$libelle = mysqli_real_escape_string($connexion, $libelle); 										// au cas où cela provient d'un formulaire
	$requete = "INSERT INTO Service VALUES ('". $libelle . "','". $description . "','". $ouverture . "','". $legislation . "')";
	$res = mysqli_query($connexion, $requete);
	return $res;
}


//Permet d'insérer un service à une commune
function insertPropose($connexion, $libelle,$nomC) {
	$libelle = mysqli_real_escape_string($connexion, $libelle); 										// au cas où cela provient d'un formulaire
	$nomC = mysqli_real_escape_string($connexion, $nomC);
	$idc = "SELECT code_InseeCo FROM Commune WHERE nomCo = '". $nomC ."'";
	$resIDC = mysqli_query($connexion, $idc);
	if ($resIDC){
		$resIDC = mysqli_fetch_all($resIDC,MYSQLI_ASSOC);
		$requete = "INSERT INTO propose VALUES ('". $libelle . "','". $resIDC[0]['code_InseeCo'] . "')";
		$res = mysqli_query($connexion, $requete);
		return $res;
	}
	return $resIDC;
}


//Permet d'insérer un service à une commune pour une période donnée
function insertPeriodeEssai($connexion, $libelle, $mois_max, $nomCommune) {
	$libelle = mysqli_real_escape_string($connexion, $libelle); 										// au cas où cela provient d'un formulaire
	$nomCommune = mysqli_real_escape_string($connexion, $nomCommune);
	$mois_max = mysqli_real_escape_string($connexion, $mois_max);
	$requete = "INSERT INTO Periode_Essai VALUES ('".$libelle ."','". $mois_max ."','". $nomCommune ."')";	// requête qui insère les différentes valeurs dans la table 'Periode_Essai'
	$res = mysqli_query($connexion, $requete);
	return $res;
	
}


//Fonction qui permet de chercher si un service est déjà proposer par une commune ou non
function search($connexion, $commune,$libelle) {
	$commune = mysqli_real_escape_string($connexion, $commune);      // au cas où cela provient d'un formulaire
	$libelle = mysqli_real_escape_string($connexion, $libelle);
	$idc = "SELECT code_InseeCo FROM Commune WHERE nomCo = '". $commune ."'";
	$resIDC = mysqli_query($connexion, $idc);
	if($resIDC){
		$resIDC = mysqli_fetch_all($resIDC,MYSQLI_ASSOC);
		$requete = "SELECT * FROM propose WHERE idc='". $resIDC[0]['code_InseeCo'] ."' AND libelle='". $libelle ."'";
		$res = mysqli_query($connexion, $requete);
		if($res){
			$instances = mysqli_fetch_all($res, MYSQLI_ASSOC);
			return $instances;
		}
		return $res;
	}
	return $resIDC;
}


function CommunesRandomDep($connexion, $departement){
	$NbCommunes = rand(5, 20);
	
	// on choisit àléatoirement entre 5 et 20 un nombre de commune parmi la table Commune ou le departement correspond au code postal des communes
	$reqFinale = "SELECT nomCo FROM Commune WHERE code_postal LIKE '{$departement}___' ORDER BY RAND() LIMIT $NbCommunes;";
	$resFinale = mysqli_query($connexion, $reqFinale);
	$tableFinale = mysqli_fetch_all($resFinale, MYSQLI_ASSOC);
	return $tableFinale;
}


function CommunesRandom($connexion){
	$NbCommunes = rand(5, 20);
	
	//on choisit aléatoirement entre 5 et 20 un nombre de commune parmi la table Commune
	$reqfinale = "SELECT nomCo FROM Commune ORDER BY rand() LIMIT $NbCommunes";
	$resfinale = mysqli_query($connexion, $reqfinale);
	$tablefinale = mysqli_fetch_all($resfinale, MYSQLI_ASSOC);
	return $tablefinale;
}


function ServicesRandom($connexion){
	$NbServices = rand(3, 5);
	
	//on choisit aléatoirement entre 3 et 5 un nombre de service parmi la table service
	$reqservice = "SELECT libelle FROM Service ORDER BY rand() LIMIT $NbServices";
	$resservice = mysqli_query($connexion, $reqservice);
	$tableservice = mysqli_fetch_all($resservice, MYSQLI_ASSOC);
	return $tableservice;
}

?>
