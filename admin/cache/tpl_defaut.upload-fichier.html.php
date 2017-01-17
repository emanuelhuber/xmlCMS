<script>
function create_champ(i) {
	var i2 = i + 1;
	document.getElementById('leschamps_'+i).innerHTML = '<label for="file['+i+']">Fichier :</label><br/>'
														+ '<input type="file" name="file['+i+']" id="file['+i+']"/><br/>'
														+ '<label>Nom du fichier SANS EXTENSION, optionel. Charactères autorisés: [a-z]+[0-9]; mots séparés par des tirets "-"<br/> '
														+ '<input type="text" name="fileId['+i+']" value="" size="50" maxlength="150"/></label><br/>'
														+ '<label for="title['+i+']">Titre du fichier (max 50 caractères):</label><br />'
														+ '<input type="text" name="title['+i+']" value="Titre du fichier" id="title['+i+']" /><br />'
														+ '<label for="copyright['+i+']">Copyright ou source du fichier (max 50 caractères):</label><br />'
														+ '<input type="text" name="copyright['+i+']" value="Copyright du fichier" id="copyright['+i+']" /><br />'
														+ '<label for="description['+i+']">Description de votre fichier (max 255 caractères):</label><br />'
														+ '<textarea name="description['+i+']" id="description['+i+']"></textarea><br />';
	document.getElementById('leschamps_'+i).innerHTML += (i <= 10) ? '<span id="leschamps_'+i2+'"><a href="javascript:create_champ('+i2+')">Ajouter un champ</a></span>' : '';
}
</script>


<div id="secondaire">
	<h1>Extensions autorisés</h1>
		
		<?php $_liste_count = (isset($this->_tpldata['liste'])) ? sizeof($this->_tpldata['liste']) : 0;if ($_liste_count) {for ($_liste_i = 0; $_liste_i < $_liste_count; ++$_liste_i){$_liste_val = &$this->_tpldata['liste'][$_liste_i]; ?>
		<h2><?php echo $_liste_val['NAME']; ?></h2>
		<table>
			<tr><th>Extension</th><th>Type</th></tr>
			<?php $_categorie_count = (isset($_liste_val['categorie'])) ? sizeof($_liste_val['categorie']) : 0;if ($_categorie_count) {for ($_categorie_i = 0; $_categorie_i < $_categorie_count; ++$_categorie_i){$_categorie_val = &$_liste_val['categorie'][$_categorie_i]; ?>
			<tr><td><?php echo $_categorie_val['EXT']; ?></td><td><?php echo $_categorie_val['TYPE']; ?></td></tr>
			<?php }} ?>
		</table>
		<?php }} ?>
		
		
		
	<?php echo (isset($this->_rootref['CONTENU_SECONDAIRE'])) ? $this->_rootref['CONTENU_SECONDAIRE'] : ''; ?>
</div><!-- #secondaire -->

<div id="principal">
	
<h1>Upload de fichier</h1>

<p><em>Le(s) fichier(s) ne doivent pas dépasser <?php echo (isset($this->_rootref['TAILLE_MAX_KO'])) ? $this->_rootref['TAILLE_MAX_KO'] : ''; ?> ko !</em></p>

<!-- Attention, ne de ne pas oublier le enctype="multipart/form-data" -->
	<form method="POST" action="<?php echo (isset($this->_rootref['FICHIER_CIBLE'])) ? $this->_rootref['FICHIER_CIBLE'] : ''; ?>" enctype="multipart/form-data">
		<!-- Limiter la taille des fichiers à 500Ko -->
		<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo (isset($this->_rootref['TAILLE_MAX'])) ? $this->_rootref['TAILLE_MAX'] : ''; ?>" />
		<fieldset>
			<legend>Envoi de fichiers</legend>
			<p class="avertissement"><?php echo (isset($this->_rootref['ERREUR'])) ? $this->_rootref['ERREUR'] : ''; ?></p>
			<p class="message"><?php echo (isset($this->_rootref['MESSAGE'])) ? $this->_rootref['MESSAGE'] : ''; ?></p>
			<!-- champs d'envoi de ficher, de type file -->
			<label for="file[1]">Fichier :</label><br/>
				<input type="file" name="file[1]" id="file[1]"/><br/>
			<label>Nom du fichier SANS EXTENSION, optionel. Charactères autorisés: [a-z]+[0-9]; mots séparés par des tirets "-"<br/> 
				<input type="text" name="fileId[1]" value="" size="50" maxlength="150"/></label><br/>
			<label for="title[1]">Titre du fichier (max 50 caractères):</label><br />
				<input type="text" name="title[1]" value="Titre du fichier" id="title[1]" /><br />
			<label for="copyright[1]">Copyright ou source (max 50 caractères):</label><br />
				<input type="text" name="copyright[1]" value="Copyright du fichier" id="copyright[1]" /><br />
			<label for="description[1]">Description de votre fichier (max 255 caractères):</label><br />
				<textarea name="description[1]" id="description[1]"></textarea><br />

			<span id="leschamps_2">
			<a href="javascript:create_champ(2)">
				Ajouter un fichier
			</a>
			</span>
				<!-- bouton d'envoi -->
				<p><input type="submit" name="envoi" value="Envoyer les fichiers" /></p>
			</legend>
		</fieldset>
	</form>
	
	<?php echo (isset($this->_rootref['CONTENU'])) ? $this->_rootref['CONTENU'] : ''; ?>
</div><!-- #principal -->