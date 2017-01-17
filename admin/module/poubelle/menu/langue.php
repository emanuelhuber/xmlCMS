<?php

class ModuleMenuLangue extends ModuleAdmin{
	
	
	public function __construct($url, $query, $urlArray, $conf){
		parent::__construct($url, $query, $urlArray, $conf);		
		require(ROOT_PATH.$this->_config['librairie']['interstitium'].'page.class.php');
		$path = BASE_PATH.$this->_config['path']['data'].$urlArray[1].'/'.$urlArray[2].$this->_config['ext']['data'];
		self::$myPage = new Xml_Page($path);
	}
	
	
	public function setData(){
		$this->_templateNameModule = 'page';
		self::$arrayToParse['CURRENT_CRUMB'] = self::$arrayToParse['INFO_TITRE'];
		self::$multiArrayToParse[]= array('crumbs' => array('LINK' 	=> 'fr,menu,index.html',
																	'NAME' 	=> 'Menu',
																	'TITLE' 	=> 'Menu',
																	'IS_LINK' 	=> true
												));
		
		
		$this -> formTarget($_SERVER['REQUEST_URI'], 'FICHIER_CIBLE');
		
		// Obtenir la liste des modules
		require(ROOT_PATH.$this->_config['librairie']['interstitium'].'module.class.php');
		$path = BASE_PATH.$this->_config['path']['conf'].'module'.$this->_config['ext']['data'];
		$myModule = new Xml_Module($path);
		$modules = $myModule -> getModulesList();
		
		$modulesId = array();
		
		foreach($modules as $mod){
			self::$multiArrayToParse[] = array('module' => array('NOM' => $mod['nom'],
																 'ID' => $mod['id']
																));
			$modulesId[] =  $mod['id'];
		}
		
		// Obtenir la liste des langues
		$path = ROOT_PATH.$this->_config['path']['arborescence'];
		$id = 	null;
		$lg = 	'';
		$menuSite = new Xml_Menu($path, $id, $lg);
		$langueId = array();
		
		/* $langueMenu = $menuSite -> getLanguages();
		
		foreach($langueMenu as $lg){
			self::$multiArrayToParse[] = array('langue' => array('NOM' => $lg['name'],
																	'ID' => $lg['id']
																	));
			$langueId[] = $lg['id'];
		} */
		
		
		// Ajouter une langue !
		if(isset($_POST['langue']['name']) && !empty($_POST['langue']['name'])
			&& isset($_POST['langue']['id']) && !empty($_POST['langue']['id'])){
			//$this -> echo_r($_POST);
			$data = $_POST['langue'];

			
			// ajouter au menu
			$menuSite -> addLanguage($_POST['langue']['name'], $_POST['langue']['id']);
			
			// créer un fichier .ini (dictionnaire)
			$langFolder = ROOT_PATH.$this->_config['path']['data'].'squelette/';
			$dossier = opendir($langFolder);
			
			$tags = array();	// va contenir les clefs uniques (toutes langues comprises)
			
			
			while ($fichier = readdir($dossier)) {
				$path = $langFolder.$fichier;
				// si c'est un fichier
				if($fichier != "." && $fichier != ".." && !is_dir($path)) {
					$extension = pathinfo($fichier, PATHINFO_EXTENSION); 
					if($extension == 'ini'){
						$dic = parse_ini_file($path, false);
						$tags = array_merge($tags,array_keys($dic));
					}
				}
			}
			
			$tags = array_unique($tags);
			$myDic = array_fill_keys ($tags, 'A_TRADUIRE');
			$this -> writeIni($myDic, $langFolder.'squelette-'.$_POST['langue']['id'].'.ini', $section = false);
			
			FrontController::redirect('');
			//$host  = $_SERVER['SERVER_NAME'].rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
			
			//echo 'location: http://'.$host.'/'.$data['langue'].','.$data['module'].',create.html';
			/* $linkRedirect = $this->urlAddQuery(array('title'=>$data['titre'], 'lg' => $data['langue']),true,'http://'.$host.'/fr,'.$data['module'].',create.html');
			$linkRedirect = 'http://'.$_SERVER['SERVER_NAME'].$linkRedirect;
			header('location: '.$linkRedirect); 
			exit();  */

		}
		
		//$this -> echo_r(self::$multiArrayToParse);
	}
	

	
	/* Titre          : (PHP5) Copie du contenu d'un dossier en conservant...     */
	/* URL            : http://www.phpsources.org/scripts434-PHP.htm              */
	/* Auteur         : IlbeeNetwork                                              */
	/* Date édition   : 23 Juil 2008                                              */
	/* Website auteur : http://www.ilbee.net/                                     */
	public function copyDir($origine, $destination) {
		$test = scandir($origine);

		$file = 0;
		$file_tot = 0;

		foreach($test as $val) {
			if($val!="." && $val!="..") {
				if(is_dir($origine."/".$val)) {
					CopyDir($origine."/".$val, $destination."/".$val);
					$this -> isDir_or_CreateIt($destination."/".$val);
				} else {
					$file_tot++;
					if(copy($origine."/".$val, $destination."/".$val)) {
						$file++;
					} else {
						if(!file_exists($origine."/".$val)) {
							echo $origine."/".$val;
						};
					};
				};
			};
		}
		return true;
	}
	
	public function isDir_or_CreateIt($path) {
		if(is_dir($path)) {
			return true;
		} else {
			if(mkdir($path)) {
				return true;
			} else {
				return false;
			}
		}
	}

}






?>