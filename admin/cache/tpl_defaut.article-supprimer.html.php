<div id="secondaire">
	<?php echo (isset($this->_rootref['CONTENU_SECONDAIRE'])) ? $this->_rootref['CONTENU_SECONDAIRE'] : ''; ?>
	
</div><!-- #secondaire -->

<div id="principal_large">	
	<?php if ($this->_rootref['IS_SAVECONFIRMATION']) {  ?>
		<div id="info">
			<p><img src="design/defaut/images/info.png" alt="enregistré"> <?php echo ((isset($this->_rootref['L_SAVECONFIRMATION'])) ? $this->_rootref['L_SAVECONFIRMATION'] : ((isset($this->lang['SAVECONFIRMATION'])) ? $this->lang['SAVECONFIRMATION'] : '{ SAVECONFIRMATION }')); ?>  <?php echo (isset($this->_rootref['SAVECONFIRMATION_DATE'])) ? $this->_rootref['SAVECONFIRMATION_DATE'] : ''; ?></p>
		</div>
	<?php } ?> 
	<div id="wrapper">
		<h1>Edition de l'article «&nbsp;<?php echo (isset($this->_rootref['FORM_TITRE'])) ? $this->_rootref['FORM_TITRE'] : ''; ?>&nbsp;»</h1>
		<p><?php if ($this->_rootref['IS_ONLINE']) {  ?>
			<img src="design/defaut/images/published-small.png" alt="l'article est publié (online)" title="l'article est publié (online)"/>
		<?php } else { ?>
		 <img src="design/defaut/images/unpublished-small.png" alt="L'article n'est pas publié (offline)" title="L'article n'est pas publié (offline)"/>
		<?php } if ($this->_rootref['HAS_RIGHT']) {  } else { ?>
			<img src="design/defaut/images/clef.png" alt="Droits d'accès" title="Cette page possède des droits d'accès"/>
		<?php } ?> <code><?php echo (isset($this->_rootref['FORM_ID'])) ? $this->_rootref['FORM_ID'] : ''; ?></code></p>
		<!-- <p><strong>...dans la collection d'articles : "<a href="<?php echo (isset($this->_rootref['LINK_INDEX'])) ? $this->_rootref['LINK_INDEX'] : ''; ?>"><?php echo (isset($this->_rootref['TITRE_COLLECTION'])) ? $this->_rootref['TITRE_COLLECTION'] : ''; ?></a>"</strong>&nbsp;:<br/>
		<em><?php echo (isset($this->_rootref['FORM_DESCRIPTION'])) ? $this->_rootref['FORM_DESCRIPTION'] : ''; ?></em></p> -->
		
		<ul class="tabs">
			<li><a href="<?php echo (isset($this->_rootref['LINK_INDEX'])) ? $this->_rootref['LINK_INDEX'] : ''; ?>">Index</a></li>
			<li><a href="<?php echo (isset($this->_rootref['LINK_EDITINFO'])) ? $this->_rootref['LINK_EDITINFO'] : ''; ?>">Editer les métadonnées</a></li>
			<li><a href="<?php echo (isset($this->_rootref['LINK_EDITMENU'])) ? $this->_rootref['LINK_EDITMENU'] : ''; ?>">Editer le menu</a></li>
			<li><a href="<?php echo (isset($this->_rootref['LINK_EDITDESIGN'])) ? $this->_rootref['LINK_EDITDESIGN'] : ''; ?>">Editer le design</a></li>
			<li class="selected"><a href="#">Supprimer un article</a></li>
		</ul>
	
		
		<form class="edit" name="editinfo" method="POST" action="<?php echo (isset($this->_rootref['FICHIER_CIBLE'])) ? $this->_rootref['FICHIER_CIBLE'] : ''; ?>">
			
			<fieldset class="metadonnees">
				<legend>Supprimer cet article ?</legend>
				<p> Voulez-vous vraiment supprimer cet article ???<br/>
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
	</div>
	
	<?php echo (isset($this->_rootref['CONTENU'])) ? $this->_rootref['CONTENU'] : ''; ?>
</div><!-- #principal -->