<?php

class ModuleMenuCreer extends ModuleAdmin{
	
	
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
			if($mod['actif'] === '1'){
				self::$multiArrayToParse[] = array('module' => array('NOM' => $mod['nom'],
																	 'ID' => $mod['id']
																	));
				$modulesId[] =  $mod['id'];
			}
		}
		
		// Obtenir la liste des langues
		$path = ROOT_PATH.$this->_config['path']['arborescence'];
		$id = 	null;
		$lg = 	'fr';
		$menuSite = new Xml_Menu($path, $id, $lg);
		$langueId = array();
		
		$langueMenu = $menuSite -> getLanguages();
		
		foreach($langueMenu as $lg){
			self::$multiArrayToParse[] = array('langue' => array('NOM' => $lg['name'],
																	'ID' => $lg['id']
																	));
			$langueId[] = $lg['id'];
		}
		
		
		// analyse du formulaire
		if(isset($_POST) && !empty($_POST)){
			//$this -> echo_r($_POST);
			$data = $_POST['page'];
			if(in_array($data['module'],$modulesId) && in_array($data['langue'],$langueId) && !empty($data['titre'])){
				
				$host  = $_SERVER['SERVER_NAME'].rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
				
				//echo 'location: http://'.$host.'/'.$data['langue'].','.$data['module'].',create.html';
				$linkRedirect = $this->urlAddQuery(array('title'=>$data['titre'], 'lg' => $data['langue']),true,'http://'.$host.'/fr,'.$data['module'].',create.html');
				$linkRedirect = 'http://'.$_SERVER['SERVER_NAME'].$linkRedirect;
				header('location: '.$linkRedirect); 
				exit(); 
				
				
				
			}
			// on re-dirige vers le fichier de construction
			// correspondant au module choisi !
			/* $data = $_POST['page'];
			*/

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


/* 	public function setData(){
		$dom = $this -> _domData;
		
		$this->_templateNameModule = 'page';
		
		// si formulaire envoyé
		if(isset($_POST) && !empty($_POST)){
			// on re-dirige vers le fichier de construction
			// correspondant au module choisi !
			$data = $_POST['page'];
			$module = filter_var($data['module'],FILTER_SANITIZE_STRING); 
			header('location: '.$this->_urlArray[0].','.$module.',creer.html');
			exit();

		}else{
			
			if($this->_config['urlRewriting']['type']==1){
				self::$arrayToParse['FICHIER_CIBLE'] = $this->_config['urlRewriting']['cible'] ;				// nom_fichier().'.php?quiz='.$_GET['quiz'];
				$_SESSION['cible']=	filter_var($_SERVER['REQUEST_URI'], FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
			}else{
				self::$arrayToParse['FICHIER_CIBLE'] = 	filter_var($_SERVER['REQUEST_URI'], FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);				// nom_fichier().'.php?quiz='.$_GET['quiz'];
			}
				
			// LISTE DES LANGUES DISPONIBLES
			// Cf. arborescence.xml
			$domPath = BASE_PATH.$this->_config['path']['arborescence'];
			$menuDom = self::openDomXml($domPath);
			$langues = $menuDom -> getElementsByTagName('langue');
			foreach($langues as $mod){
				self::$multiArrayToParse[] = array('langue' => array('NOM' => $mod -> getAttribute('nom'),
																	'ID' => $mod -> getAttribute('id')
																	));
			}
			
			
			//LISTE DES MODULES DISPONIBLES
			// cf. module.xml
			$dom = self::openDomXml(ADMIN_PATH.$this->_config['path']['conf'].'module'.$this->_config['ext']['data']);
			$modules = $dom -> getElementsByTagName('mod');
			foreach($modules as $mod){
				
				self::$multiArrayToParse[] = array('module' => array('NOM' => $mod -> getAttribute('nom'),
																	'ID' => $mod -> getAttribute('id')
																	));
			}
		}
		
		

	} */
}






?>