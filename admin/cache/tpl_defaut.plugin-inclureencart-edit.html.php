<div id="secondaire">
	<h1>Liste des encarts</h1>
	<?php $_liste_count = (isset($this->_tpldata['liste'])) ? sizeof($this->_tpldata['liste']) : 0;if ($_liste_count) {for ($_liste_i = 0; $_liste_i < $_liste_count; ++$_liste_i){$_liste_val = &$this->_tpldata['liste'][$_liste_i]; ?>
				<strong><?php echo $_liste_val['ID']; ?></strong>&nbsp;&nbsp;
				<a href="<?php echo $_liste_val['EDIT_LINK']; ?>"><img src="design/defaut/images/editer-page.png" alt="Editer"/></a>
				<a href="<?php echo $_liste_val['DELETE_LINK']; ?>"><img src="design/defaut/images/supprimer-page.png" alt="Supprimer"/></a>
				<br/>
	
	<?php }} ?>
</div><!-- #secondaire -->

<div id="principal">
	<h1>Edition de l'encart "<code><?php echo (isset($this->_rootref['ID'])) ? $this->_rootref['ID'] : ''; ?></code>"</h1>

	<form class="edit" name="editContent" method="POST" action="<?php echo (isset($this->_rootref['FICHIER_CIBLE'])) ? $this->_rootref['FICHIER_CIBLE'] : ''; ?>">	
			<fieldset class="contenu">
					<label> Contenu<br/>
					<textarea name="content" cols="80" rows="200" class="wymeditor"> <?php echo (isset($this->_rootref['CONTENT'])) ? $this->_rootref['CONTENT'] : ''; ?></textarea>
					</label>
			</fieldset>
				
				
			<input type="reset" name="nom" value="" class="refresh" />
			<input type="image" name="nom" src="design/defaut/images/save.png"  alt="Enregistrer" class="wymupdate" />
			<!-- <a href="<?php echo (isset($this->_rootref['LIEN_APERCU'])) ? $this->_rootref['LIEN_APERCU'] : ''; ?>" title="Aperçu"><img src="design/defaut/images/apercu.png" alt="Aperçu"/></a> -->
		</form>


	
	<?php echo (isset($this->_rootref['CONTENU'])) ? $this->_rootref['CONTENU'] : ''; ?>
</div><!-- #principal -->