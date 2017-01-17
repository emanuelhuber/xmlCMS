<div id="secondaire">
	<h1>Editer un des groupes</h1>
	<img src="design/defaut/images/idea.png" width="50px"/>
	<p>
	<?php $_listgroup_count = (isset($this->_tpldata['listgroup'])) ? sizeof($this->_tpldata['listgroup']) : 0;if ($_listgroup_count) {for ($_listgroup_i = 0; $_listgroup_i < $_listgroup_count; ++$_listgroup_i){$_listgroup_val = &$this->_tpldata['listgroup'][$_listgroup_i]; ?>
		<a href="<?php echo $_listgroup_val['LINK_EDIT']; ?>" title="Editer le groupe"><?php echo $_listgroup_val['GRP_NAME']; ?> (<?php echo $_listgroup_val['RIGHT']; ?>)</a><br/>
		</tr>
	<?php }} ?>
	</p>
	<?php echo (isset($this->_rootref['CONTENU_SECONDAIRE'])) ? $this->_rootref['CONTENU_SECONDAIRE'] : ''; ?>
</div><!-- #secondaire -->

<div id="principal">
	<?php $_info_count = (isset($this->_tpldata['info'])) ? sizeof($this->_tpldata['info']) : 0;if ($_info_count) {for ($_info_i = 0; $_info_i < $_info_count; ++$_info_i){$_info_val = &$this->_tpldata['info'][$_info_i]; ?>
		<div id="info">
			<p><img src="design/defaut/images/info.png" alt="enregistré"> Enregistré  <?php echo $_info_val['DATE']; ?></p>
		</div>
	<?php }} ?>

	<h1>Supprimer un groupe</h1>
	
	<div id="wrapper">

	   <ul class="tabs">
			<li><a href="<?php echo (isset($this->_rootref['LINK_GROUP'])) ? $this->_rootref['LINK_GROUP'] : ''; ?>">Groupes</a></li>
			<li><a href="<?php echo (isset($this->_rootref['LINK_ADD_GROUP'])) ? $this->_rootref['LINK_ADD_GROUP'] : ''; ?>" title="Ajouter un groupe">Ajouter un groupe</a></li>
			<li class="selected"><a href="" title="Supprimer un groupe">Supprimer un groupe</a></li>
		</ul>
	
	
	
		<form class="edit" name="editinfo" method="POST" action="<?php echo (isset($this->_rootref['FICHIER_CIBLE'])) ? $this->_rootref['FICHIER_CIBLE'] : ''; ?>">
			
			<fieldset class="metadonnees">
				<legend>Supprimer un groupe ?</legend>
				<p> Voulez-vous vraiment supprimer ce groupe ?<br/>
					<strong>Nom du groupe :</strong> <?php echo (isset($this->_rootref['FORM_NAME'])) ? $this->_rootref['FORM_NAME'] : ''; ?> (<?php echo (isset($this->_rootref['FORM_RIGHT'])) ? $this->_rootref['FORM_RIGHT'] : ''; ?>)<br/>
					<strong>Description :</strong><?php echo (isset($this->_rootref['FORM_DESCRIPTION'])) ? $this->_rootref['FORM_DESCRIPTION'] : ''; ?> <br/>

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