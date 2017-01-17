<div id="secondaire">
	<p><img src="design/defaut/images/idea.png" width="50px"/>
		Si vous supprimez un MOT, ce MOT sera supprimé dans toutes langues.
		Si vous ajoutez un MOT, ce MOT sera ajouté dans toutes les langues.
	</p>
	<p>Dans les templates HTML, vous pouvez intégrez les MOTS du dictionnaires sour la forme 
	<code>&#123;L_MOT&#125;</code> et la définition sera automatiquement remplacé en fonction de la langue active. </p>
	

</div><!-- #secondaire -->

<div id="principal">
	<h1>"Dictionnaire"</h1>
	<!-- AJOUTER UNE CLEF -->
	<form class="edit" name="editpage" method="POST" action="<?php echo (isset($this->_rootref['FICHIER_CIBLE'])) ? $this->_rootref['FICHIER_CIBLE'] : ''; ?>">
		<fieldset class="rubrique">
			<legend><img src="design/defaut/images/plus.png" alt="Créer un article"/> Ajouter un MOT</legend>
			<p><label>Nom du MOT &nbsp;&nbsp;<input type="text" name="tag" value="" size="50" maxlength="150"/></label>
			<input type="submit" name="nom" value="OK"/></p>
		</fieldset>
	</form>	
	
	<p>
		<?php $_langues_count = (isset($this->_tpldata['langues'])) ? sizeof($this->_tpldata['langues']) : 0;if ($_langues_count) {for ($_langues_i = 0; $_langues_i < $_langues_count; ++$_langues_i){$_langues_val = &$this->_tpldata['langues'][$_langues_i]; ?>
		<a href="<?php echo $_langues_val['LINK']; ?>" title="<?php echo $_langues_val['ID']; ?>" class="drapeau<?php echo $_langues_val['ACTIVE']; ?>"><img alt="<?php echo $_langues_val['ID']; ?>" src="design/defaut/images/drapeau_<?php echo $_langues_val['ID']; ?>.pngc"/></a>
		<?php }} ?>
	</p>
	
	<!-- MODIFIER LES TRADUCTIONS -->
	<form class="edit" name="editContent" method="POST" action="<?php echo (isset($this->_rootref['FICHIER_CIBLE'])) ? $this->_rootref['FICHIER_CIBLE'] : ''; ?>">	
		<fieldset class="contenu">
				<?php $_mots_count = (isset($this->_tpldata['mots'])) ? sizeof($this->_tpldata['mots']) : 0;if ($_mots_count) {for ($_mots_i = 0; $_mots_i < $_mots_count; ++$_mots_i){$_mots_val = &$this->_tpldata['mots'][$_mots_i]; ?>
					<p><label><?php echo $_mots_val['TAG']; ?> 
					<a href="<?php echo $_mots_val['LINK_DELETE']; ?>" title="Supprimer le mot"><img src="design/defaut/images/supprimer-page.png" alt="Supprimer le mot"/></a>
					&nbsp;&nbsp;<input type="text" name="def[]" value="<?php echo $_mots_val['DEF']; ?>" size="50" maxlength="150"/></label></p>
				<?php }} ?>
				
				<!-- <label> Contenu<br/>
				<textarea name="content" cols="80" rows="30" class="wymeditor"> <?php echo (isset($this->_rootref['CONTENT'])) ? $this->_rootref['CONTENT'] : ''; ?></textarea>
				</label> -->
		</fieldset>
			
			
		<input type="reset" name="nom" value="" class="refresh" />
		<input type="image" name="nom" src="design/defaut/images/save.png"  alt="Enregistrer" class="wymupdate" />
		<a href="<?php echo (isset($this->_rootref['LIEN_APERCU'])) ? $this->_rootref['LIEN_APERCU'] : ''; ?>" title="Aperçu"><img src="design/defaut/images/apercu.png" alt="Aperçu"/></a>
	</form>

	
	<?php echo (isset($this->_rootref['CONTENU'])) ? $this->_rootref['CONTENU'] : ''; ?>
</div><!-- #principal -->