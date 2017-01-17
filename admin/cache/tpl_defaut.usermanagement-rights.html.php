<div id="secondaire">
	<h1>Explication</h1>
	<img src="design/defaut/images/idea.png" width="50px"/>
	<p>
	Un <strong>utilisateur</strong> appartient à un <strong>groupe</strong> qui possède plusieurs <strong>droits</strong>.
	</p>
	<p>
	Chaque page possède un certain droit d'accès. Si le groupe de l'utilisateur possède aussi ce droit, alors l'utilisateur aura accès à la page.
	</p>
	
	
	
	<?php echo (isset($this->_rootref['CONTENU_SECONDAIRE'])) ? $this->_rootref['CONTENU_SECONDAIRE'] : ''; ?>
</div><!-- #secondaire -->

<div id="principal">
	<?php $_info_count = (isset($this->_tpldata['info'])) ? sizeof($this->_tpldata['info']) : 0;if ($_info_count) {for ($_info_i = 0; $_info_i < $_info_count; ++$_info_i){$_info_val = &$this->_tpldata['info'][$_info_i]; ?>
		<div id="info">
			<p><img src="design/defaut/images/info.png" alt="enregistré"> Enregistré  <?php echo $_info_val['DATE']; ?></p>
		</div>
	<?php }} ?>
	
	<h1>Activer et éditer des droits</h1>
	
	<!-- Editer les infos -->
		<form class="edit" name="editinfo" method="POST" action="<?php echo (isset($this->_rootref['FICHIER_CIBLE'])) ? $this->_rootref['FICHIER_CIBLE'] : ''; ?>">

			<fieldset class="metadonnees">
				<legend>Droits</legend>
			<?php $_list_count = (isset($this->_tpldata['list'])) ? sizeof($this->_tpldata['list']) : 0;if ($_list_count) {for ($_list_i = 0; $_list_i < $_list_count; ++$_list_i){$_list_val = &$this->_tpldata['list'][$_list_i]; ?>
				<p>
					<label> Droit n°<?php echo $_list_val['RGHT_NB']; ?> :
					<input type="checkbox" name="activated[<?php echo $_list_val['RGHT_NB']; ?>]" 
						<?php if ($_list_val['ACTIVATED']) {  ?>
							checked="checked"
							<?php } ?>
							> 
					</label>
					<label>Nom :<input type="text" name="name[<?php echo $_list_val['RGHT_NB']; ?>]" value="<?php echo $_list_val['RGHT_NAME']; ?>" size="18" maxlength="50"/></label><br/>
					<label>Description :<input type="text" name="description[<?php echo $_list_val['RGHT_NB']; ?>]" value="<?php echo $_list_val['RGHT_DESCRIPTION']; ?>" size="40" maxlength="50"/></label>
				</p>
			<?php }} ?>
			</fieldset>
				
			<input type="reset" name="nom" value="" class="refresh" />
			<input type="image" name="nom" src="design/defaut/images/save.png"  alt="Enregistrer" class="wymupdate" />
			<!-- <a href="<?php echo (isset($this->_rootref['LIEN_APERCU'])) ? $this->_rootref['LIEN_APERCU'] : ''; ?>" title="Aperçu"><img src="design/defaut/images/apercu.png" alt="Aperçu"/></a> -->
		</form>
	
		
	
	
	

	
	<?php echo (isset($this->_rootref['CONTENU'])) ? $this->_rootref['CONTENU'] : ''; ?>
</div><!-- #principal -->