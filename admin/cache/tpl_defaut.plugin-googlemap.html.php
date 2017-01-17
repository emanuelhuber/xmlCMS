<div id="secondaire">

	<img src="design/defaut/images/idea.png" width="50px"/>
	<?php echo (isset($this->_rootref['CONTENU_SECONDAIRE'])) ? $this->_rootref['CONTENU_SECONDAIRE'] : ''; ?>
	
	<h1>Utlisation</h1>
	<pre><code>%%%&nbsp;PLUGIN googleMap:EPE_AMIENS %%%</code></pre>
</div><!-- #secondaire -->

<div id="principal">
	<h1>Liste des plans/cartes (googlemap)</h1>
	<p>(correspond à des dossiers)</p>

	<ul>
	<?php $_liste_count = (isset($this->_tpldata['liste'])) ? sizeof($this->_tpldata['liste']) : 0;if ($_liste_count) {for ($_liste_i = 0; $_liste_i < $_liste_count; ++$_liste_i){$_liste_val = &$this->_tpldata['liste'][$_liste_i]; ?>
				<li><strong><code><?php echo $_liste_val['ID']; ?></code></strong>
				<a href="<?php echo $_liste_val['DELETE_LINK']; ?>"><img src="design/defaut/images/supprimer-page.png" alt="Supprimer"/></a>
				</li>
	
	<?php }} ?>
</ul>


	
	<?php echo (isset($this->_rootref['CONTENU'])) ? $this->_rootref['CONTENU'] : ''; ?>
</div><!-- #principal -->