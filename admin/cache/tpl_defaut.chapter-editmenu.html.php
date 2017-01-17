<?php if ($this->_rootref['IS_SAVECONFIRMATION']) {  ?>
	<div id="info">
		<p><img src="design/defaut/images/info.png" alt="enregistré"> <?php echo ((isset($this->_rootref['L_SAVECONFIRMATION'])) ? $this->_rootref['L_SAVECONFIRMATION'] : ((isset($this->lang['SAVECONFIRMATION'])) ? $this->lang['SAVECONFIRMATION'] : '{ SAVECONFIRMATION }')); ?>  <?php echo (isset($this->_rootref['SAVECONFIRMATION_DATE'])) ? $this->_rootref['SAVECONFIRMATION_DATE'] : ''; ?></p>
	</div>
<?php } ?> 

<div id="principal">
	<div id="wrapper">
		<h1>Edition du nom du chapitre "<?php echo (isset($this->_rootref['FORM_TITRE'])) ? $this->_rootref['FORM_TITRE'] : ''; ?>"</h1>
		<p>(id = <code><?php echo (isset($this->_rootref['FORM_ID'])) ? $this->_rootref['FORM_ID'] : ''; ?></code>)</p>

		<form class="edit" name="editMenu" method="POST" action="<?php echo (isset($this->_rootref['FICHIER_CIBLE'])) ? $this->_rootref['FICHIER_CIBLE'] : ''; ?>">
			
			<fieldset class="rubrique">
				<legend>Chapitre</legend>
				<p>	<label>Nom du chapitre dans le menu <br/><input type="text" name="rubrique[nom]" value="<?php echo (isset($this->_rootref['NOM'])) ? $this->_rootref['NOM'] : ''; ?>" size="50" maxlength="150"/></label></p>
			</fieldset>
			<input type="reset" name="nom" value="" class="refresh" />
			<input type="image" name="nom" src="design/defaut/images/save.png"  alt="Enregistrer" />
		</form>
	</div><!-- #wrapper -->

</div><!-- #principal -->