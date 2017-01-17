<div id="secondaire">
	<?php echo (isset($this->_rootref['CONTENU_SECONDAIRE'])) ? $this->_rootref['CONTENU_SECONDAIRE'] : ''; ?>
</div><!-- #secondaire -->

<div id="principal">
	<?php $_info_count = (isset($this->_tpldata['info'])) ? sizeof($this->_tpldata['info']) : 0;if ($_info_count) {for ($_info_i = 0; $_info_i < $_info_count; ++$_info_i){$_info_val = &$this->_tpldata['info'][$_info_i]; ?>
		<div id="info">
			<p><img src="design/defaut/images/info.png" alt="enregistré"> Enregistré  <?php echo $_info_val['DATE']; ?></p>
		</div>
	<?php }} ?>
	
<h1>Ajouter un utilisateur</h1>
	<div id="wrapper">
	   <ul class="tabs">
			<li><a href="<?php echo (isset($this->_rootref['LINK_USER'])) ? $this->_rootref['LINK_USER'] : ''; ?>">Utilisateurs</a></li>
			<li class="selected"><a href="<?php echo (isset($this->_rootref['LINK_ADD_USER'])) ? $this->_rootref['LINK_ADD_USER'] : ''; ?>" title="Ajouter un utilisateur">Ajouter un utilisateur</a></li>
		</ul>
		
	<!-- Editer les infos -->
		<form class="edit" name="editinfo" method="POST" action="<?php echo (isset($this->_rootref['FICHIER_CIBLE'])) ? $this->_rootref['FICHIER_CIBLE'] : ''; ?>">
			
			<fieldset class="metadonnees">
				<legend>Ajouter un utilisateur</legend>
				<p>	<label>Nom d'utilisateur <input type="text" name="user[username]" value="" size="50" maxlength="150"/></label></p>
				<!-- <p>	<label>Group <input type="text" name="user[type]" value="<?php echo (isset($this->_rootref['GROUP'])) ? $this->_rootref['GROUP'] : ''; ?>" size="50" maxlength="50"/></label></p> -->
				<p>	<label>Email <input type="text" name="user[email]" value="" size="50" maxlength="50" id="datepicker"/></label></p>
				<p>	<label>Mot de passe <input type="text" name="user[password]" value="" size="50" /></label></p>
				<p> <label>Groupe de l'utilisateur
						<select name="user[group]" size="1">
							<?php $_groups_count = (isset($this->_tpldata['groups'])) ? sizeof($this->_tpldata['groups']) : 0;if ($_groups_count) {for ($_groups_i = 0; $_groups_i < $_groups_count; ++$_groups_i){$_groups_val = &$this->_tpldata['groups'][$_groups_i]; ?>
							<option value="<?php echo $_groups_val['ID']; ?>"  
								<?php if ($_groups_val['SELECTED']) {  ?>
									selected="selected"
								<?php } ?>
							><?php echo $_groups_val['GRP_NAME']; ?></option>
							<?php }} ?>	
						</select>
					</label>
				</p>
			</fieldset>

			<input type="reset" name="nom" value="" class="refresh" />
			<input type="image" name="nom" src="design/defaut/images/save.png"  alt="Enregistrer" class="wymupdate" />
			<!-- <a href="<?php echo (isset($this->_rootref['LIEN_APERCU'])) ? $this->_rootref['LIEN_APERCU'] : ''; ?>" title="Aperçu"><img src="design/defaut/images/apercu.png" alt="Aperçu"/></a> -->
		</form>
	</div><!-- #wrapper -->
		
	
	
	

	
	<?php echo (isset($this->_rootref['CONTENU'])) ? $this->_rootref['CONTENU'] : ''; ?>
</div><!-- #principal -->