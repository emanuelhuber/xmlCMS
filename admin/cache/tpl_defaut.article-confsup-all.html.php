<div id="secondaire">
	<?php echo (isset($this->_rootref['CONTENU_SECONDAIRE'])) ? $this->_rootref['CONTENU_SECONDAIRE'] : ''; ?>
	
</div><!-- #secondaire -->

<div id="principal">	
	<?php if ($this->_rootref['IS_SAVECONFIRMATION']) {  ?>
		<div id="info">
			<p><img src="design/defaut/images/info.png" alt="enregistré"> <?php echo ((isset($this->_rootref['L_SAVECONFIRMATION'])) ? $this->_rootref['L_SAVECONFIRMATION'] : ((isset($this->lang['SAVECONFIRMATION'])) ? $this->lang['SAVECONFIRMATION'] : '{ SAVECONFIRMATION }')); ?>  <?php echo (isset($this->_rootref['SAVECONFIRMATION_DATE'])) ? $this->_rootref['SAVECONFIRMATION_DATE'] : ''; ?></p>
		</div>
	<?php } ?> 
	<div id="wrapper">
	<h1>Confirmation de suppression de la collection d'articles "<?php echo (isset($this->_rootref['FORM_TITRE'])) ? $this->_rootref['FORM_TITRE'] : ''; ?>"</h1>

		<p> Confirmation de suppression de cette collection d'articles :<br/>
			<strong>Titre</strong> : <?php echo (isset($this->_rootref['FORM_TITRE'])) ? $this->_rootref['FORM_TITRE'] : ''; ?> <br/>
			<strong>ID</strong> : <code>[<?php echo (isset($this->_rootref['FORM_ID'])) ? $this->_rootref['FORM_ID'] : ''; ?>]</code>  <br/>
			<strong>Auteur</strong> : <?php echo (isset($this->_rootref['FORM_AUTEUR'])) ? $this->_rootref['FORM_AUTEUR'] : ''; ?> <br/>
			<strong>Description</strong> : <?php echo (isset($this->_rootref['FORM_DESCRIPTION'])) ? $this->_rootref['FORM_DESCRIPTION'] : ''; ?> <br/>
			<strong>Mots-clefs</strong> : <?php echo (isset($this->_rootref['FORM_MOTSCLEFS'])) ? $this->_rootref['FORM_MOTSCLEFS'] : ''; ?> <br/>
			<strong>Nombre d'articles</strong> : <?php echo (isset($this->_rootref['NB_ARTICLES'])) ? $this->_rootref['NB_ARTICLES'] : ''; ?> <br/>
			<?php if ($this->_rootref['HAS_RIGHT']) {  ?>
			<strong>Droits</strong> : <?php echo (isset($this->_rootref['RIGHT_NAME'])) ? $this->_rootref['RIGHT_NAME'] : ''; ?>
					<?php } ?>
		</p>
	</div>		
	<?php echo (isset($this->_rootref['CONTENU'])) ? $this->_rootref['CONTENU'] : ''; ?>
</div><!-- #principal -->