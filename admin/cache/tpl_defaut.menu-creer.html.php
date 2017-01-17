<div id="secondaire">
	<?php echo (isset($this->_rootref['CONTENU_SECONDAIRE'])) ? $this->_rootref['CONTENU_SECONDAIRE'] : ''; ?>
</div><!-- #secondaire -->

<div id="principal">
	
	<h1>Créer un nouveau contenu</h1>

	<p> Choisissez la langue dans laquelle le contenu sera publié ainsi que le type de contenu (= module).
	</p>
	<form class="edit" name="editpage" method="POST" action="<?php echo (isset($this->_rootref['FICHIER_CIBLE'])) ? $this->_rootref['FICHIER_CIBLE'] : ''; ?>">
		
		<fieldset class="rubrique">
			<legend>Nouveau contenu</legend>
			<p><label>Titre du contenu <input type="text" name="page[titre]" value="" size="50" maxlength="150"/></label></p>
			<p><label>Nom de la page (url), optionel.<br/> Charactères autorisés: [a-z]+[0-9]; mots séparés par des tirets "-"<br/> 
				<input type="text" name="page[fileId]" value="" size="50" maxlength="150"/></label></p>
			<p>	<label>Langue 	<select name="page[langue]" size="1">
									<?php $_langue_count = (isset($this->_tpldata['langue'])) ? sizeof($this->_tpldata['langue']) : 0;if ($_langue_count) {for ($_langue_i = 0; $_langue_i < $_langue_count; ++$_langue_i){$_langue_val = &$this->_tpldata['langue'][$_langue_i]; ?>
										<option value="<?php echo $_langue_val['ID']; ?>"><?php echo $_langue_val['NOM']; ?></option>
									<?php }} ?>
								</select>
				</label>
			</p>
			<p>	<label>Module 	<select name="page[module]" size="1">
									<?php $_module_count = (isset($this->_tpldata['module'])) ? sizeof($this->_tpldata['module']) : 0;if ($_module_count) {for ($_module_i = 0; $_module_i < $_module_count; ++$_module_i){$_module_val = &$this->_tpldata['module'][$_module_i]; ?>
										<option value="<?php echo $_module_val['ID']; ?>"><?php echo $_module_val['NOM']; ?></option>
									<?php }} ?>
								</select>
				</label>
			</p>
			<p>	<label>Theme / style 	<select name="page[themestyle]" size="1">
									<?php $_themestyle_count = (isset($this->_tpldata['themestyle'])) ? sizeof($this->_tpldata['themestyle']) : 0;if ($_themestyle_count) {for ($_themestyle_i = 0; $_themestyle_i < $_themestyle_count; ++$_themestyle_i){$_themestyle_val = &$this->_tpldata['themestyle'][$_themestyle_i]; ?>
										<option value="<?php echo $_themestyle_val['ID']; ?>"><?php echo $_themestyle_val['NOM']; ?></option>
									<?php }} ?>
								</select>
				</label>
			</p>
		</fieldset>
		<input type="submit" name="nom" value="OK"/>
	</form>
	
	<?php echo (isset($this->_rootref['CONTENU'])) ? $this->_rootref['CONTENU'] : ''; ?>
</div><!-- #principal -->