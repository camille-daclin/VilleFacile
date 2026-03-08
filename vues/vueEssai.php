<div class="Affichage">
	<h2>Générer une période d'essai</h2>

	<form method="post" action="#">
		<label for="departement">Numéro du département : </label>
		<Select name="departement">
			<option selected>--Choisir un département--</option>
			<?php foreach($listeDepartement as $ld) { ?>
					<option value="<?php echo $ld['code_InseeD'] ; ?>">
						<?php echo $ld['nomD']." | ". $ld['code_InseeD']; ?>
					</option>
				<?php } ?>
		</select>
		<br/><br/>
		<label for="mois_max">Nombre de mois max : </label>
			<select name="mois_max" id="mois_max" required >
				<option value="Pas de limite choisi">Pas de limite choisi</option>
				<option value="3">3</option>
				<option value="4">4</option>
			</select>
		<br/><br/>
		<input type="submit" name="boutonValider" id="boutonA" value="Générer"/>
	</form>	
</div>
<?php echo $message; ?>



