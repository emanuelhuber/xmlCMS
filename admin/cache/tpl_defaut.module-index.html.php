<div id="secondaire">
	<?php echo (isset($this->_rootref['CONTENU_SECONDAIRE'])) ? $this->_rootref['CONTENU_SECONDAIRE'] : ''; ?>
</div><!-- #secondaire -->

<div id="principal">
	<h2>Liste des modules (juste pour info)</h2>

<!-- <p><a href="<?php echo (isset($this->_rootref['LIEN_CREER_PAGE'])) ? $this->_rootref['LIEN_CREER_PAGE'] : ''; ?>" title="Ajouter un module"><img src="design/defaut/images/modules-ajouter.png" alt="Ajouter un module"/> Ajouter un module</a></p>
 -->
<table border="0px">
	<?php $_liste_count = (isset($this->_tpldata['liste'])) ? sizeof($this->_tpldata['liste']) : 0;if ($_liste_count) {for ($_liste_i = 0; $_liste_i < $_liste_count; ++$_liste_i){$_liste_val = &$this->_tpldata['liste'][$_liste_i]; ?>
				<tr>
					<td><img src="design/defaut/images/module-<?php echo $_liste_val['ID']; ?>.png" alt="Module <?php echo $_liste_val['NOM']; ?>"/></td>
					<td><strong><?php echo $_liste_val['NOM']; ?></strong><br/>
					<?php echo $_liste_val['DESCRIPTION']; ?></td>
				</tr>
	
	<?php }} ?>
</table>


	
	<?php echo (isset($this->_rootref['CONTENU'])) ? $this->_rootref['CONTENU'] : ''; ?>
</div><!-- #principal -->