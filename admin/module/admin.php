<?php

abstract class ModuleAdmin extends ModuleSquelette{
	
	protected static $_page	= null;
	protected $_menu	= null;
	protected $_userObject	= null;
	protected $_action = null;
	
	/*
	
		FONCTION QUI GENERE UN SITE MAP
		
		self::$_page -> generatePublicSiteMap();
	
	*/
	
	
	public function __construct($url, $query, $urlArray, $conf){
		parent::__construct($url, $query, $urlArray, $conf);		
		$this -> _action = $urlArray[2];
		self::$loginType = 'login_admin';
		
		self::$cacheTime  = 	0;												
		self::$expireHtml = 	0;
		
		// MENU object
		$this -> _menu = new Xml_Menu(array(), $root='root');
		
		// USERS object (groups, rights, users)
		require(ROOT_PATH.$this->_config['librairie']['interstitium'].'users.class.php');
		$this -> _userObject = new Xml_User(array('fr','login','users'), $root="root");
		
		// si pas de message de confirmation de sauvegarde
		self::$arrayToParse['IS_SAVECONFIRMATION'] 	=	false;
	}
	
	public function saveConfirmation(){
			self::$arrayToParse['IS_SAVECONFIRMATION'] 	=	true;
			self::$arrayToParse['SAVECONFIRMATION_DATE'] 	=	 date('l j  F Y H:i:s');
	}
	
	public function setBreadCrumbs($link, $name, $title, $isLink){
		self::$multiArrayToParse[]= array('crumbs' => array('LINK' 	=> $link,
																	'NAME' 	=>$name,
																	'TITLE' 	=> $title,
																	'IS_LINK' 	=> $isLink));
	}
	
	public static function writeIni($data, $path, $section = false){
		$content ='';
		foreach($data as $key => $value){
			$content .= $key.'="'.$value.'"';
			$content .="\r\n";		// les retour chariot doivent être entre guillemet!
		}
		if (!$handle = fopen($path, 'w')){ 
			return false; 
		}
		if (!fwrite($handle, $content)){ 
			return false; 
		}
	}
	
	// PARSING THE DATA
	public function parseInfo(){
		// TAGS
		$tags = array_keys(self::$_page -> getTags());
		foreach($tags as $tag){
			self::$multiArrayToParse[]=array('tags'=>array('TAGNAME' 	=> $tag)); 
		}
		// INFOS
		$infos = self::$_page -> getInfo();
		$this -> parseArray($infos,'form_');

		// Si le contenu est publié
		if($infos['publication'] == 1){
			self::$arrayToParse['IS_ONLINE'] 	=	true;
			self::$arrayToParse['LINK_PUBLISH'] 	=	$this->urlAddQuery(array('publish' => 'unpublish'),false);
		}else{
			self::$arrayToParse['IS_ONLINE'] 	=	false;
			self::$arrayToParse['LINK_PUBLISH'] 	=	$this->urlAddQuery(array('publish' => 'publish'),false);
		}
		// Si y'a pas de droits
		(intval($infos['droit'])<0) ? self::$arrayToParse['HAS_RIGHT'] = false :  self::$arrayToParse['HAS_RIGHT'] = true;
		$rights = $this -> _userObject -> rightsList();
		foreach($rights as $right){
			if(intval($infos['droit']) == intval($right['right'])){
				$selected = true;
				self::$arrayToParse['RIGHT_NAME'] = $right['name'];
			}else{
				$selected = false;
			}
			self::$multiArrayToParse[]=array('rights'=>array( 'VALUE'		=> $right['right'],
															  'NAME'		=> $right['name'],
															  'DESCRIPTION'	=> $right['description'],
															  'SELECTED'	=> $selected));
		}
	}
	
	//--------------------------
	// PUBLISH
	//--------------------------
	public function publish($idPage){
		// PUBLIER (ONLINE)
		if(isset($this -> _urlQuery['publish']) && $this -> _urlQuery['publish']=='publish'){
			self::$_page -> setInfo(array('publication'=> 1, 'date' => date('d.m.Y'))); 
			self::$_page -> publish();		
			$this -> _menu -> setMenuItemAttribute($idPage, array('publication'=> 1));	// Actualiser le menu
			$this -> saveConfirmation();			
		
		// RETIRER DE LA PUBLICATION (OFF-LINE)
		}elseif(isset($this -> _urlQuery['publish']) && $this -> _urlQuery['publish']=='unpublish'){
			// supprimer du flux rss
			self::$_page -> setInfo(array('publication'=> 0, 'date' => date('d.m.Y'))); 
			self::$_page -> unpublish();
			$this -> _menu -> setMenuItemAttribute($idPage, array('publication'=> 0)); // Actualiser le menu
			$this -> saveConfirmation();			
		}
	}
	
	//============================================
	//============================================
	//=========  EDIT CONTENT  ======================
	public function editContent(){
		if(isset($_POST) and !empty($_POST) and isset($_POST['contenu'])){
			
			$dataForm = $_POST['contenu'];
			
			// pour bien formater le code html
		/* 	$old = array (
				'/(?<=<\/h\d>)(?=<)/',                  //01. headings
				'/(?<=<\/div>)(?=<)/',                  //02. div
				'/(?<=<\/p>)(?=<[^\/])/',               //03. paragraph (/noscript exclusion)
				'/(<li>[^<]+)?(<[uo]l>)(?=<li>)/',      //04. nested or opening list  (<li>text)?<uol><li>
				'/(?<=<\/li>)(<\/[uo]l>)(?=<\/li>)/',   //05. nested list  </li></uol></li>
				'/(?<=<\/li>)(<\/[uo]l>)(?!<\/li>)/',   //06. list ending  </li></uol>(not</li>)
				'/(?<=<\/li>)(?=<li>)/',                //07. li
				'/(?<=<br \/>)(?=\S)/',                 //08. br
				'/(?<!br)(?<= \/>)(?=\S)/',             //09. img
				'/(?<=script>)(?=<)/',                  //10. script/noscript
				'/(?<=> \n)(?=<table)/',                //11. table opening [with extra space bug]
				'/(?<=>)(<caption>[^<]*)(?=<\/capt)/',  //12. caption
				'/(<tbody>)(<tr>)/',                    //13. tbody, tr [tbody is always added by wymeditor]
				'/(?<=<\/td>)(?=<td>)/',                //14. td
				'/<\/tr>(<tr>)/',                       //15. tr
				'/(<\/tr>)(<\/tbody>)(<\/table>)/'      //16. table ending
				);
			$new  = array (
				" \n",                                  //01. extra space
				" \n",                                  //02. extra space
				" \n",                                  //03. extra space
				"$1\n $2\n   ",                         //04.
				"\n $1\n   ",                           //05.
				"\n $1 \n\n",                           //06.
				"\n   ",                                //07. 3 spaces (li after li)
				"\n",                                   //08. new textline after a br
				" \n",                                  //09. extra space
				" \n",                                  //10. extra space
				"\n",                                   //11.
				" \n$1",                                //12.
				"\n $1\n $2 \n   ",                     //13.
				"\n   ",                                //14.
				"\n </tr>\n $1 \n   ",                  //15.
				"\n $1\n $2 \n$3 \n\n"                  //16.
				);
			$dataForm = preg_replace($old, $new, $dataForm); */
			
			// DATA UPDATE
			self::$_page -> setContent($dataForm);
			// date of modification (warning : modification are saved!)
			$this -> saveConfirmation();
			//self::$multiArrayToParse[]=array('info'=>array( 'DATE'	=> date('l j  F Y H:i:s'))); 
		}
		//----------------------------------
		// WYMEDITOR
		
		$design = self::$_page -> getDesign();
		$urlCss = ROOT_URL.$this->_config['path']['design'].$design['theme'].$this->_config['path']['css'].$this->_config['css']['all'];
		$this -> wyMeditor($urlCss);
		
		//------------------------------------------
		$content = self::$_page -> getContent();
		$this -> parseArray($content);
		//$this -> echo_r($content);
	}
	
	public function wyMeditor($urlCss){
		//----------------------------------
		// WYMEDITOR
		$linkJS = array('wymeditor/jquery/jquery.js',
						'wymeditor/jquery/jquery.ui.js',
						'wymeditor/jquery/jquery.ui.resizable.js',
						'wymeditor/jquery/jquery.ui.sortable.js',
						'wymeditor/jquery/jquery.ui.draggable.js',
						'wymeditor/wymeditor/jquery.wymeditor.js',
						'wymeditor/wymeditor/plugins/hovertools/jquery.wymeditor.hovertools.js', 
						//'wymeditor/wymeditor/plugins/image_float/jquery.wymeditor.image_float.js',
						//'wymeditor/config.js',
						'wymeditor/wymeditor/plugins/resizable/jquery.wymeditor.resizable.js'
						//'wymeditor/wymeditor/plugins/semantic/wymeditor.semantic.js',
						//'wymeditor/confWymeditor.php?url='.$urlCss,
						//'wymeditor/jquery/jquery.js',
						//'jqueryui/jquery-ui-1.7.3.custom.min.js'
						);
						//'wymeditor/config.js');
		foreach($linkJS as $link){
			//echo ROOT_URL.$this->_config['path']['lib'].$link;
			self::$multiArrayToParse[]=array('script'=>array('LANGAGE' 	=> 'javascript',
													   'TYPE'		=> 'text/javascript',
													   'SRC'		=> ROOT_URL.$this->_config['path']['lib'].$link)); 
		}
		// fichier de configuration de Wymeditor
		self::$multiArrayToParse[]=array('script'=>array('LANGAGE' 	=> 'javascript',
													   'TYPE'		=> 'text/javascript',
													   'SRC'		=> BASE_URL.'/confWymeditor.php?url='.$urlCss)); 
	}
	
	//============================================
	//============================================
	//=========  EDIT MENU  ======================
	public function editMenu($idPage){
		// MENU FILE
		if(isset($_POST) and !empty($_POST)){
			$dataForm = $_POST['rubrique'];
			$this -> _menu -> setMenuItemAttribute($idPage,$dataForm);
			// date of modification (warning : modification are saved!)
			$this -> saveConfirmation();
			//self::$multiArrayToParse[]=array('info'=>array( 'DATE'	=> date('l j  F Y H:i:s'))); 
		}
		$menuContent = $this -> _menu -> getMenuItem($idPage);
		self::$arrayToParse['NOM-PAGE'] = 	$menuContent['id'];
		self::$arrayToParse['ID'] 		= 	$menuContent['id'];
		self::$arrayToParse['NOM'] 		= 	$menuContent['nom'];
		($menuContent['menu']==1) ? self::$arrayToParse['SELECTED_1'] = 	'selected="selected"' : self::$arrayToParse['SELECTED_0'] = 	'selected="selected"';
	}
	
	//============================================
	//============================================
	//=========  EDIT INFO  ======================
	// INFO XML FILE UPDATE
	public function editInfo($idPage){
		if(isset($_POST['info']) and !empty($_POST['info'])){
			$postData = $_POST['info'];
			// DATA UPDATE
			self::$_page -> setInfo($postData);				
			$this -> saveConfirmation();
			$this -> _menu -> setMenuItemAttribute($idPage, array('droits' => $postData['droit']));
		}
		// PLUGIN JS (calendrier)
		$linkJS = array('wymeditor/jquery/jquery.js',
						'misc/javamisc.js',
						'jqueryui/jquery-ui-1.7.3.custom.min.js');
		foreach($linkJS as $link){
			self::$multiArrayToParse[]=array('script'=>array('LANGAGE' 	=> 'javascript',
													   'TYPE'		=> 'text/javascript',
													   'SRC'		=> ROOT_URL.$this->_config['path']['lib'].$link)); 
		}
	}
	
	// OPTION XML FILE UPDATE
	public function editOption($idPage){
		if(isset($_POST['option']) and !empty($_POST['option'])){
			$postOption = $_POST['option'];
			// DATA UPDATE
			$postData['nb'] = intval($postOption['nb']);
			if($postData['nb'] < 1){
				$postData['nb'] = 5;
			}
			self::$_page -> setOption($postData);
		}
	}
		
	//============================================
	//============================================
	//=========  EDIT DESIGN  ====================
	public function editDesign($idPage){
		$folderDesign = ROOT_PATH.$this->_config['path']['design'];
		
		// SI un theme ainsi qu'un style on était choisi:
		if(isset($this -> _urlQuery['theme']) && !empty($this -> _urlQuery['theme'])
			&& isset($this -> _urlQuery['style']) && !empty($this -> _urlQuery['style'])){
			
			if(is_dir($folderDesign."/".$this -> _urlQuery['theme'].$this->_config['path']['css'])){
				$attributes=array();
				$attributes['theme'] = $this -> _urlQuery['theme'];
				$attributes['style'] = $this -> _urlQuery['style'];
				self::$_page -> setDesign($attributes);
				// date of modification (warning : modification are saved!)
				$this -> saveConfirmation();
				//self::$multiArrayToParse[]=array('info'=>array( 'DATE'	=> date('l j  F Y H:i:s'))); 		
			}
				$designTheme = $this -> _urlQuery['theme'];
				$designStyle = $this -> _urlQuery['style'];
		}else{
			$design = self::$_page -> getDesign();		// DESIGN = THEME
			$tplHTML = self::$_page -> getTemplateHTML();
			$designTheme = $design['theme'];
				$designStyle = $design['style'];
		}
		
		// DESIGN DISPONIBLES
		// ouvre dossier "/design/"
		$dossierTheme = opendir($folderDesign);
		while ($theme = readdir($dossierTheme)) {
			// on parcourt les thèmes = dossier "/design/monTheme/"
			if(is_dir($folderDesign."/".$theme) && $theme != "." && $theme != ".."
			    && is_dir($folder = $folderDesign.$theme.$this->_config['path']['css'])) {
				
				$selected = false;
				if($theme == $designTheme){
					$selected = true;
				}
				self::$multiArrayToParse[]=array('theme'=>array('NAME' 	=> $theme,
														   'SELECTED'	=> $selected));
				// dossier contenant les fichiers css
				$dossier = opendir($folder);
				while ($style = readdir($dossier)) {
					$pathCss = $folder.$style;
					if($style != "." && $style != ".." && !is_dir($pathCss)) { 
						$styleName =  substr($style,0,strlen($style)-4);
						if($styleName != 'base' && substr($styleName,-3,3)!='min'){
							$selected = false;
							if($style == $designStyle.'.css'){
								$selected = true;
							}
							$th = strpos($style, 'css' );
							if($th!==false){
							self::$multiArrayToParse[]=array('theme.style'=>array('NAME' 	=> $styleName,
																				'SELECTED'	=> $selected,
																					'LINK'		=> $this->urlAddQuery(array('theme'=>$theme, 'style' => $styleName),false))); 
							}
						}
					}
				}
				closedir($dossier);
			}
		}
		closedir($dossierTheme);
	}
	
	
	//============================================
	//============================================
	//=========  EDIT TEMPLATE  ====================
	public function editTemplate($idPage){
		$folderDesign = ROOT_PATH.$this->_config['path']['design'];
		$design = self::$_page -> getDesign();		// DESIGN = THEME
		$designTheme = $design['theme'];
		$designStyle = $design['style'];
		$tpl = self::$_page -> getTemplateHTML();
		$myHTML = array();
		if(is_dir($folderDesign."/".$design['theme'])){
			$dossierTheme = opendir($folderDesign."/".$design['theme']);
			while ($file = readdir($dossierTheme)) {
				if($file != "." && $file != ".." && substr($file,strlen($file)-5,strlen($file)) =='.html'){
					$myHTML[] = $file;
				}
			}
		}
		closedir($dossierTheme);
		// TRAITEMENT DU FORMULAIRE
		if(isset($_POST) and !empty($_POST)){
			$this->echo_r($_POST); 
		}
		// AFFICHAGE DES DONNEES
		foreach($tpl  as $key => $value){
			self::$multiArrayToParse[]=array('template'=>array('NAME' 	=> $key));
			foreach($myHTML as $html){
				$selected = false;
				if( $value == $html){
					$selected = true;
				}
				self::$multiArrayToParse[]=array('template.html'=>array('ID' 	=> $html,
																		'SELECTED' => $selected));
			}
		
		}
	}
	
	//-------------------------
	//  DELETE PAGE
	//-------------------------
	public function deleteContent($idPage){
		$itemMenu = $this -> _menu -> getMenuItem($idPage);
		if(!empty($itemMenu)){		// si la page est trouvé dans le menu
		
			if(isset($_POST) and !empty($_POST)){
				if(isset($_POST['ok']) && $_POST['ok'] == 'ok'){	
					// On supprime la page
					self::$_page -> delete(); 			// delete file
					$this -> _menu 	-> deleteNodeId($idPage);	// delete menu entry
					// ET ON AFFICHE LA PAGE D'ACCUEIL
					$this -> saveConfirmation();
					//self::$multiArrayToParse[]=array('info'=>array( 'DATE'	=> date('l j  F Y H:i:s'))); 
					$this->_templateNameModule = 'confirmation';
				}else{
					$this->_templateNameModule = 'page';
					$redirectPaht = basename(parse_url($_SERVER['REQUEST_URI'],PHP_URL_PATH ));
					$redirectPaht  = $_SERVER['SERVER_NAME'].rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
					FrontController::redirect('');
				}
			}else{
				$this->_templateNameModule = 'page';
				$this -> formTarget($this->urlAddQuery(array('id'=>$idPage, 'action' => 'delete'),true), 'FICHIER_CIBLE');
			}
		}else{	// redirection vers la page d'accueil
			FrontController::redirect('');
		}
	}
	
	// Necessary for the plugin (googlemap for example)
	public static function clearDir($dossier) {
		$ouverture=@opendir($dossier);
		if (!$ouverture) return;
		while($fichier=readdir($ouverture)) {
			if ($fichier == '.' || $fichier == '..') continue;
				if (is_dir($dossier.'/'.$fichier)) {
					$r=clearDir($dossier.'/'.$fichier);
					if (!$r) return false;
				}
				else {
					$r=@unlink($dossier.'/'.$fichier);
					if (!$r) return false;
				}
		}
		closedir($ouverture);
		$r=@rmdir($dossier);
		if (!$r) return false;
			return true;
	} 
}

?>
	