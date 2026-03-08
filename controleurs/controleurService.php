<?php 
$service = getInstances($connexion, "Service");                          //Récupération des instances de la table Service dans la BDD
if (count($service) == 0) {                                              //Si aucun service n'est trouvé alors on affiche un message
		echo "Aucun service n'a été trouvé dans la base de données";
    }
?>
