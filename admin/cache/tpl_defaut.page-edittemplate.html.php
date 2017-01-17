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
			<li class="selected"><a href="<?php echo (isset($this->_rootref['LINK_EDITTEMPLATE'])) ? $this->_rootref['LINK_EDITTEMPLATE'] : ''; ?>">Editer le template</a></li>
		</ul>
		
		<p>Attention, le choix d'un mauvais template peut provoquer une erreur...</p>
		<p>Template squelette: choisir un template du genre <code>squelettexxx.html</code></p>
		<p>Template page: choisir un template du genre <code>pagexxx.html</code></p>
					
				<form class="edit" name="editpage" method="POST" action="<?php echo (isset($this->_rootref['FICHIER_CIBLE'])) ? $this->_rootref['FICHIER_CIBLE'] : ''; ?>">
					
					<fieldset class="rubrique">
						<legend>Nouveau contenu</legend>
						<?php $_template_count = (isset($this->_tpldata['template'])) ? sizeof($this->_tpldata['template']) : 0;if ($_template_count) {for ($_template_i = 0; $_template_i < $_template_count; ++$_template_i){$_template_val = &$this->_tpldata['template'][$_template_i]; ?>
						<p>	<label><?php echo $_template_val['NAME']; ?> 	<select name="template[<?php echo $_template_val['NAME']; ?>]" size="1">
													<?php $_html_count = (isset($_template_val['html'])) ? sizeof($_template_val['html']) : 0;if ($_html_count) {for ($_html_i = 0; $_html_i < $_html_count; ++$_html_i){$_html_val = &$_template_val['html'][$_html_i]; ?>
													<option value="<?php echo $_html_val['ID']; ?>"
													<?php if ($_html_val['SELECTED']) {  ?>
													selected="selected"
													<?php } ?> 
													><?php echo $_html_val['ID']; ?></option>
													<?php }} ?>
													
											</select>
							</label>
						</p>
						<?php }} ?>
						
					</fieldset>
					<input type="reset" name="nom" value="" class="refresh" />
					<input type="image" name="nom" src="design/defaut/images/save.png"  alt="Enregistrer"/>
				</form>
				

	</div><!-- #wrapper -->

</div><!-- #principal -->