<?php

abstract class ModuleAdmin extends ModuleSquelette{
	
	protected static $_page	= null;

	// TO DELETE
	//protected $_tags	= null;
	
	
	protected $_menu	= null;
	protected $_groups	= null;
	protected $_action = null;
	
	
	
	public function __construct($url, $query, $urlArray, $conf){
		parent::__construct($url, $query, $urlArray, $conf);		
		
		$this -> _action = $urlArray[2];
		
		self::$loginType = 'login_admin';
	
		// MENU object
		$this -> _menu = new Xml_Menu(array(), $root='root');
		
		// GROUP object
		require(ROOT_PATH.$this->_config['librairie']['interstitium'].'groups.class.php');
		$this -> _groups = new Xml_Group();
	
	}
	
		public function setBreadCrumbs($link, $name, $title, $isLink){
		self::$multiArrayToParse[]= array('crumbs' => array('LINK' 	=> $link,
																	'NAME' 	=>$name,
																	'TITLE' 	=> $title,
																	'IS_LINK' 	=> $isLink));
	}
	
	
	
		public function writeIni($data, $path, $section = false){
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
	
	//--------------------------
	// FLUX DE SYNDICATION
	//--------------------------
	
	public function publish($id, $infos){
		// PUBLIER (ONLINE)
		if(isset($this -> _urlQuery['publish']) && $this -> _urlQuery['publish']=='publish'){
			// Si pas de droits => ajouter au flux rss
			if(($infos['droit']<0 && $infos['publication']!=1)) {
				// $infos['titre']='Page : '.$infos['titre'];
				$this -> addTofluxSyndication(self::$arrayToParse['FORM_ID'],$infos);		 // Flux ATOM				
			}
			self::$arrayToParse['IS_ONLINE'] 	=	true;
			self::$arrayToParse['LINK_PUBLISH'] 	=	$this->urlAddQuery(array('publish' => 'unpublish'),false);
			// Actualiser la date de création du fichier (aujourd'hui)
			self::$_page -> setInfo(array('publication'=> 1, 'date' => date('d.m.Y')));
			$this ->  updateMenu($id, array('publication'=> 1));			// Actualiser le menu
		
		// RETIRER DE LA PUBLICATIO (OFF-LINE)
		}elseif(isset($this -> _urlQuery['publish']) && $this -> _urlQuery['publish']=='unpublish'){
			// supprimer du flux rss
			$this -> removeTofluxSyndication(self::$arrayToParse['FORM_ID']);		 // Flux ATOM				
			self::$arrayToParse['IS_ONLINE'] 	=	false;
			self::$arrayToParse['LINK_PUBLISH'] 	=	$this->urlAddQuery(array('publish' => 'publish'),false);
			// actualiser le fichier _id.xml ainsi que 00-index.xml
			self::$_page -> setInfo(array('publication'=> 0, 'date' => date('d.m.Y')));
			$this ->  updateMenu($id, array('publication'=> 0));			// Actualiser le menu
		}
	
	}
	
	public function removeTofluxSyndication($id){
		$pathFlux = ROOT_PATH.'/flux.xml';				
		require(ROOT_PATH.$this->_config['librairie']['interstitium'].'atom.class.php');
		$flux = new Atom($pathFlux);
		$flux -> deleteEntry($id);
		
		// date of modification (warning : modification are saved!)
		self::$multiArrayToParse[]=array('info'=>array( 'DATE'	=> date('l j  F Y H:i:s'))); 
	}
	public function addTofluxSyndication($id,$infos){
		$pathFlux = ROOT_PATH.'/flux.xml';				
		require(ROOT_PATH.$this->_config['librairie']['interstitium'].'atom.class.php');
		$flux = new Atom($pathFlux);
		$title= htmlentities($infos['titre'], ENT_QUOTES, "UTF-8");
		$link = ROOT_URL.'/'.$id.'.html';
		$summary = htmlentities($infos['description'], ENT_QUOTES, "UTF-8");
		$flux -> addEntry($id, $title, $link, $summary);

		self::$multiArrayToParse[]=array('info'=>array( 'DATE'	=> date('l j  F Y H:i:s'))); 
	}
	
	
	public function wyMeditor($urlCss){
		//----------------------------------
		// WYMEDITOR
		$linkJS = array('wymeditor/jquery/jquery.js',
						'wymeditor/wymeditor/jquery.wymeditor.js',
						'wymeditor/wymeditor/plugins/hovertools/jquery.wymeditor.hovertools.js', 
						'wymeditor/wymeditor/plugins/resizable/jquery.wymeditor.resizable.js',
						//'wymeditor/wymeditor/plugins/semantic/wymeditor.semantic.js',
						//'wymeditor/config.js',
						//'wymeditor/confWymeditor.php?url='.$urlCss,
						'jqueryui/jquery-ui-1.7.3.custom.min.js');
						//'wymeditor/config.js');
		foreach($linkJS as $link){
			self::$multiArrayToParse[]=array('script'=>array('LANGAGE' 	=> 'javascript',
													   'TYPE'		=> 'text/javascript',
													   'SRC'		=> ROOT_URL.$this->_config['path']['lib'].$link)); 
		}
		
		self::$multiArrayToParse[]=array('script'=>array('LANGAGE' 	=> 'javascript',
													   'TYPE'		=> 'text/javascript',
													   'SRC'		=> BASE_URL.'/confWymeditor.php?url='.$urlCss)); 
		//$design = self::$_page -> getDesign();
		
		//$urlCss = BASE_URL.$this->_config['path']['design'].$design['theme'].'/'.$design['style'].'/'.$this->_config['css']['all'];
		/* $path = ROOT_PATH.$this->_config['path']['lib'].'wymeditor/config.js';
		$content = file_get_contents($path);
		$content = preg_replace( '#{CssPath}#', $urlCss, $content ); */
	//	self::$arrayToParse['JAVA_SCRIPT'] = 	$content;
		/*
		$handle = fopen($path,"w+"); 
		if($handle){		// If successful
			$content = preg_replace( '#{CssPath}#', $urlCss, $content );
			//fwrite($handle,$content);
			fclose($handle);
		} */
	}
	
	
	
	
	//============================================
	//============================================
	//=========  EDIT CONTENT  ======================
	public function editContent(){
		if(isset($_POST) and !empty($_POST)){
			$dataForm = $_POST['contenu'];
			//$content = $_POST['content'];
			
			// pour bien formater le code html
			$old = array (
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
			$dataForm = preg_replace($old, $new, $dataForm);
			
			// DATA UPDATE
			self::$_page -> setContent($dataForm);
			// date of modification (warning : modification are saved!)
			self::$multiArrayToParse[]=array('info'=>array( 'DATE'	=> date('l j  F Y H:i:s'))); 
		}
		//----------------------------------
		// WYMEDITOR
		
		$design = self::$_page -> getDesign();
		$urlCss = BASE_URL.$this->_config['path']['design'].$design['theme'].'/'.$design['style'].'/'.$this->_config['css']['all'];
		$this -> wyMeditor($urlCss);
		
		//------------------------------------------
		$content = self::$_page -> getContent();
		$this -> parseArray($content);
		
		/* $infos = self::$_page -> getInfo();
		$this -> parseArray($infos,'form_'); */
	}
	
	
	
	//============================================
	//============================================
	//=========  EDIT MENU  ======================
	public function editMenu($id){
		// MENU FILE
		if(isset($_POST) and !empty($_POST)){
			$dataForm = $_POST['rubrique'];
			$this -> _menu -> setMenuItemAttribute($id,$dataForm);
			// date of modification (warning : modification are saved!)
			self::$multiArrayToParse[]=array('info'=>array( 'DATE'	=> date('l j  F Y H:i:s'))); 
		}
		$menuContent = $this -> _menu -> getMenuItem($id);
		self::$arrayToParse['NOM-PAGE'] = 	$menuContent['id'];
		self::$arrayToParse['ID'] 		= 	$menuContent['id'];
		self::$arrayToParse['NOM'] 		= 	$menuContent['nom'];
		($menuContent['menu']==1) ? self::$arrayToParse['SELECTED_1'] = 	'selected="selected"' : self::$arrayToParse['SELECTED_0'] = 	'selected="selected"';
		
	}
	
	//============================================
	//============================================
	//=========  EDIT INFO  ======================
	// INFO XML FILE UPDATE
		public function editInfoXml($id, $postData, $oldData){
			// DATA UPDATE
			self::$_page -> setInfo($postData);
			
			// LISTER = site map
			$pathSitemap = BASE_PATH.'/sitemap.xml';		// in "admin" folder			
			require(ROOT_PATH.$this->_config['librairie']['interstitium'].'lister.class.php');
			$lister = new Lister($pathSitemap);
			$lister -> addEntry($id, $postData['titre'], 'www', $postData['description'], $postData['droit'], $oldData['publication']);
			// date of modification (warning : modification are saved!)
			self::$multiArrayToParse[]=array('info'=>array( 'DATE'	=> date('l j  F Y H:i:s'))); 
		}
		// OPTION XML FILE UPDATE
		public function editOptionXml($id, $postData){
			// DATA UPDATE
			$postData['nb'] = intval($postData['nb']);
			if($postData['nb'] < 1){
				$postData['nb'] = 5;
			}
			self::$_page -> setOption($postData);
			// date of modification (warning : modification are saved!)
			//self::$multiArrayToParse[]=array('info'=>array( 'DATE'	=> date('l j  F Y H:i:s'))); 
		}
		
		
		// MENU UPDATE
		public function updateMenu($id, $data){
			$this -> _menu -> setMenuItemAttribute($id,$data);
		}
		// $data = array('droit' => $postData['droit'],
		//				'publication' => $postData['publication']);
		
		

		
		// PARSING THE DATA
		public function parseInfo(){
			// PLUGIN JS
			$linkJS = array('wymeditor/jquery/jquery.js',
							'misc/javamisc.js',
							'jqueryui/jquery-ui-1.7.3.custom.min.js');
			foreach($linkJS as $link){
				self::$multiArrayToParse[]=array('script'=>array('LANGAGE' 	=> 'javascript',
														   'TYPE'		=> 'text/javascript',
														   'SRC'		=> ROOT_URL.$this->_config['path']['lib'].$link)); 
			}
			// TAGS
			$tags = array_keys(self::$_page -> getTags());
			foreach($tags as $tag){
				self::$multiArrayToParse[]=array('tags'=>array('TAGNAME' 	=> $tag)); 
			}
			$infos = self::$_page -> getInfo();
			$prefix = 'form_';
			foreach($infos as $key => $info){
				if($key == 'droit'){
					(intval($info)<0) ? self::$arrayToParse['HAS_RIGHT'] = false :  self::$arrayToParse['HAS_RIGHT'] = true;
					$rights = $this -> _groups -> rightsList();
					foreach($rights as $right){
						if(intval($info) == intval($right['right'])){
							$selected = true;
							self::$arrayToParse['RIGHTNAME'] = $right['name'];
						}else{
							$selected = false;
						}
						self::$multiArrayToParse[]=array('rights'=>array( 'VALUE'		=> $right['right'],
																		  'NAME'		=> $right['name'],
																		  'DESCRIPTION'	=> $right['description'],
																		  'SELECTED'	=> $selected)); 
					}
				}elseif($key == 'publication'){
					($info==0) ? self::$arrayToParse['IS_PUBLICATED'] = false :  self::$arrayToParse['IS_PUBLICATED'] = true;
				}elseif($key == 'commentaire'){
					($info==0) ? self::$arrayToParse['HAS_COMMENT'] = false :  self::$arrayToParse['HAS_COMMENT'] = true;
				}else{
					self::$arrayToParse[strtoupper($prefix.$key)] = $info;
				}
			}
		}
		
		
	
	
	//============================================
	//============================================
	//=========  EDIT DESIGN  ====================
	public function editDesign($id){
		$folderDesign = ROOT_PATH.$this->_config['path']['design'];
		
		// SI un theme ainsi qu'un style on était choisi:
		if(isset($this -> _urlQuery['theme']) && !empty($this -> _urlQuery['theme'])
			&& isset($this -> _urlQuery['style']) && !empty($this -> _urlQuery['style'])){
			
			if(is_dir($folderDesign."/".$this -> _urlQuery['theme'].'/'.$this -> _urlQuery['style'].'/')){
				$attributes=array();
				$attributes['nom'] = $this -> _urlQuery['theme'];
				$attributes['style'] = $this -> _urlQuery['style'];
				self::$_page -> setDesign($attributes);
				// date of modification (warning : modification are saved!)
				self::$multiArrayToParse[]=array('info'=>array( 'DATE'	=> date('l j  F Y H:i:s'))); 		
			}
			
				$designTheme = $this -> _urlQuery['theme'];
				$designStyle = $this -> _urlQuery['style'];
		}else{
			$design = self::$_page -> getDesign();		// DESIGN = THEME
			$designTheme = $design['theme'];
				$designStyle = $design['style'];
		}
		
		
		
		
		
		// Data XML
		$idArray = explode(',',$id);
		$module = $idArray[1];						// MODULE
		//$templates = self::$_page -> getTemplates();	// STYLE
		
		// DESIGN DISPONIBLES
		$dossierTheme = opendir($folderDesign);
	
		while (false !== ($theme = readdir($dossierTheme))) {
			// on parcourt les dossier seulement!
			if(is_dir($folderDesign."/".$theme) && $theme != "." && $theme != "..") {
				//$nomtheme = $folder."/".$theme;
				$selected = false;
				if($theme == $designTheme){
					$selected = true;
				}
				self::$multiArrayToParse[]=array('theme'=>array('NAME' 	=> $theme,
														   'SELECTED'	=> $selected));
				$dossier = opendir($folder = $folderDesign.$theme.'/');
				$templateHtml = array();
				while (false !== ($style = readdir($dossier))) {
					// STYLE - Dossier CSS
					if(is_dir($folder."/".$style) && $style != "." && $style != "..") {
						$selected = false;
						if($style == $designStyle){
							$selected = true;
						}
						$th = strpos($style, 'css' );
						if($th!==false){
							self::$multiArrayToParse[]=array('theme.style'=>array('NAME' 	=> $style,
																				'SELECTED'	=> $selected,
																				'LINK'		=> $this->urlAddQuery(array('theme'=>$theme, 'style' => $style),false))); 
						}
					}
				}
				closedir($dossier);
			}
		}
		closedir($dossierTheme);
		
		
		
	}
	
	
	
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
	