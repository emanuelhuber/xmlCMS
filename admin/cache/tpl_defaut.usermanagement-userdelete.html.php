<div id="secondaire">
	
	<?php echo (isset($this->_rootref['CONTENU_SECONDAIRE'])) ? $this->_rootref['CONTENU_SECONDAIRE'] : ''; ?>
</div><!-- #secondaire -->

<div id="principal">
		<?php $_info_count = (isset($this->_tpldata['info'])) ? sizeof($this->_tpldata['info']) : 0;if ($_info_count) {for ($_info_i = 0; $_info_i < $_info_count; ++$_info_i){$_info_val = &$this->_tpldata['info'][$_info_i]; ?>
		<div id="info">
			<p><img src="design/defaut/images/info.png" alt="enregistré"> Enregistré  <?php echo $_info_val['DATE']; ?></p>
		</div>
	<?php }} ?>
	
	<h1>Supprimer un utilisateur</h1>
	
	<div id="wrapper">

	   <ul class="tabs">
			<li><a href="<?php echo (isset($this->_rootref['LINK_USER'])) ? $this->_rootref['LINK_USER'] : ''; ?>">Utilisateurs</a></li>
			<li><a href="<?php echo (isset($this->_rootref['LINK_ADD_USER'])) ? $this->_rootref['LINK_ADD_USER'] : ''; ?>" title="Ajouter un utilisateur">Ajouter un utilisateur</a></li>
			<li class="selected"><a href="#">Supprimer un utilisateur</a></li>
		</ul>
	
	
	
		<form class="edit" name="editinfo" method="POST" action="<?php echo (isset($this->_rootref['FICHIER_CIBLE'])) ? $this->_rootref['FICHIER_CIBLE'] : ''; ?>">
			
			<fieldset class="metadonnees">
				<legend>Supprimer un utilisateur</legend>
				<p> Voulez-vous vraiment supprimer cet utilisateur ?<br/>
	
			
					<strong>Nom de l'utilisateur :</strong> <?php echo (isset($this->_rootref['FORM_USERNAME'])) ? $this->_rootref['FORM_USERNAME'] : ''; ?><br/>
					<strong>Email :</strong><?php echo (isset($this->_rootref['FORM_EMAIL'])) ? $this->_rootref['FORM_EMAIL'] : ''; ?> <br/>
					<strong>Groupe :</strong><?php echo (isset($this->_rootref['FORM_GROUPNAME'])) ? $this->_rootref['FORM_GROUPNAME'] : ''; ?> <br/>
				</p>
				<p><label><input type="radio" name="ok" value="ok"/>Oui</label><br/>
				<label><input type="radio" name="ok" value="cancel" checked="checked"/>Non</label><br/></p>
				
			</fieldset>

			<input type="reset" name="nom" value="" class="refresh" />
			<input type="image" name="nom" src="design/defaut/images/save.png"  alt="Enregistrer" class="wymupdate" />
			<!-- <a href="<?php echo (isset($this->_rootref['LIEN_APERCU'])) ? $this->_rootref['LIEN_APERCU'] : ''; ?>" title="Aperçu"><img src="design/defaut/images/apercu.png" alt="Aperçu"/></a> -->
		</form>
	</div><!-- #wrapper -->
		
	
	
	

	
	<?php echo (isset($this->_rootref['CONTENU'])) ? $this->_rootref['CONTENU'] : ''; ?>
</div><!-- #principal -->