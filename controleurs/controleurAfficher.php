 <?php 
$message = "";

// recupération de la table Service
$InstancesServices = getInstances($connexion, "Service");
if($InstancesServices == null || count($InstancesServices) == 0) {
	$message .= "Aucun service n'a été trouvé dans la base de données !";
}


// recupération dela table Enfant
$InstancesEnfant = getInstances($connexion, "inscrit");
if($InstancesEnfant == null || count($InstancesEnfant) == 0) {
	$message .= "Aucun enfant n'a été trouvé dans la base de données !";
}


// création d'une table Enfant x mange pour pouvoir afficher les informations que l'on souhaite 
$requeteEnCa = "SELECT T.nomE,T.prenomE,T.nomCa FROM (SELECT * FROM Enfant e NATURAL JOIN mange m) as T";
$resEnCa = mysqli_query($connexion, $requeteEnCa);
$tableEnfantCantine = mysqli_fetch_all($resEnCa, MYSQLI_ASSOC);


// création d'une table avec uniquement les paires d'enfants avec les mêmes noms et prénoms mais inscrits dans différentes écoles
$requetePaEn = "SELECT  i1.nomE, i1.prenomE, i1.nomEcole FROM inscrit i1 INNER JOIN inscrit i2 ON i1.nomE = i2.nomE AND i1.prenomE = i2.prenomE WHERE i1.nomEcole <> i2.nomEcole ORDER BY i1.nomE, i1.prenomE";
$resPaEn = mysqli_query($connexion, $requetePaEn);
$tablePaireEnfant = mysqli_fetch_all($resPaEn, MYSQLI_ASSOC);


// création d'une table faisant le Top 3 des département ayant le plus de communenes 
$requeteDeCo = "SELECT nomD, NombreDeCommunes FROM Departement d INNER JOIN (SELECT SUBSTRING(code_postal, 1, LENGTH(code_postal) - 3) AS dep, COUNT(*) AS NombreDeCommunes FROM Commune GROUP BY dep ORDER BY NombreDeCommunes DESC) as T WHERE d.code_InseeD=T.dep LIMIT 3;";
$resDeCo = mysqli_query($connexion, $requeteDeCo);					// SUBSTRING(code_postal, 1, LENGTH(code_postal) - 3) => permet de prendre tous les caractères de code_postal sauf les 3 derniers
$tableTOP3Departements = mysqli_fetch_all($resDeCo, MYSQLI_ASSOC);


// création d'une table faisant le top 3 des services les plus demandés
$requeteSeDe = "SELECT s.libelle, COUNT(d.libelle) as nombre_demande FROM Demande d RIGHT JOIN Service s on d.libelle=s.libelle GROUP BY d.libelle ORDER BY nombre_demande DESC LIMIT 3;";
$resSeDe = mysqli_query($connexion, $requeteSeDe);
$tableTOP3ServiceDemande = mysqli_fetch_all($resSeDe, MYSQLI_ASSOC);


// création d'une table faisant le top 3 des services les plus proposés par les communes
$requeteSePo = "SELECT p1.libelle, COUNT(p1.libelle) as nombre_service FROM propose p1 NATURAL JOIN propose p2 GROUP BY p1.libelle ORDER BY nombre_service DESC LIMIT 3;";
$resSePo = mysqli_query($connexion, $requeteSePo);
$tableTOP3ServicePropose = mysqli_fetch_all($resSePo, MYSQLI_ASSOC);
?>
