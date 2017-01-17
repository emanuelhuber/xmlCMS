<?php

class ModuleSquelette{
	
	protected $_idPage 				= '';		// p.ex. fr,page,chemie	=> ID dans le fichier arborescence.xml
	protected $_module 				= '';		// p.ex. page
	protected $_url 				= '';		// p.ex. fr,page,chemie ou bible,segond,1jean,3,16 (sans query)
	protected $_templateDesign			= '';		// desing en cours
	protected $_templateNameModule 		= '';		// le nom du template pour le module 
	protected $_templateNameSquelette 		= '';		// le nom du template pour le squelette 
	protected $_template			= false;		// l'instance de la classe template
	protected $_urlArray			= array();
	protected $_urlQuery			= array();
	protected $_config 				= array();		// données de conf du fichier conf.ini
	public static $arrayToParse		= array();		// donnée simple pour le template
	public static $multiArrayToParse 	= array();		// données de type bloc pour le template
	
	protected $_dateName				= array();		// nom des jours, mois dans la langue courante
	
	public $_content				= '';
	
	
	protected static $outputFormat = 'html';
	protected static $cacheTime	= 0; 		// pour l'expiration du cache HTML	//3456000;	// seconds, minutes, hours, days
	protected static $expireHtml = 0;		// pour l'expiration du cache navigateur
	protected static $recentAgeFile = 0;	// pour le cache navigateur (donne la date de modification la plus récente des fichiers

	public static $loginType = 'login_visiteur';
											
	protected static $myMenu = null;		// objet menu
	protected static $myPage = null;		// objet page/contenu
										
	public function __construct($url, $query, $urlArray, $conf){
		
		$this -> _config = $conf;
		
		$this -> _idPage = 	$urlArray[0].','.$urlArray[1].','.$urlArray[2];		
		$this -> _module = 	$urlArray[1];												
		$_SESSION['langue'] = $urlArray[0];	
		$this -> _urlArray = $urlArray;
		
		$this -> _url = implode(',', $urlArray);
		$this -> _urlQuery = $query;
		
		if(isset($this -> _urlQuery['print'])){
			if($this -> _urlQuery['print']=='pdf'){
				self::$outputFormat = 'pdf';
			}elseif($this -> _urlQuery['print']=='print'){
				self::$outputFormat = 'print';
			}
		 }
		
		self::$cacheTime  = 	$this->_config['cache']['expireCache'];												
		self::$expireHtml = 	$this->_config['cache']['expireHtml'];		
		
		require(ROOT_PATH.$this->_config['librairie']['interstitium'].'model.class.php');
		require(ROOT_PATH.$this->_config['librairie']['interstitium'].'menu.class.php');
		
		self::$myMenu = new Xml_Menu($urlArray);
		
		$this->setDateNames();
	}
	
	public function echo_r($data){
		echo '<pre>';
		print_r($data);
		echo '</pre>';
	}
	
	public function launchAction(){
		$data = $this -> getGlobalContent();
		$this -> setMenu($data['userRight']);
		$this -> setMisc();
		$generalCSS = $this->_config['css']['all'];
		$specificCSS = $data['style'].'.css';
		$themeFolder = $this->_config['path']['design'].$data['theme'].$this->_config['path']['css'];
		$extCSSmin = $this->_config['ext']['min.css'];
		//$generalCSSFolder = $this->_config['css'],$this->_config['path']['design'].$data['theme'].'/'.$data['style'].'/',$this->_config['ext']['min.css']
		//self::setCss($this->_config['css'],$this->_config['path']['design'].$data['theme'].'/'.$data['style'].'/',$this->_config['ext']['min.css']);
		//echo $themeFolder;
		//echo BASE_PATH;
		
		self::setCss($generalCSS, $specificCSS, $themeFolder, $extCSSmin );
		
		$this -> _templateNameSquelette = 'squelette';
		$this -> _templateDesign 		=  $data['theme'];
		
		$this -> setData();
		
		/*
		$this -> echo_r(self::$arrayToParse);
		$this -> echo_r(self::$multiArrayToParse);
		*/
		
		$this -> parseAllTheStuff($data['theme']);
		
		//--AFFICHAGE--//											// possible modification de l'expiration
		//self::$expireHtml = 60*60*24*40;							// du cache HTML
		self::printOut($this->_content,self::$outputFormat,$this -> _url);		// affichage en mode HTML
	
		//--CACHE--//
		//self::$cacheTime = 60*60*24;											// possible modification de la validité du cache HTML
		if(self::$cacheTime > 0){
			self::htmlCache($this->_content,$this -> _url,BASE_PATH.$this->_config['path']['cache'],self::$cacheTime);		// mise en cache html
		}
		//--POST-ACTION--//
		//$this->postAction($content);
		
		
	}
	
	//-------------------------
	//	GET GLOBAL CONTENT
	//-------------------------
	public function getGlobalContent(){
		$infos 		= 	self::$myPage -> getInfo();
		$content 	= 	self::$myPage -> getContent();
		$design 	= 	self::$myPage -> getDesign();
		$fileAge 	= 	self::$myPage -> filetime;
		
		(self::$recentAgeFile < $fileAge)  ? self::$recentAgeFile = $fileAge :  null;
		
		if(isset($infos['droit'])){
			$this -> analyzeRights($infos);
		}
		
		$this -> isPublished($infos);
		
		(isset($_SESSION[self::$loginType]['droits']))? 	$userRight =  $_SESSION[self::$loginType]['droits'] : $userRight =  0;
		$this -> parseArray($infos,$prefix='info_',$suffix='',$parse=false);
		$this -> parseArray($content,$prefix='contenu_',$suffix='',$parse=true);
		
		$maDate = $this->afficherDate($infos['date'],$_SESSION['langue'],$nomJour=1,$moisAbrev=1);
		self::$arrayToParse['INFO_NOM_JOUR']  	= 	$maDate[0];
		self::$arrayToParse['INFO_JOUR']		=   $maDate[1];
		self::$arrayToParse['INFO_NOM_MOIS']	= 	$maDate[2];
		self::$arrayToParse['INFO_NOM_MOIS_AB']	= 	substr  ( $maDate[2]  , 0  , 3 );
		self::$arrayToParse['INFO_MOIS']		= 	$maDate[3];
		self::$arrayToParse['INFO_ANNEE']		= 	$maDate[4];
		self::$arrayToParse['INFO_THEME']		= 	$design['theme'];
		self::$arrayToParse['INFO_STYLE']		= 	$design['style'].'.css';
		self::$arrayToParse['INFO_STYLE_BASE']	= 	$this->_config['css']['all'];
		self::$arrayToParse['INFO_CSS_FOLDER']	=   $this->_config['path']['css'];
		

		return array('userRight' => $userRight,
					 'theme'	 => $design['theme'],
					 'style'	 => $design['style']);
	}
	
	public function getPublished($infos){
		return $infos['publication'];
	}
	public function isPublished($infos){
		$publication = $this -> getPublished($infos);
		if(intval($publication) != 1){
			$_SESSION[self::$loginType]['page_unauthorized'] = $this -> _idPage.$this->_config['ext']['web'];
			FrontController::errorMessage('SQUELETTE_001 | Problème = Page non publiée');
			FrontController::redirect($_SESSION['langue'].',erreur,000.html');
		}		
	}
	public function getRights($infos){
		return $infos['droit'];
	
	}
	
	public function analyzeRights($infos){
		$droitPage = $this -> getRights($infos);
		// si l'utilisateur ne s'est pas déconnecté la dernière fois... message d'avertissement
		if(isset($_SESSION[self::$loginType]['logout']) && $_SESSION[self::$loginType]['logout']==0 ){
			$maDate = $this->afficherDate(date('d.m.Y',$_SESSION[self::$loginType]['timestamp']),$_SESSION['langue'],$nomJour=1,$moisAbrev=1);
			self::$multiArrayToParse[] = array('alert' => array('CLASS' => 'alert',
																'DATE' => $_SESSION[self::$loginType]['date'],
																'JOUR' => $maDate[1],
																'MOIS' => $maDate[2],
																'ANNEE' => $maDate[4]
																));	
		}
		if($droitPage >= 0){	
			if(isset($_SESSION[self::$loginType]['connection']) 		// Si l'utilisateur s'est loggé
				&& $_SESSION[self::$loginType]['connection']			// Si la connection est ok
				//&& $_SESSION[self::$loginType]['type'] == self::$loginType	// Si la connection est de type visiteur
				&& $_SESSION[self::$loginType]['nav']  == $_SERVER['HTTP_USER_AGENT']	// si l'utilisateur use du même navigateur
				&&  ($_SESSION[self::$loginType]['droits'] & pow(2, $droitPage))){		// si l'utilisateur dispose des bon droits
					// connecté!!!
					self::$cacheTime = 0;
					self::$expireHtml = 0;
					//echo $_SESSION[self::$loginType]['droits'];
			}else{	// si les identifiants ne sont pas bons, on redirige vers la page de login
				$_SESSION[self::$loginType]['page_unauthorized'] = $this -> _idPage.$this->_config['ext']['web'];
				FrontController::errorMessage('SQUELETTE_000 | Problème = Page à accés réservé');
				FrontController::redirect($_SESSION['langue']. $this -> _config['redirect']['login']);
			}
			return  $droitPage;
		}/* else{
			echo 'pas de droits acces sur la page = DANGER !';
		} */
	}
	
	public function parseArray($array,$prefix='',$suffix='',$parse=false){
		foreach($array as $key=>$value){
			if($parse === true){
				 $value = $this->setPlugin($value);
			} 
			self::$arrayToParse[strtoupper($prefix.$key.$suffix)] = trim($value);
		}
	}
	
	public function setPlugin($content){
		$pos = strpos($content, '%%% PLUGIN ');
		if($pos!==false){	// si il y a une occurence de '%%% PLUGIN '
			preg_match_all('#%%% PLUGIN ([a-zA-Z0-9\_\-\+\./]+):([a-zA-Z0-9;\_\-\+\./]+) %%%#', $content, $matches,PREG_SET_ORDER);
			foreach($matches as $mat){
				if(!class_exists($mat[1])){		// si la classe n'existe pas, on l'inclu!
					if(is_file($classPath = BASE_PATH.$this -> _config['path']['plugin'].$mat[1].$this -> _config['ext']['plugin'])){
						require($classPath);
					}
				}
				if(class_exists($mat[1])){	// si la classe existe, on tente d'intancier un objet...	
					$maFonction = new $mat[1]('ModuleSquelette');
					$ouputMaFonction['%%% PLUGIN '.$mat[1].':'.$mat[2].' %%%'] = $maFonction -> output($mat[2]);
				
				}else{
				
				}
			}
			if(!empty($ouputMaFonction)){
				return str_replace(array_keys($ouputMaFonction), $ouputMaFonction ,  $content);
			}
		}else{
			return $content;
		}
	} 
	
	//-------------------------
	//	SET MISCELLANEOUS
	//-------------------------
	public function setMisc(){
		self::$arrayToParse['FILETIME'] =date("d.m.Y",self::$myPage -> filetime);
		self::$arrayToParse['FILENAME_WEB'] 	=	$this -> _idPage.$this->_config['ext']['web'];
		self::$arrayToParse['LINK_RSS'] 	= ROOT_URL.'/flux.xml';
		
		// echo $_SERVER["SCRIPT_NAME"];
		
		// Login
		// L'utilisateur est connecté (logged)
		if(isset($_SESSION[self::$loginType]['connection']) && $_SESSION[self::$loginType]['connection']){
			self::$arrayToParse['CONNECTED'] 				=		true;
			self::$arrayToParse['LOGOUT_CONNECTION'] 		=		$_SESSION['langue'].',login,connection'.$this->_config['ext']['web'].'?action=out';
			self::$arrayToParse['DROITS'] 					= '<em>'.$_SESSION[self::$loginType]['droits'].'</em>';
			self::$arrayToParse['GROUPNAME']				= $_SESSION[self::$loginType]['groupname'];
			self::$arrayToParse['USERNAME']					= $_SESSION[self::$loginType]['username'];
			
		// l'utilisateur n'est pas connecté
		}else{
			self::$arrayToParse['CONNECTED'] 		=		false;
			self::$arrayToParse['LOGIN_CONNECTION'] 		=		$_SESSION['langue'].',login,connection'.$this->_config['ext']['web'];
		
		}
		// Compression
		self::$arrayToParse['T_COMP_GZIP'] = false;
		if(isset($_SERVER['HTTP_ACCEPT_ENCODING'])){
			if(substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')){
				self::$arrayToParse['T_COMP_GZIP'] = true;
			}
		}
		// Langue
		self::$arrayToParse['LANGUE_ABR'] 	=	$_SESSION['langue'];
	}
	
	//-------------------------
	//	SET MENU
	//-------------------------
	public function setMenu($userRight){
		// LANGUE ($myMenu)
		$langueMenu = self::$myMenu -> getLanguages();
		foreach($langueMenu as $lg){
			if($lg['link']==false) break;
			$active = 'non-active';
			if($lg['active']==true){
				$active = 'active';
				self::$arrayToParse['ACTIVE_LANG'] = $lg['name'];
				self::$arrayToParse['ACTIVE_LANG_ID'] = $lg['id'];
			}
			self::$multiArrayToParse[]=array('languages'=>array('NAME' => $lg['name'],
																'ACTIVE' =>  $active,
																'IS_ACTIVE' => $lg['active'],
																'ID' =>  $lg['id'],
																'LINK' => $lg['link'].$this->_config['ext']['web']));
		}
		// BREADCRUMBS
		$breadCrumbs = self::$myMenu -> getBreadCrumbs();
		foreach($breadCrumbs as $bd){
			$is_link = true;
			$parse = true;
			$type = $bd['type'];
			switch($type){
 				case 'chapter':
					
					break;
				case 'page':
					break;
				case 'rubrique':
					$is_link = false;
					break;
				case 'menu':	
					$parse = false;
				default : 
					$parse = false;
					break;
			}
			if($parse==true){
				self::$multiArrayToParse[]= array('crumbs' => array('LINK' 	=> $bd['link'].$this->_config['ext']['web'],
																	'NAME' 	=> $bd['name'],
																	'TITLE' 	=> $bd['module'],
																	'IS_LINK' 	=> $is_link
												));
			}
		}
		// CHAPTER
		$chapterAndMenu = self::$myMenu -> getChapters();
		// $this -> echo_r($chapterAndMenu['chapters']);
		//$chapterList = self::$myMenu -> getChapters();
		$chapterList = $chapterAndMenu['chapters'];
		$myChapter = $chapterAndMenu['myChapter'];
	
		self::$arrayToParse['IS_CHAPTER'] = false;
		self::$arrayToParse['CHAPTER'] = '';
		if(!empty($myChapter)){
			self::$arrayToParse['IS_CHAPTER'] = true;
			self::$arrayToParse['CHAPTER'] = $myChapter['id'];
		}
		$i =1;
		foreach($chapterList as $chap){
				
			self::$multiArrayToParse[]= array('chapter' => array('LINK'   => $chap['link'].$this->_config['ext']['web'] ,
																'NAME'    => $chap['name'],
																'T_CLASS' => $chap['t_class'],
																'ID' => $i)); 
			$i++;
		}
		// MENU
		//$menu = self::$myMenu -> getMenu($_SESSION['langue']);
		$menu = $chapterAndMenu['menu'];
		// $menu = self::$myMenu -> getMenu('',$_SESSION['langue']);
		$i = 0;
		foreach($menu as $elt){
			if(isset($elt['menu']) && $elt['menu']==1 && $elt['publication']==1
				&& (($userRight & pow(2, $elt['rights'])) or $elt['rights']<0)){
					$i++;
					$name = 'menu';
					$index = $name.'1';
					$elt['depth']++;
					if($elt['depth']>1){
						for($i = 2; $i <= $elt['depth']; $i++){
							$index .= '.'.$name.$elt['depth'];
						}
					}
					$class='';
					if($elt['active'] and !$elt['hasChild']){
						$class='actifnochild';
					}elseif($elt['active']){
						$class='actif';
					}elseif($elt['childActive']){
						$class='actif';
					}
					$link = $elt['id'].$this->_config['ext']['web'];

					if($elt['type']=='rubrique'){
						$link = '#';
					}
					if($elt['type'] != 'rubrique' Or ($elt['type'] == 'rubrique' && $elt['hasChild'] && $elt['childPubl'])){
					self::$multiArrayToParse[]= array($index => array('CLASS'   => $class,
																	'REF' 	=> $link  ,
																	'NAME'  	=> $elt['name'],
																	'T_SMENU' => $elt['hasChild'],
																	'SCLASS'	=> $class,
																	'ID' => $i
																	));
					}
			}
		}
	}
	
	//-------------------------
	//	SET CSS
	//-------------------------
	//protected static function setCss($cssList,$folder,$extMinCss){
	protected static function setCss($generalCSS, $specificCSS, $themeFolder, $extCSSmin ){
		$gCSSPath = $themeFolder.$generalCSS;
		$sCSSPath = $themeFolder.$specificCSS;
		if(is_file(BASE_PATH.$gCSSPath) && is_file(BASE_PATH.$sCSSPath)){
			// url du fichier minimisé (.min.css)
			$minCSSPath=$themeFolder.str_replace('.css',$extCSSmin,$specificCSS);
			// if the minified css does not exist -> create it
			if(!is_file(BASE_PATH.$minCSSPath)){
				self::createCSS(BASE_PATH.$gCSSPath , BASE_PATH.$sCSSPath , BASE_PATH.$minCSSPath );
			}
			// if the minified css is older than the general and/or the specific css -> re-create it
			elseif(filemtime(BASE_PATH.$gCSSPath)>filemtime(BASE_PATH.$minCSSPath) || filemtime(BASE_PATH.$sCSSPath)>filemtime(BASE_PATH.$minCSSPath)){
				self::createCSS(BASE_PATH.$gCSSPath , BASE_PATH.$sCSSPath , BASE_PATH.$minCSSPath );
			}else{
			}
			$refCss=$minCSSPath;
			//echo BASE_URL;
			self::$multiArrayToParse[]=array('css'=>array('MEDIA' => 'all' ,
															 // 'REF' 	=> $refCss.'zip'
															  'REF' 	=> BASE_URL.$refCss
												));
			
		}else{
			return false;
		}
		/* foreach($cssList as $media => $cssNom){
			$oldPath = $folder.$cssNom;
			if(is_file(BASE_PATH.$oldPath)){						// si le fichier css n'existe pas, pas de référence vers ce fichier
				// url du fichier minimisé (.min.css)
				$path=$folder.str_replace('.css',$extMinCss,$cssNom);
				if(!is_file(BASE_PATH.$path)){							// si le fichier minimisé n'existe pas encore, on le créé
					(self::createMinifiedCss(BASE_PATH.$oldPath, BASE_PATH.$path)) ? $refCss=$path  : $refCss=$oldPath;
				}elseif(filemtime(BASE_PATH.$oldPath)>filemtime(BASE_PATH.$path)){	// si le fichier minimisé est plus vieux que le fichier d'origine, on le re-minimise
					(self::createMinifiedCss(BASE_PATH.$oldPath, BASE_PATH.$path)) ? $refCss=$path  : $refCss=$oldPath;			
				}else{
					$refCss=$path;
				}
				$refCss=BASE_URL.$refCss;
				self::$multiArrayToParse[]=array('css'=>array('MEDIA' => $media ,
															  'REF' 	=> $refCss.'zip'
												));
			}else{
				//echo 'FICHIER CSS NON-EXISTANT!';
			}
		} */
	}
	public static function createCSS($bgCSSPath, $bsCSSPath, $minCSSPath){
		$content1 = file_get_contents($bgCSSPath);
		$content2 = file_get_contents($bsCSSPath);
		$handle = fopen($minCSSPath,"w+"); 
		if($handle){
			$content = self::minifyCss( $content1.$content2 );
			fwrite($handle,$content);
			fclose($handle);		// Close the file
		}else{
			return false;
		}
	
	}
	public static function minifyCss($content){
		$content=preg_replace('/(?:\n|\t)*?/', '', $content); 		// remove new line and tab
		$content=preg_replace('{[ \t]+}', ' ' , $content); 			// remove space larger than 2 (+)
		$content = preg_replace( '#\s+#', ' ', $content );
		$content = preg_replace( '#/\*.*?\*/#s', '', $content );
		$content = str_replace( '; ', ';', $content );
		$content = str_replace( ': ', ':', $content );
		$content = str_replace( ' {', '{', $content );
		$content = str_replace( '{ ', '{', $content );
		$content = str_replace( ', ', ',', $content );
		$content = str_replace( '} ', '}', $content );
		//$content = str_replace( ';}', '}', $content );
		return $content;
	}
	
	public static function createMinifiedCss($oldPath, $path){
		$content = file_get_contents($oldPath);
		$handle = fopen($path,"w+"); 
		if($handle){		// If successful
			$content=preg_replace('/(?:\n|\t)*?/', '', $content); 		// remove new line and tab
			$content=preg_replace('{[ \t]+}', ' ' , $content); 			// remove space larger than 2 (+)
			$content = preg_replace( '#\s+#', ' ', $content );
			$content = preg_replace( '#/\*.*?\*/#s', '', $content );
			$content = str_replace( '; ', ';', $content );
			$content = str_replace( ': ', ':', $content );
			$content = str_replace( ' {', '{', $content );
			$content = str_replace( '{ ', '{', $content );
			$content = str_replace( ', ', ',', $content );
			$content = str_replace( '} ', '}', $content );
			//$content = str_replace( ';}', '}', $content );	
			fwrite($handle,$content);
			fclose($handle);		// Close the file
		}else{
			return false;
		}
	}
	
	//-------------------------
	//	PARSING (PARSE ALL THE STUFF)
	//-------------------------
	public function parseAllTheStuff($themePath){
		//--TEMPLATE--//
		require(ROOT_PATH.$this->_config['librairie']['template']);	// classe de template
		// On créé une instance de la classe template, 
		//passez en paramètre le répertoire ou se trouvent tous vos fichiers templates
		$this -> _template = new Template(BASE_PATH.$this->_config['path']['design'],BASE_PATH.$this->_config['path']['cache']);

		$this -> _templateDesign 		=  $themePath;
		
		$this->setTemplateFile($this->_templateNameSquelette);	// Template squelette
		$this->setTemplateFile($this->_templateNameModule);		// Template module */
		
		// XXX avant le parsage, on devrait tester l'existence d'un plugin pour le squelette...
		
		//--PARSAGE & RECUPERATION DU CONTENU--//
		$this->parseIntoTemplate(self::$arrayToParse,self::$multiArrayToParse);	// parsage des blocs
		$this->parseTranslation();											// Variables de langue
		$this -> combineTemplate($this->_templateNameModule);			// inclusion du template module dans le template squelette
		//$this -> _template -> pparse('squelette'); 				// affichage phpBB2
		$this -> _template -> display($this->_templateNameSquelette); 				// affichage 
		
		$this->_content = ob_get_contents();					// recuperation du contenu bufferisé
		
		ob_end_clean();
	}
	
	public function setTemplateFile($name){
		$tpl = self::$myPage -> getTemplate($name);
		// On assigne a un alias "squelette" le nom du fichier qu'on compte utiliser
		$this -> _template -> set_filenames(array($name => $this -> _templateDesign.'/'.$tpl));
		self::$multiArrayToParse[]=array('template_html'=>array('NAME' => $name ,
																'FILE' 	=> $tpl
												));

	}
	
	public function parseIntoTemplate($arrayData,$multiArrayData){
		$this -> _template->assign_vars($arrayData);
		foreach($multiArrayData as $arrs){
			foreach($arrs as $cle=>$arr){
				$this -> _template->assign_block_vars($cle, $arr);
			}
		}
	}

	public function parseTranslation(){
		$dataLangue = self::$myPage->getDictionnary($_SESSION['langue']);
		$this -> _template -> set_language_var($dataLangue);
	} 
	
	public function combineTemplate($templateName){
		//$this -> _template -> assign_var_from_handle('PAGE', $templateName);	//phpBB2
		$this -> _template -> assign_display($templateName, 'PAGE', false);
	}	
	
	public static function showArrayToParse(){
		print_r(self::$multiArrayToParse);
		print_r(self::$arrayToParse);
	}
	
	//-------------------------
	//	HTML CACHE
	//-------------------------	
	public static function htmlCache($buffer,$url,$cacheFolder,$cacheTime){
		if($cacheTime>0){
			file_put_contents($cacheFolder.md5($url).'.html', $buffer);
			file_put_contents($cacheFolder.md5($url).'.time', $cacheTime);
		//	file_put_contents('./cache/'.md5($path).'.rights', $rights);
		}
	}
	
	//-------------------------
	//	OUTPUT
	//-------------------------	
	public static function printOut($content,$mode,$url){
		switch($mode){
			case 'html' : 
				View::printOutHtml($content,self::$expireHtml,self::$recentAgeFile);
				break;
			case 'pdf' :
				$content = str_replace('style.min.csszip', 'pdf.css' ,  $content);
				$content = str_replace('jpgc', 'jpg' ,  $content);
				$content = str_replace('pngc', 'png' ,  $content);
				View::printOutPdf($content,$url.'.pdf',0,0,1);
				break;
			case 'print' :
				$content = str_replace('style.min.csszip', 'print.css' ,  $content);
				$content = str_replace('jpgc', 'jpg' ,  $content);
				$content = str_replace('pngc', 'png' ,  $content);
				View::printOutHtml($content,$url.'.pdf',0,0,1);
				break;
		}
	}
	
	//-------------------------
	//	MISC
	//-------------------------	
	public function formTarget($url, $string, $free=true){
		if($this->_config['urlRewriting']['type']==1 and $free){
			self::$arrayToParse[$string] = $this->_config['urlRewriting']['cible'] ;				
			$_SESSION['cible']=	$url;		//$this -> _url.$this->_config['ext']['web'].'?id='.$id.'&action=editcontent';
			
		}else{
			self::$arrayToParse[$string] = 	$url;			// nom_fichier().'.php?quiz='.$_GET['quiz'];
		}
	}
	
	
	//
	//	FORM
	//
	
	public static function maDate(){
		return date('d.m.Y');
	}
	
	public function setDateNames(){
		if(is_file($path=ROOT_PATH.$this->_config['conf']['langue'].$_SESSION['langue'].'-date.txt')){
			if(is_array(unserialize(file_get_contents($path)))){
				$this -> _dateName = unserialize(file_get_contents($path));
			}
			
		}
	}

// $date = format <
// $lg = 'de' ou 'fr' ou 'en'
// $nomJour = 'null'  => pas d'affichage du nom du jour
//			= '1' => mardi 3 juillet 2009
// $nomMois = null => pas d'affichage du nom du mois (nombre)
// 			= 1 => abbreviation du mois 13 Jun 2009
//			= 2	=> mois complet : 13 juillet 2009
// $sep = le séparateur de la date ('d.m.Y')
	public function afficherDate($date,$lg,$nomJour=null,$nomMois=null,$sep='.'){
		$date = explode($sep,$date,3);
		$timestamp = mktime(0, 0, 0, $date[1], $date[0], $date[2]);
		$nomDate = $this -> _dateName;
		if(!empty($nomDate)){
			// NOM DU JOUR
			if($nomJour==1){	// affichage du nom du jour
				$numero_jour = date('w', $timestamp);
				$maDate[0]=$nomDate['day'][intval($numero_jour)];
			}else{
				$maDate[0]=null;
			}
			// JOUR ("23" mai)
			$maDate[1] = $date[0];
			// NOM DU MOIS
			if($nomMois==1){
				$maDate[2] = $nomDate['month'][intval($date[1])];
			}elseif($nomMois==2){
				$maDate[2] = $nomDate['month'][intval($date[1])];
			}else{
				$maDate[2] = $nomDate['month'][intval($date[1])];
			}
			// NUMERO DU MOIS
			$maDate[3] = $date[1];
			//ANNEE
			$maDate[4] = $date[2];
		}else{
			$maDate[0] = null;
			$maDate[1] = $date[0];
			$maDate[2] = $date[1];
			$maDate[3] = $date[1];
			$maDate[4] = $date[2];
		}
		return $maDate;
	}
	
	//
	//		WRITE AND OPEN
	//
	/* public static function writeArray($data, $path){
		return file_put_contents($path, serialize($data));

	}
	
	public static function openArray($path){
		return unserialize(file_get_contents($path));
	} */

	// Cette fonction lit un fichier de type csv (choix du séparateur)
	// retourne un array vide si le fichier est vide
	/* public static function read_csv($filename, $separateur,$longueur='1024'){
		if(is_file($filename)){	
			if($file=fopen($filename,"r")){
				$table=array();
				while($ligne=fgetcsv($file,$longueur,$separateur)){
					if(!empty($ligne[0])){
						$table[]=$ligne;
					}
				}
				fclose($file);
				//supprime la dernière ligne vide
				return $table;
			}else{
				return false;
			}
		}else{
			return false;
		}
	} */

	/* public static function saveMyXML($dom,$path){
		$outXML = $dom->saveXML();
		$dom = new DOMDocument();
		$dom->preserveWhiteSpace = false;
		$dom->formatOutput = true;
		$dom->loadXML($outXML);
		if(is_file($path)) {
			$dom->save($path.'.tmp'); 
			unlink($path);
			rename($path.'.tmp', $path); # On renomme le fichier temporaire avec le nom de l'ancien
		} else {
			$dom->save($path); 
		}
		# On place les bons droits
		@chmod($path,0644);	// Returns TRUE on success or FALSE on failure. 
		# On vérifie le résultat
		if(is_file($path) AND !is_file($path.'.tmp')){
			return true;
		}else{
			return false;
		}
	} */
	
	/**
	 * (c) plumxml 2010
	 * Méthode qui écrit dans un fichier
	 * Mode écriture seule; place le pointeur de fichier au début du fichier et réduit la taille du fichier à 0. Si le fichier n'existe pas, on tente de le créer. 
	 *
	 * @param	xml					contenu du fichier 
	 * @param	filename			emplacement et nom du fichier
	 * @return	boolean				retourne vrai si l'écriture s'est bien déroulée
	 **/
	function write($xml, $filename) {

		if(file_exists($filename)) {
			$f = fopen($filename.'.tmp', 'w'); # On ouvre le fichier temporaire
			fwrite($f, trim($xml)); # On écrit
			fclose($f); # On ferme
			unlink($filename);
			rename($filename.'.tmp', $filename); # On renomme le fichier temporaire avec le nom de l'ancien
		} else {
			$f = fopen($filename, 'w'); # On ouvre le fichier
			fwrite($f, trim($xml)); # On écrit
			fclose($f); # On ferme
		}
		# On place les bons droits
		@chmod($filename,0644);
		# On vérifie le résultat
		if(file_exists($filename) AND !file_exists($filename.'.tmp'))
			return true;
		else
			return false;
	}

	/* public static function openDomXml($filePath){
		$dom = new DomDocument();
		$dom -> formatOutput = true;
		$dom -> preserveWhiteSpace = true; 
		if($dom -> load($filePath)){
			(self::$recentAgeFile<filemtime($filePath))  ? self::$recentAgeFile=filemtime($filePath) :  null;	
			return $dom;
		}else{
			//echo '<br/>opening file = true!!<br/>';
			return false;
		}
	} */
	
	public function urlAddQuery($array,$new=false,$link=false){
		$addQuery = array();
		($link) ? $link = $link : $link = $_SERVER['REQUEST_URI'];
		$query = $this->_urlQuery;
		if($query === null or $new){
			foreach($array as $k=>$v){
				$addQuery[] = $k.'='.htmlentities($this -> myUrlEncode(trim($v)), ENT_NOQUOTES, 'utf-8');
			}
			/* $addString = implode('&',$addQuery);
			return $_SERVER['REQUEST_URI'].'?'.$addString; */
		}else{
			foreach($array as $k=>$v){
				if(isset($query[$k])){
					$query[$k] = htmlentities($this -> myUrlEncode(trim($v)), ENT_NOQUOTES, 'utf-8');
				}else{
					$addQuery[] = $k.'='.htmlentities($this -> myUrlEncode(trim($v)), ENT_NOQUOTES, 'utf-8');
				}
			}
			foreach($query as $k=>$v){
				$addQuery[] = $k.'='.$v;
			}
		}
		$addString = implode('&',$addQuery);
		if($addQuery==null){
			return parse_url($link,PHP_URL_PATH );
		}else{
			return  parse_url($link,PHP_URL_PATH ).'?'.$addString;
		
		}
	}
	
	public function myUrlEncode($string) {
		$entities = array('%21', '%2A', '%27', '%28', '%29', '%3B', '%3A', '%40', '%26', '%3D', '%2B', '%24', '%2C', '%2F', '%3F', '%25', '%23', '%5B', '%5D');
		$replacements = array('!', '*', "'", "(", ")", ";", ":", "@", "&", "=", "+", "$", ",", "/", "?", "%", "#", "[", "]");
		return str_replace($entities, $replacements, urlencode($string));
	}
	
	/* public static function copyFile($fileSource,$fileDest,$safe=true){
		$path_parts = pathinfo($fileDest);
		if(!is_file($fileSource) or !is_dir($path_parts['dirname'])){
			
			return false;
		}
		if($safe){	
			// $fileName = $path_parts['dirname'].'/'.$path_parts['filename'];		// FREE XXX filename existe pas!
			$name = substr($path_parts['basename'], 0, -4);
			$fileName = $path_parts['dirname'].'/'.$name;
			$ext = $path_parts['extension'];
			$fileDest = $fileName;
			$fileDest = self::findUniqueFileName($fileName,$ext);
			$fileDest = $fileDest.'.'.$ext;
		}
		if(copy($fileSource, $fileDest)){
			return $fileDest;
		}else{
			echo '<br/> Erreur de copy!!<br/>';
			return false;
		}
	} */
	
	// cherche un nom de fichier unique pour un fichier donné
	// et retourne le nom sans extension
	// (pour par exemple sauvegarder un fichier qui existe déjà 
	// sous un autre nom "monfichier-1.ext")
	/* public static function findUniqueFileName($fileName,$ext,$sep='.'){
		$fileDest = $fileName;
		$i=0;
		while(is_file($fileDest.$sep.$ext)){
			$fileDest = $fileName.'-'.$i;
			$i++;
		}
		return $fileDest;
	}
	
	public static function findUniqueDirName($dirName){
		$dirDest = rtrim($dirName, '/').'/';
		$i=0;
		while(is_dir($dirDest)){
			$dirDest = $dirName.'-'.$i;
			$i++;
		}
		return $dirDest;
	}
	 */
	public static function removeShortWords($str,$nb=2){
		$str = preg_replace('#-([a-z]{1,'.$nb.'})-#', '-', '-'.$str.'-');
		$str = preg_replace('#-([a-z]{1,'.$nb.'})-#', '-', $str);
		$str = trim($str,'-');	// Supprimer les tirets en début et fin
		//$str = preg_replace('#-[a-z]{1,'.$nb.'}-#', '-', $str);
		return $str;
	}
	
	public static function removeAccents($str, $charset='utf-8',$del=true){
		$str = htmlentities($str, ENT_NOQUOTES, $charset);
		$str = preg_replace('#\&([A-za-z])(?:acute|cedil|circ|grave|ring|tilde|uml)\;#', '\1', $str);
		$str = preg_replace('#\&([A-za-z]{2})(?:lig)\;#', '\1', $str); // pour les ligatures e.g. '&oelig;'
		if($del){
			$str = preg_replace('#\&[^;.]+\;#', '', $str); // supprime les autres caractères
		}else{
			$str = preg_replace('/([^a-z0-9]+)/i', '-', $str);
			$str = trim($str,'-');	// Supprimer les tirets en début et fin
		}
		return $str;
	}
	/* 
 */




















}


?>