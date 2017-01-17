<script type="text/javascript">
<!--

$(function() {
	$('#datepicker').datepicker({
		changeMonth: true,
		changeYear: true,
		dateFormat: 'dd.mm.yy'
	});
});
-->

</script>
<div id="secondaire">

	<?php echo (isset($this->_rootref['CONTENU_SECONDAIRE'])) ? $this->_rootref['CONTENU_SECONDAIRE'] : ''; ?>

</div><!-- #secondaire -->

<div id="principal">
		<?php $_info_count = (isset($this->_tpldata['info'])) ? sizeof($this->_tpldata['info']) : 0;if ($_info_count) {for ($_info_i = 0; $_info_i < $_info_count; ++$_info_i){$_info_val = &$this->_tpldata['info'][$_info_i]; ?>
		<div id="info">
			<p><img src="design/defaut/images/info.png" alt="enregistré"> Enregistré  <?php echo $_info_val['DATE']; ?></p>
		</div>
		<?php }} ?>
	<div id="wrapper">
		<h1>Edition de document</h1>
		
	
		<!-- Editer les infos -->
		<form class="edit" name="editinfo" method="POST" action="<?php echo (isset($this->_rootref['FICHIER_CIBLE'])) ? $this->_rootref['FICHIER_CIBLE'] : ''; ?>#tab1">
			
			<fieldset class="metadonnees">
				<legend>Méta-données</legend>
			
				<p>	<label>Titre <input type="text" name="info[title]" value="<?php echo (isset($this->_rootref['FORM_TITLE'])) ? $this->_rootref['FORM_TITLE'] : ''; ?>" size="50" maxlength="150"/></label></p>
				<p>	<label>Auteur <input type="text" name="info[copyright]" value="<?php echo (isset($this->_rootref['FORM_COPYRIGHT'])) ? $this->_rootref['FORM_COPYRIGHT'] : ''; ?>" size="50" maxlength="50"/></label></p>
				<p>	<label>Description <input type="text" name="info[description]" value="<?php echo (isset($this->_rootref['FORM_DESCRIPTION'])) ? $this->_rootref['FORM_DESCRIPTION'] : ''; ?>" size="50" /></label></p>
				
			</fieldset>
				
				
			<input type="reset" name="nom" value="" class="refresh" />
			<input type="image" name="nom" src="design/defaut/images/save.png"  alt="Enregistrer" class="wymupdate" />
			<a href="<?php echo (isset($this->_rootref['LIEN_APERCU'])) ? $this->_rootref['LIEN_APERCU'] : ''; ?>" title="Aperçu"><img src="design/defaut/images/apercu.png" alt="Aperçu"/></a>
		</form>
	</div><!-- #wrapper -->
	
	

	
	<?php echo (isset($this->_rootref['CONTENU'])) ? $this->_rootref['CONTENU'] : ''; ?>
</div><!-- #principal -->