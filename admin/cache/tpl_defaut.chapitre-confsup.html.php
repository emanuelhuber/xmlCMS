<div id="secondaire">
	<?php echo (isset($this->_rootref['CONTENU_SECONDAIRE'])) ? $this->_rootref['CONTENU_SECONDAIRE'] : ''; ?>
	
</div><!-- #secondaire -->

<div id="principal">
		<?php $_info_count = (isset($this->_tpldata['info'])) ? sizeof($this->_tpldata['info']) : 0;if ($_info_count) {for ($_info_i = 0; $_info_i < $_info_count; ++$_info_i){$_info_val = &$this->_tpldata['info'][$_info_i]; ?>
		<div id="info">
			<p><img src="design/defaut/images/info.png" alt="enregistré"> Enregistré  <?php echo $_info_val['DATE']; ?></p>
		</div>
		<?php }} ?>
	
	<h2>Confirmation de suppression du chapitre "<?php echo (isset($this->_rootref['FORM_NOM'])) ? $this->_rootref['FORM_NOM'] : ''; ?>"</h2>
		<p>(id = <code><?php echo (isset($this->_rootref['FORM_ID'])) ? $this->_rootref['FORM_ID'] : ''; ?></code>)</p>

		<p> Confirmation de suppression de cette page :<br/>
			<strong>Titre</strong> : <?php echo (isset($this->_rootref['FORM_NOM'])) ? $this->_rootref['FORM_NOM'] : ''; ?>
		</p>
			
	<?php echo (isset($this->_rootref['CONTENU'])) ? $this->_rootref['CONTENU'] : ''; ?>
</div><!-- #principal -->