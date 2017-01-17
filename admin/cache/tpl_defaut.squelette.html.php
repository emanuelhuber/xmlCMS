<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<!-- META-DONNEES  -->
	<title><?php echo (isset($this->_rootref['INFO_TITRE'])) ? $this->_rootref['INFO_TITRE'] : ''; ?></title>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="S. Huber" lang="de" content="Carl Friedrich Gauss"/>
	<meta name="description" content="<?php echo (isset($this->_rootref['INFO_DESCRIPTION'])) ? $this->_rootref['INFO_DESCRIPTION'] : ''; ?>"/>
	<meta name="keywords" content="<?php echo (isset($this->_rootref['INFO_MOTSCLEFS'])) ? $this->_rootref['INFO_MOTSCLEFS'] : ''; ?>"/>
	<meta name="robots" content="index,follow" />

	<!-- Pour inclure un FAVICON -->
	<link rel="shortcut icon" href="favicon.icoc" type="image/x-icon" />

	<?php $_css_count = (isset($this->_tpldata['css'])) ? sizeof($this->_tpldata['css']) : 0;if ($_css_count) {for ($_css_i = 0; $_css_i < $_css_count; ++$_css_i){$_css_val = &$this->_tpldata['css'][$_css_i]; ?>
	<link rel="stylesheet"  media="<?php echo $_css_val['MEDIA']; ?>" type="text/css" href="<?php echo $_css_val['REF']; ?>"/>
	<?php }} ?>
	<!-- <link rel="stylesheet" href="http://jquery.bassistance.de/treeview/demo/screen.css" type="text/css" /> -->
	<link rel="stylesheet" href="design/defaut/css/jquery_tree_view.css" type="text/css" />

	<!-- <script type="text/javascript" src="http://jquery.bassistance.de/treeview/jquery.treeview.js"></script> -->
	<script src="http://code.jquery.com/jquery-latest.js"></script>
	<script type="text/javascript" src="design/defaut/js/jquery.treeview.js"></script>
	<script type="text/javascript">
	<!--	
		$(document).ready(function(){
		$("#tree").treeview();
		});
		<?php echo (isset($this->_rootref['JAVA_SCRIPT'])) ? $this->_rootref['JAVA_SCRIPT'] : ''; ?>
	-->
	</script>
	<?php $_script_count = (isset($this->_tpldata['script'])) ? sizeof($this->_tpldata['script']) : 0;if ($_script_count) {for ($_script_i = 0; $_script_i < $_script_count; ++$_script_i){$_script_val = &$this->_tpldata['script'][$_script_i]; ?>
	<script language="<?php echo $_script_val['LANGAGE']; ?>" type="<?php echo $_script_val['TYPE']; ?>" src="<?php echo $_script_val['SRC']; ?>"></script>
	<?php }} ?>
</head>


<body>

<!-- La petite flèche pour retourner en haut de la page qui se déplace avec le défilement de la page... -->
	<div id="pagetop"><span><a href="#debut"><img alt="top" src="design/defaut/images/top.gifc"/></a>
		</span>
	</div>
	
<!-- Lien vers lequel la flèche mobile pointe. Il s'agit d'un lien intern à la page. -->
	<a name="debut"></a>

<div id="global">
	<div id="login">
		<?php if ($this->_rootref['CONNECTED']) {  ?>
			<?php echo ((isset($this->_rootref['L_WELCOME'])) ? $this->_rootref['L_WELCOME'] : ((isset($this->lang['WELCOME'])) ? $this->lang['WELCOME'] : '{ WELCOME }')); ?> <?php echo (isset($this->_rootref['USERNAME'])) ? $this->_rootref['USERNAME'] : ''; ?> |
			Groupe: <?php echo (isset($this->_rootref['GROUPNAME'])) ? $this->_rootref['GROUPNAME'] : ''; ?> |
			<a href="<?php echo (isset($this->_rootref['LOGOUT_CONNECTION'])) ? $this->_rootref['LOGOUT_CONNECTION'] : ''; ?>"><?php echo ((isset($this->_rootref['L_LOGOUT'])) ? $this->_rootref['L_LOGOUT'] : ((isset($this->lang['LOGOUT'])) ? $this->lang['LOGOUT'] : '{ LOGOUT }')); ?></a>
		<?php } else { ?>
			 <a href="<?php echo (isset($this->_rootref['LOGIN_CONNECTION'])) ? $this->_rootref['LOGIN_CONNECTION'] : ''; ?>"><?php echo ((isset($this->_rootref['L_LOGIN'])) ? $this->_rootref['L_LOGIN'] : ((isset($this->lang['LOGIN'])) ? $this->lang['LOGIN'] : '{ LOGIN }')); ?></a>
		<?php } ?>
	</div>
	
	<div id="entete">
		<!-- <img alt="" src="design/defaut/images/logo.pngc" /> -->
	</div><!-- #entete -->
	
	<div id="menuhorizontal">

	</div><!-- #menuhorizontal -->
	
	<div id="contenu">
		<div id="contenu-bis">
			<div id="menu">
				<div id="container_menu">
					<?php $_alert_count = (isset($this->_tpldata['alert'])) ? sizeof($this->_tpldata['alert']) : 0;if ($_alert_count) {for ($_alert_i = 0; $_alert_i < $_alert_count; ++$_alert_i){$_alert_val = &$this->_tpldata['alert'][$_alert_i]; ?>
					<div class="alert">
						<?php echo ((isset($this->_rootref['L_ALERTE'])) ? $this->_rootref['L_ALERTE'] : ((isset($this->lang['ALERTE'])) ? $this->lang['ALERTE'] : '{ ALERTE }')); ?> (<?php echo $_alert_val['JOUR']; ?> <?php echo $_alert_val['MOIS']; ?> <?php echo $_alert_val['ANNEE']; ?>).
					</div>
					<?php }} ?><!-- Le menu vertical avec ses sous-menu -->
					<ul>
					<?php $_menu1_count = (isset($this->_tpldata['menu1'])) ? sizeof($this->_tpldata['menu1']) : 0;if ($_menu1_count) {for ($_menu1_i = 0; $_menu1_i < $_menu1_count; ++$_menu1_i){$_menu1_val = &$this->_tpldata['menu1'][$_menu1_i]; ?>
						<li><a class="<?php echo $_menu1_val['CLASS']; ?>" href="<?php echo $_menu1_val['REF']; ?>"><?php echo $_menu1_val['NAME']; ?> </a>	
						<?php if ($_menu1_val['T_SMENU']) {  ?>
							<ul class="<?php echo $_menu1_val['SCLASS']; ?>">
						<?php $_menu2_count = (isset($_menu1_val['menu2'])) ? sizeof($_menu1_val['menu2']) : 0;if ($_menu2_count) {for ($_menu2_i = 0; $_menu2_i < $_menu2_count; ++$_menu2_i){$_menu2_val = &$_menu1_val['menu2'][$_menu2_i]; ?>
								<li><a class="<?php echo $_menu2_val['CLASS']; ?>" href="<?php echo $_menu2_val['REF']; ?>"><?php echo $_menu2_val['NAME']; ?></a></li>
						<?php }} ?>
							</ul>
						<?php } ?>
						</li>
					<?php }} ?>
					</ul>
					<img alt="Gauss" src="design/defaut/images/signature_very_small.pngc"/>
				 </div> <!-- container_menu -->
			</div><!-- #menu -->
			<div id="chemin2fer">
					<?php echo ((isset($this->_rootref['L_VOUS_ETES_ICI'])) ? $this->_rootref['L_VOUS_ETES_ICI'] : ((isset($this->lang['VOUS_ETES_ICI'])) ? $this->lang['VOUS_ETES_ICI'] : '{ VOUS_ETES_ICI }')); ?> 
					<?php $_crumbs_count = (isset($this->_tpldata['crumbs'])) ? sizeof($this->_tpldata['crumbs']) : 0;if ($_crumbs_count) {for ($_crumbs_i = 0; $_crumbs_i < $_crumbs_count; ++$_crumbs_i){$_crumbs_val = &$this->_tpldata['crumbs'][$_crumbs_i]; if ($_crumbs_val['IS_LINK']) {  ?>
							<a href="<?php echo $_crumbs_val['LINK']; ?>" title="<?php echo $_crumbs_val['TITLE']; ?>"><?php echo $_crumbs_val['NAME']; ?></a>
						<?php } else { ?>
							<?php echo $_crumbs_val['NAME']; ?>
						<?php } ?>
						<img src="design/defaut/images/fleche_droite_rouge.gifc" alt="fleche rouge"/>
					<?php }} ?>
						<?php echo (isset($this->_rootref['CURRENT_CRUMB'])) ? $this->_rootref['CURRENT_CRUMB'] : ''; ?>
					
			</div>
			<?php echo (isset($this->_rootref['PAGE'])) ? $this->_rootref['PAGE'] : ''; ?>
	
	
		
				
				
		</div><!-- #contenu-bis -->
	</div><!-- #contenu -->

	<div id="pied">
		<!-- Accueil | Plan du site | Mentions l&amp;eacute;gales | Partenariats | Contact -->

		<p id="copyright">
			&copy; Interstitium 2013
		</p>
		<p>Dernière modification : <?php echo (isset($this->_rootref['FILETIME'])) ? $this->_rootref['FILETIME'] : ''; ?></p>
		<p><a href="http://validator.w3.org/check/referer">XHTML</a> & <a href="http://jigsaw.w3.org/css-validator/check/referer">CSS</a></p>		
		<p>
		<!-- <p>Nom fichier internet : <?php echo (isset($this->_rootref['FILENAME_WEB'])) ? $this->_rootref['FILENAME_WEB'] : ''; ?></p> -->
		<?php if ($this->_rootref['T_COMP_GZIP']) {  ?>
			Compression GZIP activée
			<?php } else { ?>
			Pas de compression GZIP
			<?php } ?></p>
		<?php echo (isset($this->_rootref['ACTIVE_LANG'])) ? $this->_rootref['ACTIVE_LANG'] : ''; ?> (<?php echo (isset($this->_rootref['ACTIVE_LANG_ID'])) ? $this->_rootref['ACTIVE_LANG_ID'] : ''; ?>)<br/>
		Theme = [<?php echo (isset($this->_rootref['INFO_THEME'])) ? $this->_rootref['INFO_THEME'] : ''; ?>]<br/>
		Css de base = [<?php echo (isset($this->_rootref['INFO_THEME'])) ? $this->_rootref['INFO_THEME'] : ''; echo (isset($this->_rootref['INFO_CSS_FOLDER'])) ? $this->_rootref['INFO_CSS_FOLDER'] : ''; echo (isset($this->_rootref['INFO_STYLE_BASE'])) ? $this->_rootref['INFO_STYLE_BASE'] : ''; ?>], css supplémentaire = [<?php echo (isset($this->_rootref['INFO_THEME'])) ? $this->_rootref['INFO_THEME'] : ''; echo (isset($this->_rootref['INFO_CSS_FOLDER'])) ? $this->_rootref['INFO_CSS_FOLDER'] : ''; echo (isset($this->_rootref['INFO_STYLE'])) ? $this->_rootref['INFO_STYLE'] : ''; ?>]<br/>
		<?php $_template_html_count = (isset($this->_tpldata['template_html'])) ? sizeof($this->_tpldata['template_html']) : 0;if ($_template_html_count) {for ($_template_html_i = 0; $_template_html_i < $_template_html_count; ++$_template_html_i){$_template_html_val = &$this->_tpldata['template_html'][$_template_html_i]; ?>
			Nom : [<?php echo $_template_html_val['NAME']; ?>] ==> [<?php echo (isset($this->_rootref['INFO_THEME'])) ? $this->_rootref['INFO_THEME'] : ''; ?>/<?php echo $_template_html_val['FILE']; ?>]<br/>
		<?php }} ?>
	
		</p>

	</div><!-- #pied -->
</div><!-- #page -->
</body>


</html>