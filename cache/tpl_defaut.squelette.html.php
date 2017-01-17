<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">  
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">
<head>


	<title><?php echo (isset($this->_rootref['INFO_TITRE'])) ? $this->_rootref['INFO_TITRE'] : ''; ?></title>
	
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<meta name="description" content="<?php echo (isset($this->_rootref['INFO_DESCRIPTION'])) ? $this->_rootref['INFO_DESCRIPTION'] : ''; ?>"/>
	<meta name="keywords" content="<?php echo (isset($this->_rootref['INFO_MOTSCLEFS'])) ? $this->_rootref['INFO_MOTSCLEFS'] : ''; ?>"/>
	<meta name="robots" content="index,follow" />
	
	<!-- Pour inclure un FAVICON -->
	<link rel="shortcut icon" href="favicon.ico"/>
	
	<!-- flux de syndication -->
	<link rel = "alternate" type = "application/atom+xml" title = "Flux de syndication" href = "<?php echo (isset($this->_rootref['LINK_RSS'])) ? $this->_rootref['LINK_RSS'] : ''; ?>" />	
	
	<?php $_css_count = (isset($this->_tpldata['css'])) ? sizeof($this->_tpldata['css']) : 0;if ($_css_count) {for ($_css_i = 0; $_css_i < $_css_count; ++$_css_i){$_css_val = &$this->_tpldata['css'][$_css_i]; ?>
		<link rel="stylesheet"  media="<?php echo $_css_val['MEDIA']; ?>" type="text/css" href="<?php echo $_css_val['REF']; ?>zip"/>
	<?php }} ?><!-- javascript -->
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
	<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
	<script type="text/javascript" src="design/defaut/js/jquery.cycle.all.jszip"></script>
	<script type="text/javascript">
	$(document).ready(function() {
		$('.slideshow').cycle({
			fx: 'fade', 
			/* choose your transition type, ex: fade, scrollUp, shuffle, etc... */
			speed:  3000,
			next:   '.slideshow',
		});
		
	
		/* BOITE DE DIALOGUE POUR INFORMATIONS TECHNIQUES SUR LA PAGE */
		$(document)
			.find('p#infos_site').click(function() {
				$('#infos_techniques').dialog({dialogClass:'infostechniques'});
			});
	});
	</script>
	<script type="text/javascript" src="design/defaut/js/jquery.corner.jszip"></script>
	<script type="text/JavaScript">
		$(function(){
			$('div#menu-horizontal').corner('30px top');
			$('div#menu-horizontal .activated').corner('10px top');
			$('div#menu-horizontal a').corner('10px top');
			$('#principal img').corner('6px');
			$('#principal a.article').corner('5px');
			$('#secondaire img').corner('6px');
			$('#principal .bloc').corner('6px');
		});

	</script>
	
</head>

<body>

<div id="global">
	<div id="menu-horizontal">
		<div id="entete">
		  <h1>My website!</h1>		
	  </div><!-- #entete -->
	</div>
	<div id="centre">
	<div id="centre-bis">
		<div id="menu">
			<div id="login"></div>
			<div id="container_menu">
				<ul>
					<?php $_menu1_count = (isset($this->_tpldata['menu1'])) ? sizeof($this->_tpldata['menu1']) : 0;if ($_menu1_count) {for ($_menu1_i = 0; $_menu1_i < $_menu1_count; ++$_menu1_i){$_menu1_val = &$this->_tpldata['menu1'][$_menu1_i]; ?>
					<li><a class="<?php echo $_menu1_val['CLASS']; ?>" href="<?php echo $_menu1_val['REF']; ?>"><?php if ($_menu1_val['T_SMENU']) {  ?> + <?php } echo $_menu1_val['NAME']; ?> </a>	
					<?php if ($_menu1_val['T_SMENU']) {  ?>
						<ul class="<?php echo $_menu1_val['SCLASS']; ?>" >
					<?php $_menu2_count = (isset($_menu1_val['menu2'])) ? sizeof($_menu1_val['menu2']) : 0;if ($_menu2_count) {for ($_menu2_i = 0; $_menu2_i < $_menu2_count; ++$_menu2_i){$_menu2_val = &$_menu1_val['menu2'][$_menu2_i]; ?>
							<li><a class="<?php echo $_menu2_val['CLASS']; ?>" href="<?php echo $_menu2_val['REF']; ?>"><?php echo $_menu2_val['NAME']; ?></a></li>
					<?php }} ?>
						</ul>
					<?php } ?>
					</li>
					<?php }} ?>
				</ul>
				<?php $_alert_count = (isset($this->_tpldata['alert'])) ? sizeof($this->_tpldata['alert']) : 0;if ($_alert_count) {for ($_alert_i = 0; $_alert_i < $_alert_count; ++$_alert_i){$_alert_val = &$this->_tpldata['alert'][$_alert_i]; ?>
	      <p class="alert">
		    <?php echo ((isset($this->_rootref['L_ALERTE'])) ? $this->_rootref['L_ALERTE'] : ((isset($this->lang['ALERTE'])) ? $this->lang['ALERTE'] : '{ ALERTE }')); ?> <br/>(<?php echo $_alert_val['JOUR']; ?> <?php echo $_alert_val['MOIS']; ?> <?php echo $_alert_val['ANNEE']; ?>)
	       </p>
	      <?php }} ?>
			</div> <!-- container_menu -->
		</div><!-- #menu -->
		<?php echo (isset($this->_rootref['PAGE'])) ? $this->_rootref['PAGE'] : ''; ?>
		<div id="fleche_haut"><a href="#centre" title="Aller en haut de la page"><img src="design/defaut/images/flechehaut1.pngc" alt="en haut"/></a></div>
	</div><!-- #centre-bis -->
	</div><!-- #centre -->
</div><!-- #global -->

<div id="pied">
  <!-- Accueil | Plan du site | Mentions l&amp;eacute;gales | Partenariats | Contact -->

  <p id="copyright">
    &copy; My website 2017!
  </p>
  <p>Dernière modification : <?php echo (isset($this->_rootref['FILETIME'])) ? $this->_rootref['FILETIME'] : ''; ?></p>
  <p><a href="http://validator.w3.org/check/referer">XHTML</a> & <a href="http://jigsaw.w3.org/css-validator/check/referer">CSS</a></p>
  <p id="infos_site">Infos Site</p>
  <div id="infos_techniques">
    <h2>Informations techniques sur la page</h2>
    <h3>Design</h3>
    <p>
    <!-- <p>Nom fichier internet : <?php echo (isset($this->_rootref['FILENAME_WEB'])) ? $this->_rootref['FILENAME_WEB'] : ''; ?></p> -->
    <?php if ($this->_rootref['T_COMP_GZIP']) {  ?>
      Compression GZIP activée
      <?php } else { ?>
      Pas de compression GZIP
      <?php } ?><br/>
    <?php echo (isset($this->_rootref['ACTIVE_LANG'])) ? $this->_rootref['ACTIVE_LANG'] : ''; ?> (<?php echo (isset($this->_rootref['ACTIVE_LANG_ID'])) ? $this->_rootref['ACTIVE_LANG_ID'] : ''; ?>)</p>
    <h3>Design</h3>
    <p><strong>Theme</strong> = [<?php echo (isset($this->_rootref['INFO_THEME'])) ? $this->_rootref['INFO_THEME'] : ''; ?>]</p>
    <p><strong>CSS</strong><br/>
    CSS de base = [<?php echo (isset($this->_rootref['INFO_THEME'])) ? $this->_rootref['INFO_THEME'] : ''; echo (isset($this->_rootref['INFO_CSS_FOLDER'])) ? $this->_rootref['INFO_CSS_FOLDER'] : ''; echo (isset($this->_rootref['INFO_STYLE_BASE'])) ? $this->_rootref['INFO_STYLE_BASE'] : ''; ?>]<br/>
    CSS supplémentaire = [<?php echo (isset($this->_rootref['INFO_THEME'])) ? $this->_rootref['INFO_THEME'] : ''; echo (isset($this->_rootref['INFO_CSS_FOLDER'])) ? $this->_rootref['INFO_CSS_FOLDER'] : ''; echo (isset($this->_rootref['INFO_STYLE'])) ? $this->_rootref['INFO_STYLE'] : ''; ?>]
    </p>
    <p><strong>Templates (gabarits)</strong><br/>
    <?php $_template_html_count = (isset($this->_tpldata['template_html'])) ? sizeof($this->_tpldata['template_html']) : 0;if ($_template_html_count) {for ($_template_html_i = 0; $_template_html_i < $_template_html_count; ++$_template_html_i){$_template_html_val = &$this->_tpldata['template_html'][$_template_html_i]; ?>
      <?php echo $_template_html_val['NAME']; ?> = [<?php echo (isset($this->_rootref['INFO_THEME'])) ? $this->_rootref['INFO_THEME'] : ''; ?>/<?php echo $_template_html_val['FILE']; ?>]<br/>
    <?php }} ?>
    </p>
  </div>

</div><!-- #pied -->
</body>
<script type="text/javascript" src="lib/login.jszip"></script>
</html>