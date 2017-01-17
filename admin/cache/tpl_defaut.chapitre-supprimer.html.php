<div id="secondaire">
	<?php echo (isset($this->_rootref['CONTENU_SECONDAIRE'])) ? $this->_rootref['CONTENU_SECONDAIRE'] : ''; ?>
	
</div><!-- #secondaire -->

<div id="principal">
		<?php $_info_count = (isset($this->_tpldata['info'])) ? sizeof($this->_tpldata['info']) : 0;if ($_info_count) {for ($_info_i = 0; $_info_i < $_info_count; ++$_info_i){$_info_val = &$this->_tpldata['info'][$_info_i]; ?>
		<div id="info">
			<p><img src="design/defaut/images/info.png" alt="enregistré"> Enregistré  <?php echo $_info_val['DATE']; ?></p>
		</div>
		<?php }} ?>
	
	<h2>Supprimer le chaptire "<?php echo (isset($this->_rootref['FORM_NOM'])) ? $this->_rootref['FORM_NOM'] : ''; ?>"</h2>
		<p>(id = <code><?php echo (isset($this->_rootref['FORM_ID'])) ? $this->_rootref['FORM_ID'] : ''; ?></code>)</p>
		<form class="edit" name="editinfo" method="POST" action="<?php echo (isset($this->_rootref['FICHIER_CIBLE'])) ? $this->_rootref['FICHIER_CIBLE'] : ''; ?>">
			
			<fieldset class="metadonnees">
				<legend>Supprimer ce chapitre ?</legend>
				<p> Voulez-vous vraiment supprimer ce chapitre ???<br/>
					<strong>Titre</strong> : <?php echo (isset($this->_rootref['FORM_NOM'])) ? $this->_rootref['FORM_NOM'] : ''; ?> <br/>
				</p>
				<p><label><input type="radio" name="ok" value="ok"/>Oui</label><br/>
				<label><input type="radio" name="ok" value="cancel" checked="checked"/>Non</label><br/></p>
				<p><em>Attention,</em> le pages contenues dans ce chapitre ne seront pas supprimées. Seul le chapitre sera supprimé.</p>
				
			</fieldset>

			<input type="reset" name="nom" value="" class="refresh" />
			<input type="image" name="nom" src="design/defaut/images/save.png"  alt="Enregistrer" class="wymupdate" />
			<!-- <a href="<?php echo (isset($this->_rootref['LIEN_APERCU'])) ? $this->_rootref['LIEN_APERCU'] : ''; ?>" title="Aperçu"><img src="design/defaut/images/apercu.png" alt="Aperçu"/></a> -->
		</form>
	
	<?php echo (isset($this->_rootref['CONTENU'])) ? $this->_rootref['CONTENU'] : ''; ?>
</div><!-- #principal -->