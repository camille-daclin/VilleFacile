<?php 
integrer($connexion);
if(isset($_POST['boutonValider'])) { // formulaire soumis

	$libelle = $_POST['libelle'];           //
	$description=$_POST['description'];     //
	$ouverture = $_POST['ouverture'];       //        Récupère les données du formmualaire soumis
	$legislation=$_POST['legislation'];     //
	$communes =$_POST['communes'];          //
	$message="";                            // Initialisation de la variable message
	
	
	$verification = getService($connexion, $libelle);  //Vérifie si le service existe déjà dans la BDD
	foreach($communes as $c){
		if($c != "--Choisir une commune--"){           //Si on a selctionnée une commune on vérifie qu'elle ne propose pas déjà ce service
			$s=search($connexion,$c,$libelle);

		// Si le service n'est pas déjà rattaché à cette commune, insertion
		if(!$s){ 
				$insert = insertPropose($connexion,$libelle,$c);
				if($insert == TRUE) {
						$message .=  "Le service $libelle a bien été rattachée à la commune $c !<br>";
						}
				}
		else{
			$message .=  "Ce service est déjà rattachée à $c. <br>";
			}
		}		
	}
	
	// Pas de service avec ce nom, insertion
	if(!$verification){ 
				$insertion=insertService($connexion,$libelle,$description,$ouverture,$legislation);
				$message .= "\nLe Service $libelle a bien été ajouté.\n";
		}
		else if($c == "--Choisir une commune--"){
			$message .= "Ce service existe déjà\n";
		}
}	
	
$listeCommune = getNomCo($connexion, 'Commune') ;             //On récupère le nom de toutes les communes

?>
