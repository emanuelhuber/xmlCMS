<div id="secondaire">
	<?php echo (isset($this->_rootref['CONTENU_SECONDAIRE'])) ? $this->_rootref['CONTENU_SECONDAIRE'] : ''; ?>
</div><!-- #secondaire -->

<div id="principal">
	<div id="chemin2fer">
		<img src="design/ichthus/images/camp.png" alt="<?php echo ((isset($this->_rootref['L_VOUS_ETES_ICI'])) ? $this->_rootref['L_VOUS_ETES_ICI'] : ((isset($this->lang['VOUS_ETES_ICI'])) ? $this->lang['VOUS_ETES_ICI'] : '{ VOUS_ETES_ICI }')); ?>"/> 
		<?php $_crumbs_count = (isset($this->_tpldata['crumbs'])) ? sizeof($this->_tpldata['crumbs']) : 0;if ($_crumbs_count) {for ($_crumbs_i = 0; $_crumbs_i < $_crumbs_count; ++$_crumbs_i){$_crumbs_val = &$this->_tpldata['crumbs'][$_crumbs_i]; if ($_crumbs_val['IS_LINK']) {  ?>
			<a href="<?php echo $_crumbs_val['LINK']; ?>" title="<?php echo $_crumbs_val['TITLE']; ?>"><?php echo $_crumbs_val['NAME']; ?></a>
			<?php } else { ?>
				<?php echo $_crumbs_val['NAME']; ?>
			<?php } ?>
				<img src="design/ichthus/images/fleche_droite_rouge.gifc" alt="fleche rouge"/>
		<?php }} ?>
		<?php echo (isset($this->_rootref['CURRENT_CRUMB'])) ? $this->_rootref['CURRENT_CRUMB'] : ''; ?>
	</div>
	
	<?php echo (isset($this->_rootref['CONTENU_PRINCIPAL'])) ? $this->_rootref['CONTENU_PRINCIPAL'] : ''; ?>

	
</div><!-- #principal -->