<div id="secondaire">
	<?php echo (isset($this->_rootref['CONTENU_SECONDAIRE'])) ? $this->_rootref['CONTENU_SECONDAIRE'] : ''; ?>
</div><!-- #secondaire -->

<div id="principal">
	<h2><?php echo ((isset($this->_rootref['L_CONNECTION'])) ? $this->_rootref['L_CONNECTION'] : ((isset($this->lang['CONNECTION'])) ? $this->lang['CONNECTION'] : '{ CONNECTION }')); ?></h2>
			
			<p class="alerte"><?php echo (isset($this->_rootref['MESSAGE'])) ? $this->_rootref['MESSAGE'] : ''; ?></p>
			
		<form class="quiz" name="quiz" method="post" class="form" action="<?php echo (isset($this->_rootref['FICHIER_CIBLE'])) ? $this->_rootref['FICHIER_CIBLE'] : ''; ?>">
			<p><label for="name"><?php echo ((isset($this->_rootref['L_USERNAME'])) ? $this->_rootref['L_USERNAME'] : ((isset($this->lang['USERNAME'])) ? $this->lang['USERNAME'] : '{ USERNAME }')); ?> :</label>  <input type="text" name="username" id="username" size="40" value="<?php echo (isset($this->_rootref['VALEUR_NOM'])) ? $this->_rootref['VALEUR_NOM'] : ''; ?>"/>
			</p>
			<p><label for="mail"><?php echo ((isset($this->_rootref['L_PASSWORD'])) ? $this->_rootref['L_PASSWORD'] : ((isset($this->lang['PASSWORD'])) ? $this->lang['PASSWORD'] : '{ PASSWORD }')); ?> :</label>  <input type="password" name="password" id="password" size="40" value="<?php echo (isset($this->_rootref['VALEUR_MAIL'])) ? $this->_rootref['VALEUR_MAIL'] : ''; ?>"/>
			</p>
			<input type="hidden" name="token" id="ok" value="<?php echo (isset($this->_rootref['TOKEN'])) ? $this->_rootref['TOKEN'] : ''; ?>"/> 
			
			
			<div class="right">
				<input type="submit" value="Envoyer" name="suivant"/>
				<input type="reset" value="Reset"/>
			</div>
			
			<p>
				<a href="<?php echo (isset($this->_rootref['REF'])) ? $this->_rootref['REF'] : ''; ?>" title="<?php echo (isset($this->_rootref['RETOUR'])) ? $this->_rootref['RETOUR'] : ''; ?>!"><?php echo ((isset($this->_rootref['L_RETOUR'])) ? $this->_rootref['L_RETOUR'] : ((isset($this->lang['RETOUR'])) ? $this->lang['RETOUR'] : '{ RETOUR }')); ?></a>
			</p>
		</form>
	</div>
</div><!-- #principal -->