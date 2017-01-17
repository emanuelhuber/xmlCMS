<div id="secondaire">
	<?php echo (isset($this->_rootref['CONTENU_SECONDAIRE'])) ? $this->_rootref['CONTENU_SECONDAIRE'] : ''; ?>
</div><!-- #secondaire -->

<div id="principal">
	
<h2>Upload de fichier</h2>

<table>
<?php $_liste_count = (isset($this->_tpldata['liste'])) ? sizeof($this->_tpldata['liste']) : 0;if ($_liste_count) {for ($_liste_i = 0; $_liste_i < $_liste_count; ++$_liste_i){$_liste_val = &$this->_tpldata['liste'][$_liste_i]; ?>
	<tr>
		<td><img src="<?php echo $_liste_val['URL']; ?>" alt="icone"/></td>
		<td><?php echo $_liste_val['MESSAGE']; ?><br/>
			Titre = <?php echo $_liste_val['TITLE']; ?><br/>
			Copyright = <?php echo $_liste_val['COPYRIGHT']; ?><br/>
			Description = <?php echo $_liste_val['DESCRIPTION']; ?><br/>
		</td>
	</tr>
<?php }} ?>
</table>



	<p>
		<a href="<?php echo (isset($this->_rootref['URL_UPLOAD'])) ? $this->_rootref['URL_UPLOAD'] : ''; ?>" title="uploader d'autres fichiers">Uploader d'autres fichiers</a>
	</p>

	
	<?php echo (isset($this->_rootref['CONTENU'])) ? $this->_rootref['CONTENU'] : ''; ?>
</div><!-- #principal -->