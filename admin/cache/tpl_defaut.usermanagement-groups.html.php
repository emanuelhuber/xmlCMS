<div id="secondaire">
	<?php echo (isset($this->_rootref['CONTENU_SECONDAIRE'])) ? $this->_rootref['CONTENU_SECONDAIRE'] : ''; ?>
</div><!-- #secondaire -->

<div id="principal">
	<?php $_info_count = (isset($this->_tpldata['info'])) ? sizeof($this->_tpldata['info']) : 0;if ($_info_count) {for ($_info_i = 0; $_info_i < $_info_count; ++$_info_i){$_info_val = &$this->_tpldata['info'][$_info_i]; ?>
		<div id="info">
			<p><img src="design/defaut/images/info.png" alt="enregistré"> Enregistré  <?php echo $_info_val['DATE']; ?></p>
		</div>
	<?php }} ?>

<h1>Gestion des groupes</h1>
	<div id="wrapper">
	    <ul class="tabs">
			<li class="selected"><a href="<?php echo (isset($this->_rootref['LINK_GROUP'])) ? $this->_rootref['LINK_GROUP'] : ''; ?>">Groupes</a></li>
			<li><a href="<?php echo (isset($this->_rootref['LINK_ADD_GROUP'])) ? $this->_rootref['LINK_ADD_GROUP'] : ''; ?>" title="Ajouter un groupe">Ajouter un groupe</a></li>
		</ul>
		<div class="edit">
			<table>
				<tr>
					<th>ID</th>
					<th>Nom de groupe</th>
					<th>Description</th>
					<th>Droits</th>
					<th>Edit</th>
					<th>Suppr</th>
				</tr>
			<?php $_listgroup_count = (isset($this->_tpldata['listgroup'])) ? sizeof($this->_tpldata['listgroup']) : 0;if ($_listgroup_count) {for ($_listgroup_i = 0; $_listgroup_i < $_listgroup_count; ++$_listgroup_i){$_listgroup_val = &$this->_tpldata['listgroup'][$_listgroup_i]; ?>
				<tr>
					<td><?php echo $_listgroup_val['ID']; ?></td>
					<td><?php echo $_listgroup_val['GRP_NAME']; ?></td>
					<td><?php echo $_listgroup_val['GRP_DESCRIPTION']; ?></td>
					<td><?php echo $_listgroup_val['RIGHT']; ?></td>
					<td><a href="<?php echo $_listgroup_val['LINK_EDIT']; ?>" title="Editer le groupe"><img src="design/defaut/images/editer-page.png" alt="Editer le groupe"/></a></td>
					<td><a href="<?php echo $_listgroup_val['LINK_DELETE']; ?>" title="Supprimer le groupe"><img src="design/defaut/images/supprimer-page.png" alt="Supprimer le groupe"/></a></td>
				</tr>
			<?php }} ?>
			</table>
		</div>	
	</div><!-- #wrapper -->
	

	
	<?php echo (isset($this->_rootref['CONTENU'])) ? $this->_rootref['CONTENU'] : ''; ?>
</div><!-- #principal -->