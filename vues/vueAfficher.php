<!-- Nombre d'instances dans 3 tables : ici Service, Commune et Région -->
<h2>Nombres d'instances dans la table Service :</h2>
<ul>
<?php
	$compteServ=NbInstances($connexion,"Service");
	echo "Il y a $compteServ instances dans la table Services.";
?>							
</ul>

<h2>Nombres d'instances dans la table Commune :</h2>
<ul>
<?php
	$compteCom=NbInstances($connexion,"Commune");
	echo "Il y a $compteCom instances dans la table Commune.";
?>							
</ul>

<h2>Nombres d'instances dans la table Région :</h2>
<ul>
<?php
	$compteReg=NbInstances($connexion,"Region");
	echo "Il y a $compteReg instances dans la table Region.";
?>							
</ul>
 

<!-- AFFICHAGE DES INFORMATIONS DANS LES BALISES h2 -->

<h2>Liste des enfants :</h2>
<ul>
<?php foreach($InstancesEnfant as $enfant) { ?>
	<li><?= $enfant['nomE'] ?> <?= $enfant['prenomE'] ?> (#<?= $enfant['nomEcole'] ?>)</li>
<?php } ?>
</ul>


<h2>Liste des enfants avec le nom de la cantine où ils mangeront le 1 janvier 2024 :</h2>
<ul>
	<?php foreach($tableEnfantCantine as $tableEnCA) { ?>
		<li><?= $tableEnCA['nomE'] ?> <?= $tableEnCA['prenomE'] ?> <?= $tableEnCA['nomCa'] ?></li>
	<?php } ?>
</ul>


<h2>Paires d'enfants ayant les mêmes nom et prénom, mais inscrits dans des écoles différentes :</h2>
<ul>
	<?php foreach($tablePaireEnfant as $tablePaEn) { ?>
		<li><?= $tablePaEn['nomE'] ?> <?= $tablePaEn['prenomE'] ?> <?= $tablePaEn['nomEcole'] ?></li>
	<?php } ?>
</ul>


<h2>Voici le Top 3 des départements ayant le plus de communes :</h2>
<ul>
<?php
	$compteur=0;
?>
	<?php foreach($tableTOP3Departements as $tableDeCo) { ?>
		 <?php $compteur=$compteur+1 ?>
		 <li><?php echo "$compteur : ";?><?= $tableDeCo['nomD']?> (<?= $tableDeCo['NombreDeCommunes']?> communes)</li>
	<?php } ?>
</ul>


<h2>Voici le Top 3 des services les plus demandés :</h2>
<ul>
<?php
	$compteur=0;
?>
	<?php foreach($tableTOP3ServiceDemande as $tableSeDe) { ?>
		 <?php $compteur=$compteur+1 ?>
		 <li><?php echo "$compteur : ";?><?= $tableSeDe['libelle']?> (<?= $tableSeDe['nombre_demande']?> demandes)</li>
	<?php } ?>
</ul>


<h2>Voici le Top 3 des services les plus proposés par les communes :</h2>
<ul>
<?php
	$compteur=0;
?>
	<?php foreach($tableTOP3ServicePropose as $tableSePo) { ?>
		 <?php $compteur=$compteur+1 ?>
		 <li><?php echo "$compteur : ";?><?= $tableSePo['libelle']?> (<?= $tableSePo['nombre_service']?> propositions)</li>
	<?php } ?>
</ul>




