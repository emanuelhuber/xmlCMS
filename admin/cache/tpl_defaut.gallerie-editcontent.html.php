<div id="secondaire">
	<h1>Aide</h1>
	<p>Veuillez charger les images dans le dossier:<br/> <code><?php echo (isset($this->_rootref['DIR_IMAGES'])) ? $this->_rootref['DIR_IMAGES'] : ''; ?></code> <br/> ainsi les miniatures dans le dossier:<br/> <code><?php echo (isset($this->_rootref['DIR_MINIATURES'])) ? $this->_rootref['DIR_MINIATURES'] : ''; ?></code>.</p>
	<p>Les images et les miniatures ont exactement le même nom de fichier.</p>
	<p>Taille recommandée pour les miniatures: 150 x 80 px.</p>
	<p>Taille recommandée pour les images: 800 x 600 px.</p>
	<hr/>
	
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
		Edition de l'articles «&nbsp;<?php echo (isset($this->_rootref['FORM_TITRE'])) ? $this->_rootref['FORM_TITRE'] : ''; ?>&nbsp;»
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
			<!-- <li><a href="<?php echo (isset($this->_rootref['LINK_INDEX'])) ? $this->_rootref['LINK_INDEX'] : ''; ?>">Index</a></li>
			<li><a href="<?php echo (isset($this->_rootref['LINK_EDITINFO'])) ? $this->_rootref['LINK_EDITINFO'] : ''; ?>">Editer les métadonnées</a></li>
			<li><a href="<?php echo (isset($this->_rootref['LINK_EDITMENU'])) ? $this->_rootref['LINK_EDITMENU'] : ''; ?>">Editer le menu</a></li>
			<li><a href="<?php echo (isset($this->_rootref['LINK_EDITDESIGN'])) ? $this->_rootref['LINK_EDITDESIGN'] : ''; ?>">Editer le design</a></li> -->
			<li class="selected"><a href="<?php echo (isset($this->_rootref['LINK_EDITCONTENT_ARTICLE'])) ? $this->_rootref['LINK_EDITCONTENT_ARTICLE'] : ''; ?>">Editer Images</a></li>
			<li><a href="<?php echo (isset($this->_rootref['LINK_EDITCHAPEAU'])) ? $this->_rootref['LINK_EDITCHAPEAU'] : ''; ?>">Editer Chapeau</a></li>
			<li><a href="<?php echo (isset($this->_rootref['LINK_EDITINFO_ARTICLE'])) ? $this->_rootref['LINK_EDITINFO_ARTICLE'] : ''; ?>">Editer info article</a></li>
		</ul>
		<?php if ($this->_rootref['IS_IMAGES']) {  } else { ?>
			<p>&nbsp;</p>
			<p>Il n'y pas encore d'images.</p>
			<p>Veuillez charger les images dans le dossier:<br/> <code><?php echo (isset($this->_rootref['DIR_IMAGES'])) ? $this->_rootref['DIR_IMAGES'] : ''; ?></code> <br/> ainsi les miniatures dans le dossier:<br/> <code><?php echo (isset($this->_rootref['DIR_MINIATURES'])) ? $this->_rootref['DIR_MINIATURES'] : ''; ?></code>.</p>
		<?php } $_images_count = (isset($this->_tpldata['images'])) ? sizeof($this->_tpldata['images']) : 0;if ($_images_count) {for ($_images_i = 0; $_images_i < $_images_count; ++$_images_i){$_images_val = &$this->_tpldata['images'][$_images_i]; ?>
		<div class="imgform">		
			<div class="img"><a class="fancy" href="<?php echo $_images_val['SRC']; ?>" title="<?php echo $_images_val['TITLE']; ?>">
			<img src="<?php echo $_images_val['SRC_MINIATURE']; ?>" alt="<?php echo $_images_val['ALT']; ?>"/>
			</a>
			</div>
			<div class="myform">
			<form  name="editinfo" method="POST" action="<?php echo (isset($this->_rootref['FICHIER_CIBLE'])) ? $this->_rootref['FICHIER_CIBLE'] : ''; ?>">
				<fieldset class="metadonnees">
					<legend>Méta-données</legend>
					<input type="hidden"  name="image[id]"  value="<?php echo $_images_val['ID']; ?>">
					<p>	<label>Titre <input type="text" name="image[title]" value="<?php echo $_images_val['TITLE']; ?>" size="50" maxlength="150"/></label></p>
					<!-- <p>	<label>Auteur <input type="text" name="image[copyright]" value="<?php echo $_images_val['TITLE']; ?>" size="50" maxlength="50"/></label></p> -->
					<p>	<label>Description <input type="text" name="image[description]" value="<?php echo $_images_val['DESCRIPTION']; ?>" size="50" /></label></p>
					<p>	<label>Text alternatif <input type="text" name="image[alt]" value="<?php echo $_images_val['ALT']; ?>" size="50" /></label></p>
				</fieldset>
				<!-- <input type="reset" name="nom" value="" class="refresh" /> -->
				<input type="image" name="nom" src="design/defaut/images/save.png"  alt="Enregistrer" class="" />
				<!-- <a href="<?php echo (isset($this->_rootref['LIEN_APERCU'])) ? $this->_rootref['LIEN_APERCU'] : ''; ?>" title="Aperçu"><img src="design/defaut/images/apercu.png" alt="Aperçu"/></a> -->
			</form>
			</div>
			<!-- Editer les infos -->
		</div>
		<?php }} ?>
		
	</div><!-- #wrapper -->

</div><!-- #principal --><!-- Add fancyBox main JS and CSS files -->
<script src="http://code.jquery.com/jquery-latest.js"></script>
	<script type="text/javascript" src="design/defaut/js/jquery.fancybox.js?v=2.1.5"></script>
	<link rel="stylesheet" type="text/css" href="design/defaut/js/jquery.fancybox.css?v=2.1.5" media="screen" />
<script type="text/javascript">
		<!--	
$(document).ready(function() {
	$(".fancy").fancybox({
		prevEffect		: 'none',
		nextEffect		: 'none',
		closeBtn		: true,
		helpers		: {
			title	: { type : 'over' },
			buttons	: {}
		}
	});
});
		-->
		</script>