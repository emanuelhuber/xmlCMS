<div id="secondaire">
	<h1>Légende</h1>
	
	<table border="0px">
	<tr>
		<td>
			<img src="design/defaut/images/arrow_up.png" alt="Remonter"/> Remonter la page<br/>
			<img src="design/defaut/images/arrow_down.png" alt="Descendre"/> Descendre la page<br/>
			<img src="design/defaut/images/arrow_right.png" alt="Droite"/> Décaler vers la droite<br/>
			<img src="design/defaut/images/arrow_left.png" alt="Gauche"/> Décaler vers la gauche<br/>
			<!-- <img src="design/defaut/images/editer-page.png" alt="Editer la page"/> Editer<br/> -->
			<img src="design/defaut/images/supprimer-page.png" alt="Supprimer la page"/> Supprimer<br/>
		</td>
	</table>
	<br/>	
	<hr/>
	<?php echo (isset($this->_rootref['CONTENU_SECONDAIRE'])) ? $this->_rootref['CONTENU_SECONDAIRE'] : ''; ?>
</div><!-- #secondaire -->

<div id="principal">
	<h1>Liste des contenus</h1>

<p><a href="<?php echo (isset($this->_rootref['LIEN_CREER_PAGE'])) ? $this->_rootref['LIEN_CREER_PAGE'] : ''; ?>" title="Créer une nouvelle page"><img src="design/defaut/images/page-ajouter.png" alt="Créer une nouvelle page"/></a>
<a href="<?php echo (isset($this->_rootref['LIEN_CREER_PAGE'])) ? $this->_rootref['LIEN_CREER_PAGE'] : ''; ?>" title="Créer une nouvelle page">Créer une nouvelle page</a>
 &nbsp;&nbsp;&nbsp;
 <a href="<?php echo (isset($this->_rootref['LIEN_LANGUE'])) ? $this->_rootref['LIEN_LANGUE'] : ''; ?>" title="Ajouter une nouvelle langue"><img src="design/defaut/images/drapeaux.jpg" alt="Ajouter une nouvelle langue"/></a>
 <a href="<?php echo (isset($this->_rootref['LIEN_LANGUE'])) ? $this->_rootref['LIEN_LANGUE'] : ''; ?>" title="Ajouter une nouvelle langue">Ajouter une nouvelle langue</a></p>


	

	<ul id="tree" class="filetree">
	<?php $_lg_count = (isset($this->_tpldata['lg'])) ? sizeof($this->_tpldata['lg']) : 0;if ($_lg_count) {for ($_lg_i = 0; $_lg_i < $_lg_count; ++$_lg_i){$_lg_val = &$this->_tpldata['lg'][$_lg_i]; ?>
		<li><span class="folder"><em><img src="design/defaut/images/drapeau_<?php echo $_lg_val['ID']; ?>.png" alt="<?php echo $_lg_val['NAME']; ?>"/>  <?php echo $_lg_val['NAME']; ?></em> 
			<a href="<?php echo $_lg_val['LINK_DELETE']; ?>" title="Supprimer"><img src="design/defaut/images/supprimer-page.png" alt="Supprimer"/></a></span>
			<ul>
			<?php $_mymenu_count = (isset($_lg_val['mymenu'])) ? sizeof($_lg_val['mymenu']) : 0;if ($_mymenu_count) {for ($_mymenu_i = 0; $_mymenu_i < $_mymenu_count; ++$_mymenu_i){$_mymenu_val = &$_lg_val['mymenu'][$_mymenu_i]; if ($_mymenu_val['T_FLAT']) {  ?>
				<li>
				<?php } if ($_mymenu_val['T_UP']) {  ?>
				<li>
				<?php } if ($_mymenu_val['T_DOWN']) {  ?>
				<ul><li   
					<?php if ($_mymenu_val['T_PUBLIER']) {  ?>
						class="publier"
					<?php } else { ?>
						class="brouillon"
					<?php } ?>
				>
				<?php } ?>
						<span 
						<?php if ($_mymenu_val['T_FOLDER']) {  ?>
							class="folder"
						<?php } else { ?>
							class="file"
						<?php } ?>	
						><a href="<?php echo $_mymenu_val['LIEN_EDITER']; ?>" title="Editer"><?php echo $_mymenu_val['NAME']; ?></a> (<?php echo $_mymenu_val['MOD']; ?>)
						<a href="<?php echo $_mymenu_val['LIEN_REMONTER']; ?>" title="Remonter"><img src="design/defaut/images/arrow_up.png" alt="Remonter"/></a>
						<a href="<?php echo $_mymenu_val['LIEN_DESCENDRE']; ?>" title="Descendre"><img src="design/defaut/images/arrow_down.png" alt="Descendre"/></a>
						<?php if ($_mymenu_val['T_LEFT']) {  ?>
						<a href="<?php echo $_mymenu_val['LIEN_GAUCHE']; ?>" title="Décaler à gauche au-dessus de l'élément précédant"><img src="design/defaut/images/arrow_left.png" alt="Gauche"/></a> 
						<?php } if ($_mymenu_val['T_RIGHT']) {  ?>
						<a href="<?php echo $_mymenu_val['LIEN_DROITE']; ?>" title="Décaler à droite en dessous de l'élément suivant"><img src="design/defaut/images/arrow_right.png" alt="Droite"/></a> 
						<?php } ?>
						<!-- <a href="<?php echo $_mymenu_val['LIEN_EDITER']; ?>" title="Editer"><img src="design/defaut/images/editer-page.png" alt="Editer"/></a> -->
						<a href="<?php echo $_mymenu_val['LIEN_SUPPRIMER']; ?>" title="Supprimer"><img src="design/defaut/images/supprimer-page.png" alt="Supprimer"/></a>
							<?php if ($_mymenu_val['T_IN_MENU']) {  ?>
								&nbsp;in menu&nbsp;
							<?php } else { ?>
								&nbsp;<strike>in menu</strike>&nbsp;
							<?php } if ($_mymenu_val['T_PUBLIER']) {  ?>
								|&nbsp;online
							<?php } else { ?>
								|&nbsp;offline
							<?php } ?>
							|&nbsp;droits :&nbsp;<?php echo $_mymenu_val['DROITS']; ?>

						</span>	
				<?php if ($_mymenu_val['T_CHILD']) {  } else { ?>	
					</li>
				<?php } $_up_count = (isset($_mymenu_val['up'])) ? sizeof($_mymenu_val['up']) : 0;if ($_up_count) {for ($_up_i = 0; $_up_i < $_up_count; ++$_up_i){$_up_val = &$_mymenu_val['up'][$_up_i]; ?>
					</ul>
					</li>
				<?php }} }} ?>		
			</ul>
	
		</li>
	<?php }} ?>
	</ul>
		
	
	<hr/>

	


	
	<?php echo (isset($this->_rootref['CONTENU'])) ? $this->_rootref['CONTENU'] : ''; ?>
</div><!-- #principal -->