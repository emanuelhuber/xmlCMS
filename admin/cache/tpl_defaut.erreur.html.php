<div id="secondaire">
	<?php echo (isset($this->_rootref['CONTENU_SECONDAIRE'])) ? $this->_rootref['CONTENU_SECONDAIRE'] : ''; ?>
</div><!-- #secondaire -->

<div id="principal">
	<h2><?php echo (isset($this->_rootref['ERREUR_CODE'])) ? $this->_rootref['ERREUR_CODE'] : ''; ?></h2>

	
	<?php echo (isset($this->_rootref['CONTENU'])) ? $this->_rootref['CONTENU'] : ''; ?>
	
<p><?php echo (isset($this->_rootref['ERREUR_EXPLICATION'])) ? $this->_rootref['ERREUR_EXPLICATION'] : ''; ?></p>

<p><?php echo (isset($this->_rootref['MESSAGE'])) ? $this->_rootref['MESSAGE'] : ''; ?></p>
</div><!-- #principal -->