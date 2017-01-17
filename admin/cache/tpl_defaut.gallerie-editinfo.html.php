<script type="text/javascript">
<!--

$(function() {
	$('#datepicker').datepicker({
		changeMonth: true,
		changeYear: true,
		dateFormat: 'dd.mm.yy'
	});
});
-->

</script>
	<?php if ($this->_rootref['IS_SAVECONFIRMATION']) {  ?>
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
		Edition de la gallerie «&nbsp;<?php echo (isset($this->_rootref['FORM_TITRE'])) ? $this->_rootref['FORM_TITRE'] : ''; ?>&nbsp;»
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
			 Retirer la page &nbsp;<span><a href="<?php echo (isset($this->_rootref['LINK_PUBLISH'])) ? $this->_rootref['LINK_PUBLISH'] : ''; ?>" title="Retirer la gallerie"><img src="design/defaut/images/offline.png" alt="Retirer la gallerie"/></a></span>
		<?php } else { ?>
		 Mettre la page en ligne &nbsp;<span><a href="<?php echo (isset($this->_rootref['LINK_PUBLISH'])) ? $this->_rootref['LINK_PUBLISH'] : ''; ?>" title="Publier la gallerie"><img src="design/defaut/images/online.png" alt="Publier la gallerie"/></a></span>
		<?php } ?>
		</p>
		
		
		
	   <ul class="tabs">
			<li><a href="<?php echo (isset($this->_rootref['LINK_EDITCONTENT_ARTICLE'])) ? $this->_rootref['LINK_EDITCONTENT_ARTICLE'] : ''; ?>">Editer Images</a></li>
			<li><a href="<?php echo (isset($this->_rootref['LINK_EDITCHAPEAU'])) ? $this->_rootref['LINK_EDITCHAPEAU'] : ''; ?>">Editer Chapeau</a></li>
			<li class="selected"><a href="<?php echo (isset($this->_rootref['LINK_EDITINFO_ARTICLE'])) ? $this->_rootref['LINK_EDITINFO_ARTICLE'] : ''; ?>">Editer Infos Galleries</a></li>
		</ul>

		<!-- Editer les infos -->
		<form class="edit" name="editinfo" method="POST" action="<?php echo (isset($this->_rootref['FICHIER_CIBLE'])) ? $this->_rootref['FICHIER_CIBLE'] : ''; ?>#tab1">
			
			<fieldset class="metadonnees">
				<legend>Méta-données</legend>
			
			
				<p>	<label>Titre <input type="text" name="info[titre]" value="<?php echo (isset($this->_rootref['FORM_TITRE'])) ? $this->_rootref['FORM_TITRE'] : ''; ?>" size="50" maxlength="150"/></label></p>
				<p>	<label>Auteur <input type="text" name="info[auteur]" value="<?php echo (isset($this->_rootref['FORM_AUTEUR'])) ? $this->_rootref['FORM_AUTEUR'] : ''; ?>" size="50" maxlength="50"/></label></p>
				<p>	<label>Date <input type="text" name="info[date]" value="<?php echo (isset($this->_rootref['FORM_DATE'])) ? $this->_rootref['FORM_DATE'] : ''; ?>" size="50" maxlength="50" id="datepicker"/></label></p>
				<p>	<label>Description <input type="text" name="info[description]" value="<?php echo (isset($this->_rootref['FORM_DESCRIPTION'])) ? $this->_rootref['FORM_DESCRIPTION'] : ''; ?>" size="50" /></label></p>
				<p>	<label>Mots-clefs (séparé par une virgule) <input type="text" name="info[motsclefs]" value="<?php echo (isset($this->_rootref['FORM_MOTSCLEFS'])) ? $this->_rootref['FORM_MOTSCLEFS'] : ''; ?>" size="50" /></label></p>
				<p>Vos mots-clefs: 
				<?php $_tags_count = (isset($this->_tpldata['tags'])) ? sizeof($this->_tpldata['tags']) : 0;if ($_tags_count) {for ($_tags_i = 0; $_tags_i < $_tags_count; ++$_tags_i){$_tags_val = &$this->_tpldata['tags'][$_tags_i]; ?>	
					<a href="javascript:insert_tag('<?php echo $_tags_val['TAGNAME']; ?>')"><?php echo $_tags_val['TAGNAME']; ?></a> 
				<?php }} ?>	
				<!-- 
				<a href="javascript:insert_tag('début')">début</a> <a href="javascript:insert_tag('bonjour')">bonjour</a> <a href="javascript:insert_tag('vie')">vie</a> <a href="javascript:insert_tag('société')">société</a> <a href="javascript:insert_tag('amour')">amour</a> <a href="javascript:insert_tag('love')">love</a> </p>
				 -->
				<p>	<label>Droits 	<select name="info[droit]" size="1">
						<option value="-1"  
						<?php if ($this->_rootref['HAS_RIGHT']) {  ?>
						selected="selected"
						<?php } ?> 
						>Pas de droits</option>
					<?php $_rights_count = (isset($this->_tpldata['rights'])) ? sizeof($this->_tpldata['rights']) : 0;if ($_rights_count) {for ($_rights_i = 0; $_rights_i < $_rights_count; ++$_rights_i){$_rights_val = &$this->_tpldata['rights'][$_rights_i]; ?>
						<option value="<?php echo $_rights_val['VALUE']; ?>"  
							<?php if ($_rights_val['SELECTED']) {  ?>
								selected="selected"
							<?php } ?>
						><?php echo $_rights_val['NAME']; ?></option>
					<?php }} ?>
					
							</select>
				</label>
				</p>
				<!-- <p>	<label>Publication 	<select name="info[publication]" size="1">
						-- IF IS_PUBLICATED --
							<option value="0">Brouillon</option>
							<option value="1" selected="selected">Publié</option>
						-- ELSE --
							<option value="0" selected="selected">Brouillon</option>
							<option value="1">Publié</option>
						-- ENDIF --
							</select>
					</label>
				</p> -->
								<p>	<label>Commentaires 	<select name="info[commentaire]" size="1">
						<?php if ($this->_rootref['HAS_COMMENT']) {  ?>
							<option value="0">Interdit</option>
							<option value="1" selected="selected">Autorisé</option>
						<?php } else { ?>
							<option value="0" selected="selected">Interdit</option>
							<option value="1">Autorisé</option>
						<?php } ?>
							</select>
					</label>
				</p>	
				<p> <label> Image
						<select name="info[image]" size="1">
							<option value="#">#</option>
						</select>
					</label>
				</p>
				<p> <label> Miniature
						<select name="info[miniature]" size="1">
							<option value="#">#</option>	
						</select>
					</label>
				</p>
			</fieldset>
				
				
			<input type="reset" name="nom" value="" class="refresh" />
			<input type="image" name="nom" src="design/defaut/images/save.png"  alt="Enregistrer" class="" />
			<!-- <a href="<?php echo (isset($this->_rootref['LIEN_APERCU'])) ? $this->_rootref['LIEN_APERCU'] : ''; ?>" title="Aperçu"><img src="design/defaut/images/apercu.png" alt="Aperçu"/></a> -->
		</form>
	</div><!-- #wrapper -->
	
	

	
	<?php echo (isset($this->_rootref['CONTENU'])) ? $this->_rootref['CONTENU'] : ''; ?>
</div><!-- #principal -->