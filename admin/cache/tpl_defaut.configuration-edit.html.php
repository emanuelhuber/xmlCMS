<div id="secondaire">
	<h1>Attention !</h1>
	<p>Ne modifiez rien, si vous n'êtes pas sûr de vous !</p>
	<h1><img src="design/defaut/images/idea.png" width="50px"/>Comment écrire ?</h1>
	<p>Commentaire : &laquo;<code>; un commentaire est toujours précédé d'un point virgule</code>&raquo;</p>
	<p>Titre de section : &laquo;<code>[un-titre-de-section]</code>&raquo;</p>
	<p>données : &laquo;<code>conf="conf"</code>&raquo;</p>
</div><!-- #secondaire -->

<div id="principal">
	<?php $_info_count = (isset($this->_tpldata['info'])) ? sizeof($this->_tpldata['info']) : 0;if ($_info_count) {for ($_info_i = 0; $_info_i < $_info_count; ++$_info_i){$_info_val = &$this->_tpldata['info'][$_info_i]; ?>
		<div id="info">
			<p><img src="design/defaut/images/info.png" alt="enregistré"> Enregistré  <?php echo $_info_val['DATE']; ?></p>
		</div>
		<?php }} ?>
	<h1>Edition du fichier de configuration</h1>

	<form class="edit" name="editContent" method="POST" action="<?php echo (isset($this->_rootref['FICHIER_CIBLE'])) ? $this->_rootref['FICHIER_CIBLE'] : ''; ?>">	
			<fieldset class="contenu">
					<label> Contenu<br/>
					<textarea name="content" cols="74" rows="30" class="wymeditor"> <?php echo (isset($this->_rootref['CONTENT'])) ? $this->_rootref['CONTENT'] : ''; ?></textarea>
					</label>
			</fieldset>
				
				
			<input type="reset" name="nom" value="" class="refresh" />
			<input type="image" name="nom" src="design/defaut/images/save.png"  alt="Enregistrer" class="wymupdate" />
			<a href="<?php echo (isset($this->_rootref['LIEN_APERCU'])) ? $this->_rootref['LIEN_APERCU'] : ''; ?>" title="Aperçu"><img src="design/defaut/images/apercu.png" alt="Aperçu"/></a>
		</form>


	
	<?php echo (isset($this->_rootref['CONTENU'])) ? $this->_rootref['CONTENU'] : ''; ?>
</div><!-- #principal -->