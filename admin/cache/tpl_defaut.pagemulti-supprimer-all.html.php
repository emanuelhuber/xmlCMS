<div id="secondaire">
	<?php echo (isset($this->_rootref['CONTENU_SECONDAIRE'])) ? $this->_rootref['CONTENU_SECONDAIRE'] : ''; ?>
	
</div><!-- #secondaire --><?php if ($this->_rootref['IS_SAVECONFIRMATION']) {  ?>
	<div id="info">
		<p><img src="design/defaut/images/info.png" alt="enregistré"> <?php echo ((isset($this->_rootref['L_SAVECONFIRMATION'])) ? $this->_rootref['L_SAVECONFIRMATION'] : ((isset($this->lang['SAVECONFIRMATION'])) ? $this->lang['SAVECONFIRMATION'] : '{ SAVECONFIRMATION }')); ?>  <?php echo (isset($this->_rootref['SAVECONFIRMATION_DATE'])) ? $this->_rootref['SAVECONFIRMATION_DATE'] : ''; ?></p>
	</div>
<?php } ?> 

<div id="principal">
	<h1>
		<?php if ($this->_rootref['HAS_RIGHT']) {  ?>
			<img src="design/defaut/images/clef.png" alt="Droits d'accès" title="Cette page possède des droits d'accès"/>
		<?php } ?> 
		Suppression de la page «&nbsp;<?php echo (isset($this->_rootref['FORM_TITRE'])) ? $this->_rootref['FORM_TITRE'] : ''; ?>&nbsp;»
		</h1>
		
		<form class="edit" name="editinfo" method="POST" action="<?php echo (isset($this->_rootref['FICHIER_CIBLE'])) ? $this->_rootref['FICHIER_CIBLE'] : ''; ?>">
			
			<fieldset class="metadonnees">
				<legend>Supprimer cette page ?</legend>
				<p> Voulez-vous vraiment supprimer cette page ???<br/>
					<strong>Titre</strong> : <?php echo (isset($this->_rootref['FORM_TITRE'])) ? $this->_rootref['FORM_TITRE'] : ''; ?> <br/>
					<strong>ID</strong> : <code>[<?php echo (isset($this->_rootref['FORM_ID'])) ? $this->_rootref['FORM_ID'] : ''; ?>]</code>  <br/>
					<strong>Auteur</strong> : <?php echo (isset($this->_rootref['FORM_AUTEUR'])) ? $this->_rootref['FORM_AUTEUR'] : ''; ?> <br/>
					<strong>Description</strong> : <?php echo (isset($this->_rootref['FORM_DESCRIPTION'])) ? $this->_rootref['FORM_DESCRIPTION'] : ''; ?> <br/>
					<strong>Mots-clefs</strong> : <?php echo (isset($this->_rootref['FORM_MOTSCLEFS'])) ? $this->_rootref['FORM_MOTSCLEFS'] : ''; ?> <br/>
					<?php if ($this->_rootref['HAS_RIGHT']) {  ?>
					<strong>Droits</strong> : <?php echo (isset($this->_rootref['RIGHT_NAME'])) ? $this->_rootref['RIGHT_NAME'] : ''; ?>
					<?php } ?>
				</p>
				<p><label><input type="radio" name="ok" value="ok"/>Oui</label><br/>
				<label><input type="radio" name="ok" value="cancel" checked="checked"/>Non</label><br/></p>
				
			</fieldset>

			<input type="reset" name="nom" value="" class="refresh" />
			<input type="image" name="nom" src="design/defaut/images/save.png"  alt="Enregistrer" />
			<!-- <a href="<?php echo (isset($this->_rootref['LIEN_APERCU'])) ? $this->_rootref['LIEN_APERCU'] : ''; ?>" title="Aperçu"><img src="design/defaut/images/apercu.png" alt="Aperçu"/></a> -->
		</form>
	
	<?php echo (isset($this->_rootref['CONTENU'])) ? $this->_rootref['CONTENU'] : ''; ?>
</div><!-- #principal -->