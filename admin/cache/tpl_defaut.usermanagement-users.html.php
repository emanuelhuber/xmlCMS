<div id="secondaire">
	<?php echo (isset($this->_rootref['CONTENU_SECONDAIRE'])) ? $this->_rootref['CONTENU_SECONDAIRE'] : ''; ?>
</div><!-- #secondaire -->

<div id="principal_large">
		<?php $_info_count = (isset($this->_tpldata['info'])) ? sizeof($this->_tpldata['info']) : 0;if ($_info_count) {for ($_info_i = 0; $_info_i < $_info_count; ++$_info_i){$_info_val = &$this->_tpldata['info'][$_info_i]; ?>
		<div id="info">
			<p><img src="design/defaut/images/info.png" alt="enregistré"> Enregistré  <?php echo $_info_val['DATE']; ?></p>
		</div>
	<?php }} ?>
	
	<h1>Gestion des utilisateurs</h1>
	
	<div id="wrapper">
	    <ul class="tabs">
			<li class="selected"><a href="<?php echo (isset($this->_rootref['LINK_USER'])) ? $this->_rootref['LINK_USER'] : ''; ?>">Utilisateurs</a></li>
			<li><a href="<?php echo (isset($this->_rootref['LINK_ADD_USER'])) ? $this->_rootref['LINK_ADD_USER'] : ''; ?>" title="Ajouter un utilisateur">Ajouter un utilisateur</a></li>
		</ul>
		<div class="edit">
			<table>
				<tr>
					<th>Pseudo</th>
					<th>Groupe</th>
					<th>Email</th>
					<th>Droits</th>
					<th>Correctement déconnecté ?</th>
					<th>Date de déconnection</th>
					<th>Editer</th>
					<th>Supprimer</th>
				</tr>
			<?php $_list_count = (isset($this->_tpldata['list'])) ? sizeof($this->_tpldata['list']) : 0;if ($_list_count) {for ($_list_i = 0; $_list_i < $_list_count; ++$_list_i){$_list_val = &$this->_tpldata['list'][$_list_i]; ?>
				<tr>
					<td><?php echo $_list_val['USERNAME']; ?></td>
					<td><?php echo $_list_val['GROUPNAME']; ?></td>
					<td><?php echo $_list_val['EMAIL']; ?></td>
					<td><?php echo $_list_val['DROITS']; ?></td>
					<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<?php if ($_list_val['T_LOGOUT']) {  ?>
						<img src="design/defaut/images/green_shield.png" alt="L'utilisateur s'est correctement déconnecté"/>
					<?php } else { ?>
						<img src="design/defaut/images/red_shield.png" alt="L'utilisateur ne s'est pas correctement déconnecté"/>
					<?php } ?>
					</td>
					<td><?php echo $_list_val['DATE']; ?></td>
					<td>&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo $_list_val['LINK_EDIT']; ?>" title="Editer l'utilisateur"><img src="design/defaut/images/editer-page.png" alt="Editer l'utilisateur"/></a></td>
					<td>&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo $_list_val['LINK_DELETE']; ?>" title="Supprimer l'utilisateur"><img src="design/defaut/images/supprimer-page.png" alt="Supprimer l'utilisateur"/></a></td>
				</tr>
			<?php }} ?>
			</table>
		</div>
	</div><!-- #wrapper -->
	
	

	
	<?php echo (isset($this->_rootref['CONTENU'])) ? $this->_rootref['CONTENU'] : ''; ?>
</div><!-- #principal -->