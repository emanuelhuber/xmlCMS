<div id="secondaire">
	<h1>LISTE DES BLOCS</h1>
	<?php $_blocs_count = (isset($this->_tpldata['blocs'])) ? sizeof($this->_tpldata['blocs']) : 0;if ($_blocs_count) {for ($_blocs_i = 0; $_blocs_i < $_blocs_count; ++$_blocs_i){$_blocs_val = &$this->_tpldata['blocs'][$_blocs_i]; ?>
		<h2><?php echo $_blocs_val['ID']; ?>.
			<a href="<?php echo $_blocs_val['LINK_EDIT']; ?>" title="Editer le bloc"><?php echo $_blocs_val['TITRE']; ?></a>
		</h2>
		<p>
		<?php if ($_blocs_val['IS_ONLINE']) {  ?>
			<code>[EN LIGNE]</code>
		<?php } else { ?>
			<code>[HORS LIGNE]</code>
		<?php } ?> 
		<span><a href="<?php echo $_blocs_val['LINK_DELETE']; ?>" title="Supprimer le bloc"><img src="design/defaut/images/supprimer-page.png" alt="Supprimer le bloc"/></a></span>
		<a href="<?php echo $_blocs_val['LIEN_REMONTER']; ?>" title="Remonter"><img src="design/defaut/images/arrow_up.png" alt="Remonter"/></a>
		<a href="<?php echo $_blocs_val['LIEN_DESCENDRE']; ?>" title="Descendre"><img src="design/defaut/images/arrow_down.png" alt="Descendre"/></a>
		<a href="<?php echo $_blocs_val['LIEN_PUBLISH']; ?>" title="Publier">mettre online/hors line</a>
		</p>
		<hr/>
	<?php }} ?>
	<?php echo (isset($this->_rootref['CONTENU_SECONDAIRE'])) ? $this->_rootref['CONTENU_SECONDAIRE'] : ''; ?>
	
</div><!-- #secondaire --><?php if ($this->_rootref['IS_SAVECONFIRMATION']) {  ?>
	<div id="info">
		<p><img src="design/defaut/images/info.png" alt="enregistré"> <?php echo ((isset($this->_rootref['L_SAVECONFIRMATION'])) ? $this->_rootref['L_SAVECONFIRMATION'] : ((isset($this->lang['SAVECONFIRMATION'])) ? $this->lang['SAVECONFIRMATION'] : '{ SAVECONFIRMATION }')); ?>  <?php echo (isset($this->_rootref['SAVECONFIRMATION_DATE'])) ? $this->_rootref['SAVECONFIRMATION_DATE'] : ''; ?></p>
	</div>
<?php } ?> 

<div id="principal">	
	<div id="wrapper">
		<h1>
		<?php if ($this->_rootref['HAS_RIGHT']) {  ?>
			<img src="design/defaut/images/clef.png" alt="Droits d'accès" title="Cette page possède des droits d'accès"/>
		<?php } ?> 
		Edition de la page «&nbsp;<?php echo (isset($this->_rootref['FORM_TITRE'])) ? $this->_rootref['FORM_TITRE'] : ''; ?>&nbsp;»
		<?php if ($this->_rootref['IS_ONLINE']) {  ?>
			<sup><code>EN LIGNE</code></sup>
			<!-- <img src="design/defaut/images/published-small.png" alt="La page est publiée (online)" title="La page est publiée (online)"/> -->
		<?php } else { ?>
			<sup><code class="attention">HORS LIGNE</code></sup>
		 <!-- <img src="design/defaut/images/unpublished-small.png" alt="La page n'est pas publiée (offline)" title="La page n'est pas publiée (offline)"/> -->
		<?php } ?> </h1>
		<p class="attention">
		<!-- ID=<code>[<?php echo (isset($this->_rootref['FORM_ID'])) ? $this->_rootref['FORM_ID'] : ''; ?>] -- </code> 
		Description : «&nbsp;<em><?php echo (isset($this->_rootref['FORM_DESCRIPTION'])) ? $this->_rootref['FORM_DESCRIPTION'] : ''; ?></em>&nbsp;»
		<br/> -->
		<?php if ($this->_rootref['IS_ONLINE']) {  ?>
			 Retirer la page &nbsp;<span><a href="<?php echo (isset($this->_rootref['LINK_PUBLISH'])) ? $this->_rootref['LINK_PUBLISH'] : ''; ?>" title="Retirer l'article"><img src="design/defaut/images/offline.png" alt="Retirer l'article"/></a></span>
		<?php } else { ?>
		 Mettre la page en ligne &nbsp;<span><a href="<?php echo (isset($this->_rootref['LINK_PUBLISH'])) ? $this->_rootref['LINK_PUBLISH'] : ''; ?>" title="Publier l'article"><img src="design/defaut/images/online.png" alt="Publier l'article"/></a></span>
		<?php } ?>
		</p>
	   <ul class="tabs">
			<li><a href="<?php echo (isset($this->_rootref['LINK_EDITINFO'])) ? $this->_rootref['LINK_EDITINFO'] : ''; ?>">Editer les métadonnées</a></li>
			<li><a href="<?php echo (isset($this->_rootref['LINK_EDITCONTENT'])) ? $this->_rootref['LINK_EDITCONTENT'] : ''; ?>">Editer le contenu</a></li>
			<li><a href="<?php echo (isset($this->_rootref['LINK_EDITMENU'])) ? $this->_rootref['LINK_EDITMENU'] : ''; ?>">Editer le menu</a></li>
			<li><a href="<?php echo (isset($this->_rootref['LINK_EDITDESIGN'])) ? $this->_rootref['LINK_EDITDESIGN'] : ''; ?>">Editer le design</a></li>
			<!-- <li><a href="<?php echo (isset($this->_rootref['LINK_EDITTEMPLATE'])) ? $this->_rootref['LINK_EDITTEMPLATE'] : ''; ?>">Editer le template</a></li>
			 --><li class="selected"><a href="">Editer le bloc n° <?php echo (isset($this->_rootref['BLOC_ID'])) ? $this->_rootref['BLOC_ID'] : ''; ?></a></li>
		</ul>
		
		<form class="edit" name="editContent" method="POST" action="<?php echo (isset($this->_rootref['FICHIER_CIBLE'])) ? $this->_rootref['FICHIER_CIBLE'] : ''; ?>#tab2">	
			<fieldset class="contenu">
				<legend>Bloc n° <?php echo (isset($this->_rootref['BLOC_ID'])) ? $this->_rootref['BLOC_ID'] : ''; ?></legend>
				<p><label>Titre de l'article <input type="text" name="contenu[titre]" value="<?php echo (isset($this->_rootref['BLOC_TITRE'])) ? $this->_rootref['BLOC_TITRE'] : ''; ?>" size="50" maxlength="150"/></label>
				<p>
					<label> Contenu du bloc<br/>
					<textarea name="contenu[content]" cols="80" rows="100" class="wymeditor"> <?php echo (isset($this->_rootref['BLOC_CONTENU'])) ? $this->_rootref['BLOC_CONTENU'] : ''; ?></textarea>
					</label>
				</p>
			</fieldset>
				
				
			<!-- <input type="reset" name="nom" value="" class="refresh" /> -->
			<input type="image" name="nom" src="design/defaut/images/save.png"  alt="Enregistrer" class="wymupdate" />
			<!-- <a href="<?php echo (isset($this->_rootref['LIEN_APERCU'])) ? $this->_rootref['LIEN_APERCU'] : ''; ?>" title="Aperçu"><img src="design/defaut/images/apercu.png" alt="Aperçu"/></a> -->
		</form>
	</div><!-- #wrapper -->

</div><!-- #principal -->