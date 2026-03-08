<div class="AfficherS">
	<h2>Voici la liste de tous les services avec leurs informations :</h2>
		<?php foreach($service as $s){ ?>                 <!-- Boucle pour itérer chaque service avec ses instances -->
			<br>
			<li id="AfficherS"><?= $s['libelle'] ?> : <br>  &nbsp;  Description du service : <?= $s['descriptionS'] ?><br>  &nbsp;  Ouverture du service : <?= $s['ouverture'] ?>
			<br>  &nbsp;  Législation du service : <?= $s['legislation'] ?></li>
			<br>
	<?php  }
?>
</div>
