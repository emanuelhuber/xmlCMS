<div id="secondaire">
	<h1>Description</h1>
	<p><?php echo (isset($this->_rootref['FORM_DESCRIPTION'])) ? $this->_rootref['FORM_DESCRIPTION'] : ''; ?></p>
	<hr/>
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
		Edition de la collection d'articles «&nbsp;<?php echo (isset($this->_rootref['FORM_TITRE'])) ? $this->_rootref['FORM_TITRE'] : ''; ?>&nbsp;»
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
			<li class="selected"><a href="<?php echo (isset($this->_rootref['LINK_INDEX'])) ? $this->_rootref['LINK_INDEX'] : ''; ?>">Index</a></li>
			<li><a href="<?php echo (isset($this->_rootref['LINK_EDITINFO'])) ? $this->_rootref['LINK_EDITINFO'] : ''; ?>">Editer les métadonnées</a></li>
			<li><a href="<?php echo (isset($this->_rootref['LINK_EDITMENU'])) ? $this->_rootref['LINK_EDITMENU'] : ''; ?>">Editer le menu</a></li>
			<li><a href="<?php echo (isset($this->_rootref['LINK_EDITDESIGN'])) ? $this->_rootref['LINK_EDITDESIGN'] : ''; ?>">Editer le design</a></li>
		</ul>
		
	<form class="edit" name="editpage" method="POST" action="<?php echo (isset($this->_rootref['FICHIER_CIBLE'])) ? $this->_rootref['FICHIER_CIBLE'] : ''; ?>">
		<fieldset class="rubrique">
			<legend><img src="design/defaut/images/article-ajouter.png" alt="Créer un article"/> Creer un article</legend>
			<p><label>Titre de l'article <input type="text" name="title" value="" size="50" maxlength="150"/></label>
			<input type="submit" name="nom" value="OK"/></p>
		</fieldset>
	</form>
	
	<p>Nombre d'article trouvé : <?php echo (isset($this->_rootref['NB_ARTICLES'])) ? $this->_rootref['NB_ARTICLES'] : ''; ?></p>
	
	<?php if ($this->_rootref['IS_NAVIGATION']) {  ?>
	<p>Previous &nbsp;	
		<?php $_navigation_count = (isset($this->_tpldata['navigation'])) ? sizeof($this->_tpldata['navigation']) : 0;if ($_navigation_count) {for ($_navigation_i = 0; $_navigation_i < $_navigation_count; ++$_navigation_i){$_navigation_val = &$this->_tpldata['navigation'][$_navigation_i]; ?>
			<a href="<?php echo $_navigation_val['LINK']; ?>" title="page"><?php echo $_navigation_val['NB']; ?></a>&nbsp;
		<?php }} ?>
		&nbsp; Next</p>
	<?php } $_article_count = (isset($this->_tpldata['article'])) ? sizeof($this->_tpldata['article']) : 0;if ($_article_count) {for ($_article_i = 0; $_article_i < $_article_count; ++$_article_i){$_article_val = &$this->_tpldata['article'][$_article_i]; ?>
	
		<h3>
		<?php if ($_article_val['HAS_RIGHT']) {  ?>
			<img src="design/defaut/images/clef.png" alt="Droits d'accès" title="Cette page possède des droits d'accès"/>
		<?php } ?> 
		
		<a href="<?php echo $_article_val['LINK_EDIT']; ?>" title="Editer l'article"><?php echo $_article_val['TITRE']; ?></a> </h3>
		<span><?php echo $_article_val['DATE']; ?> <?php echo $_article_val['NOM_JOUR']; ?> <?php echo $_article_val['JOUR']; ?> <?php echo $_article_val['MOIS']; ?> <?php echo $_article_val['ANNEE']; ?> -  <?php echo $_article_val['AUTEUR']; ?> </span><br/>
		<span> «&nbsp;<?php echo $_article_val['DESCRIPTION']; ?>&nbsp;» </span><br/>
		<!-- <span><a href="<?php echo $_article_val['LIEN']; ?>"  title="article">Suite</a></span> -->
			<?php if ($_article_val['IS_ONLINE']) {  ?>
			<code>[EN LIGNE]</code>
		<?php } else { ?>
			<code>[HORS LIGNE]</code>
		<!--  <img src="design/defaut/images/unpublished-small.png" alt="L'article n'est pas publié (offline)" title="L'article n'est pas publié (offline)"/> --><?php } ?> 
		<!-- <span><a href="<?php echo $_article_val['LINK_EDIT']; ?>" title="Editer l'article"><img src="design/defaut/images/editer-page.png" alt="Editer l'article"/></a></span> -->
		<!-- <span><a href="<?php echo $_article_val['LIEN_APERCU']; ?>" title="Aperçu"><img src="design/defaut/images/page-preview.png" alt="Aperçu"/></a></span> -->
		<span><a href="<?php echo $_article_val['LINK_DELETE']; ?>" title="Supprimer l'article"><img src="design/defaut/images/supprimer-page.png" alt="Supprimer l'article"/></a></span>
		<a href="<?php echo $_article_val['LIEN_REMONTER']; ?>" title="Remonter"><img src="design/defaut/images/arrow_up.png" alt="Remonter"/></a>
		<a href="<?php echo $_article_val['LIEN_DESCENDRE']; ?>" title="Descendre"><img src="design/defaut/images/arrow_down.png" alt="Descendre"/></a>
		<hr/>
	<?php }} ?>
	
	</div>

	
	<?php echo (isset($this->_rootref['CONTENU'])) ? $this->_rootref['CONTENU'] : ''; ?>
</div><!-- #principal -->