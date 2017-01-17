<div id="secondaire">
	<?php echo (isset($this->_rootref['CONTENU_SECONDAIRE'])) ? $this->_rootref['CONTENU_SECONDAIRE'] : ''; ?>
</div><!-- #secondaire -->

<div id="principal">
	
	<h1>Ajouter une langue</h1>

	
	<form class="edit" name="editpage" method="POST" action="<?php echo (isset($this->_rootref['FICHIER_CIBLE'])) ? $this->_rootref['FICHIER_CIBLE'] : ''; ?>">
		<fieldset class="rubrique">
			<legend>Ajouter une langue</legend>
			<p><label>Langue (par exemple "Français") <input type="text" name="langue[name]" value="" size="10" maxlength="50"/></label></p>
			<p><label>ID (par example "fr") <input type="text" name="langue[id]" value="" size="3" maxlength="3"/></label></p>
		</fieldset>
		<input type="submit" name="nom" value="OK"/>
	</form>
	
	<?php echo (isset($this->_rootref['CONTENU'])) ? $this->_rootref['CONTENU'] : ''; ?>
</div><!-- #principal -->