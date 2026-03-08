<div class="Affichage">
	<h2>Ajout d'un service</h2>
	<p>Vous pouvez ajouter un service, s'il n'existe pas déjà, <br>ou bien ajouter un service à une ou plusieurs communes.</p>
	<br>
	<form method="post" action="#">                                      <!--Formulaire pour récupérer toutes les informations que l'on souhaite -->
		<label for="libelle">Nom du service: </label>
		<input type="text" name="libelle" id="libelle" placeholder="Election" required />
		<br/><br/>
		<label for="description">Description: </label>
		<input type="text" name="description" id="description" placeholder="Que fait le service ?" />
		<br/><br/>
		<label for="ouverture">Ouverture: </label>
		<input type="text" name="ouverture" id="ouverture" placeholder="Horaires" required />
		<br/><br/>
		<label for="legislation">Législation </label>
			<select name="legislation" id="legislation" required >
				<option value="" disabled selected>Gratuit ou payant</option>
				<option value="gratuit">Gratuit</option>
				<option value="payant">Payant</option>
			</select>
		<br/><br/>
		<label for="communes">Nom de la commune : </label>
			<Select name="communes[]" id="communes" multiple size="5">
				<option selected>--Choisir une commune--</option>
				<?php foreach($listeCommune as $lc) { ?>                    <!-- Boucle permettant d'afficher dans le menu chaque nom de commune -->
					<option value="<?php echo $lc['nomCo'] ; ?>">
						<?php echo $lc['nomCo'] ; ?>
					</option>
				<?php } ?>
			</select>
		<br/><br/>
		<input type="submit" name="boutonValider" id="boutonA" value="Ajouter"/>
	</form>
	<?php if(isset($message)) { ?>
		<p style="background-color: #B0C4DE ;margin-top:1em;"><?= $message ?></p>
	<?php } ?>

</div>
