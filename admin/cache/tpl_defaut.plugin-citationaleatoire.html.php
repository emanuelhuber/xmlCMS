<div id="secondaire">
	<p><img src="design/defaut/images/idea.png" width="50px"/>
	Structure:<br/>
	<code>citation#ref1#ref2#...#refx</code>
	</p>
	<?php echo (isset($this->_rootref['CONTENU_SECONDAIRE'])) ? $this->_rootref['CONTENU_SECONDAIRE'] : ''; ?>
	
	<h1>Utilisation</h1>	
<p>La citation :<pre><code>    %%% PLUGIN citationAleatoire:verset;1 %%% </code></pre>
<p>La référence :<pre><code>    %%% PLUGIN citationAleatoire:verset;2 %%%</code></pre></p>	
</div><!-- #secondaire -->

<div id="principal">
	<h1>Liste des citations (fichiers)</h1>

	
<form class="edit" name="editpage" method="POST" action="<?php echo (isset($this->_rootref['FICHIER_CIBLE'])) ? $this->_rootref['FICHIER_CIBLE'] : ''; ?>">
		<fieldset class="rubrique">
			<legend><img src="design/defaut/images/article-ajouter.png" alt="Créer un encart"/> Créer un fichier de citation</legend>
			<p><label>Titre du fichier de citation <input type="text" name="title" value="" size="50" maxlength="150"/></label>
			<input type="submit" name="nom" value="OK"/></p>
		</fieldset>
	</form>

	<?php $_liste_count = (isset($this->_tpldata['liste'])) ? sizeof($this->_tpldata['liste']) : 0;if ($_liste_count) {for ($_liste_i = 0; $_liste_i < $_liste_count; ++$_liste_i){$_liste_val = &$this->_tpldata['liste'][$_liste_i]; ?>
				<p><strong><code><?php echo $_liste_val['ID']; ?></code></strong><br/>
				<a href="<?php echo $_liste_val['EDIT_LINK']; ?>"><img src="design/defaut/images/editer-page.png" alt="Editer"/></a>
				<a href="<?php echo $_liste_val['DELETE_LINK']; ?>"><img src="design/defaut/images/supprimer-page.png" alt="Supprimer"/></a>
				</p>
	
	<?php }} ?>
	
	<?php echo (isset($this->_rootref['CONTENU'])) ? $this->_rootref['CONTENU'] : ''; ?>
</div><!-- #principal -->