<div id="secondaire">
	<?php echo (isset($this->_rootref['CONTENU_SECONDAIRE'])) ? $this->_rootref['CONTENU_SECONDAIRE'] : ''; ?>
</div><!-- #secondaire -->

<div id="principal">
	
<h2>Gestion des documents</h2>
	<p>
		<ul class="tabs">
			<?php $_folders_count = (isset($this->_tpldata['folders'])) ? sizeof($this->_tpldata['folders']) : 0;if ($_folders_count) {for ($_folders_i = 0; $_folders_i < $_folders_count; ++$_folders_i){$_folders_val = &$this->_tpldata['folders'][$_folders_i]; ?>
				<li class="<?php echo $_folders_val['SELECTED']; ?>"><a href="<?php echo $_folders_val['LINK']; ?>"><img src="<?php echo $_folders_val['SRC']; ?>" alt="<?php echo $_folders_val['NAME']; ?>"/><?php echo $_folders_val['NAME']; ?></a></li>
			<?php }} ?>
		</ul>
	</p>
	<hr/>
	


	<?php $_liste_count = (isset($this->_tpldata['liste'])) ? sizeof($this->_tpldata['liste']) : 0;if ($_liste_count) {for ($_liste_i = 0; $_liste_i < $_liste_count; ++$_liste_i){$_liste_val = &$this->_tpldata['liste'][$_liste_i]; ?>
	<div class="freeBox">
		<p class="corner-top-right">
			<a href="<?php echo $_liste_val['LINK_EDIT']; ?>" title="Editer"><img src="design/defaut/images/editer-page.png" alt="Editer"/></a>
			<a href="<?php echo $_liste_val['LINK_DELETE']; ?>" title="Supprimer le fichier"><img src="design/defaut/images/supprimer-page.png" alt="Supprimer le fichier"/></a>
		</p>
		<p><a href="<?php echo $_liste_val['URL']; ?>" title="<?php echo $_liste_val['DESCRIPTION']; ?>">
		<img 
			<?php if ($_liste_val['IS_IMAGE']) {  ?> 
			height="72px" 
			<?php } ?> 
			src="<?php echo $_liste_val['SRC']; ?>" alt="<?php echo $_liste_val['DESCRIPTION']; ?>"/>
		</a></p>
		<?php if ($_liste_val['IS_IMAGE']) {  } else { ?>
		<p><a href="<?php echo $_liste_val['URL']; ?>" title="<?php echo $_liste_val['DESCRIPTION']; ?>"><?php echo $_liste_val['TITLE']; ?></a></p>
		<?php } ?> 
		<span
			<!-- <?php echo $_liste_val['EXT']; ?> -->
	</div>
	<?php }} ?>

<!-- <table>
	<tr>
		<th>Miniature</th>
		<th>Titre</th>
		<th>Extension</th>
		<th>Copyright</th>
		<th>Description</th>
		<th></th>
	</tr>
	<tr>
		<td><img src="<?php echo $_liste_val['SRC']; ?>" alt="icone"/></td>
		<td><a href="<?php echo $_liste_val['URL']; ?>" title="<?php echo $_liste_val['TITLE']; ?>"><?php echo $_liste_val['TITLE']; ?></a></td>
		<td><?php echo $_liste_val['EXT']; ?></td>
		<td><?php echo $_liste_val['COPYRIGHT']; ?></td>
		<td><?php echo $_liste_val['DESCRIPTION']; ?></td>
		<td></td>

	</tr>
</table> -->

	
	<?php echo (isset($this->_rootref['CONTENU'])) ? $this->_rootref['CONTENU'] : ''; ?>
</div><!-- #principal -->