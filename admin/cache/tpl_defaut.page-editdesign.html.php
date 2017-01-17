<?php if ($this->_rootref['IS_SAVECONFIRMATION']) {  ?>
		<div id="info">
			<p><img src="design/defaut/images/info.png" alt="enregistré"> <?php echo ((isset($this->_rootref['L_SAVECONFIRMATION'])) ? $this->_rootref['L_SAVECONFIRMATION'] : ((isset($this->lang['SAVECONFIRMATION'])) ? $this->lang['SAVECONFIRMATION'] : '{ SAVECONFIRMATION }')); ?>  <?php echo (isset($this->_rootref['SAVECONFIRMATION_DATE'])) ? $this->_rootref['SAVECONFIRMATION_DATE'] : ''; ?></p>
		</div>
	<?php } ?> 
<div id="principal_large">	
		
		
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
			<li class="selected"><a href="<?php echo (isset($this->_rootref['LINK_EDITDESIGN'])) ? $this->_rootref['LINK_EDITDESIGN'] : ''; ?>">Editer le design</a></li>
			<li><a href="<?php echo (isset($this->_rootref['LINK_EDITTEMPLATE'])) ? $this->_rootref['LINK_EDITTEMPLATE'] : ''; ?>">Editer le template</a></li>
		</ul>
		

					<?php $_theme_count = (isset($this->_tpldata['theme'])) ? sizeof($this->_tpldata['theme']) : 0;if ($_theme_count) {for ($_theme_i = 0; $_theme_i < $_theme_count; ++$_theme_i){$_theme_val = &$this->_tpldata['theme'][$_theme_i]; ?>
							<div class="bloc">
							<h3>	
						<?php if ($_theme_val['SELECTED']) {  ?>
								<strong><?php echo $_theme_val['NAME']; ?></strong>
						<?php } else { ?>
								<?php echo $_theme_val['NAME']; ?>
						<?php } ?>
								</h3>
						<?php $_style_count = (isset($_theme_val['style'])) ? sizeof($_theme_val['style']) : 0;if ($_style_count) {for ($_style_i = 0; $_style_i < $_style_count; ++$_style_i){$_style_val = &$_theme_val['style'][$_style_i]; if ($_style_val['SELECTED']) {  ?>
								<img src="design/defaut/images/star.png" alt="Selectionné" title="Selectionné"/>
							<?php } ?>
							<a href="<?php echo $_style_val['LINK']; ?>" title="Servus">
							<?php if ($_style_val['SELECTED']) {  ?>
								<strong><?php echo $_style_val['NAME']; ?></strong>
							<?php } else { ?>
									<?php echo $_style_val['NAME']; ?>
							<?php } ?>
								</a><br/>
						<?php }} ?>
						
						
						</div>
					<?php }} ?>
				

	</div><!-- #wrapper -->

</div><!-- #principal -->