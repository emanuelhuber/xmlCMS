<?php


//extends ModuleSquelette
class ModuleAdminPlugin extends ModuleAdmin{
	
	protected $_plugin = '';
	
	public function __construct($url, $query, $urlArray, $conf){
		parent::__construct($url, $query, $urlArray, $conf);		
		require(ROOT_PATH.$this->_config['librairie']['interstitium'].'page.class.php');
		self::$myPage = new Xml_Page($urlArray);
		if(isset($urlArray[2])) $this -> _plugin = $urlArray[2];
	}
	

	
	public function setData(){
		self::$arrayToParse['CURRENT_CRUMB'] = self::$arrayToParse['INFO_TITRE'];

		
		if(!empty($this -> _plugin)){
			/* echo 'oooooooooooooooooooooooo';
			*/
			echo BASE_PATH.$this -> _config['path']['module'].'plugin/'.$this -> _plugin.'.admin'.$this -> _config['ext']['class']; 
			echo '<br/>';
				
			if(is_file($filePath = BASE_PATH.$this -> _config['path']['module'].'plugin/'.$this -> _plugin.'.admin'.$this -> _config['ext']['class'])){
				include($filePath);
			}
		}else{
			$this -> showIndex();
		}

	}
	
	public function showIndex(){
		
		/* //chargement du fichier
		$dom = self::openDomXml(BASE_PATH.$this->_config['path']['conf'].$this -> _urlArray[1].$this->_config['ext']['data']);
		$modules = $dom -> getElementsByTagName('item');
		
		foreach($modules as $mod){
			self::$multiArrayToParse[] = array('liste' => array('NOM' => $mod -> getAttribute('nom'),
																'ID' => $mod -> getAttribute('id'),
																'ACTIF' => $mod -> getAttribute('actif'),
																'TYPE' => $mod -> getAttribute('type'),
																'DESCRIPTION' => $mod -> getAttribute('description'),
																// 'LINK' => $this->urlAddQuery(array('id'=>$mod -> getAttribute('id')),true,)
																'LINK' => BASE_URL.'/fr,plugin,'.strtolower($mod -> getAttribute('id')).'.html'
																));
		}
		if(isset($this -> _urlQuery['id']) && !empty($this -> _urlQuery['id'])){
			$id = $this -> _urlQuery['id'];
			$classPath =  ROOT_PATH.'/plugin/'.$id.'.php' ;
			//echo $classPath;
			// on inclut le plugin
			require($classPath);
			$plugin = new $id;
		}else{
		
		
		} */

		$this->_templateNameModule = 'page';
		
		$pluginClassDir = ROOT_PATH.$this -> _config['path']['plugin'];
		$dossier = opendir($pluginClassDir);

		while ($fichier = readdir($dossier)) {
			if($fichier != "." && $fichier != ".." && !is_dir($pluginClassDir.$fichier)) {
				$className = substr($fichier, 0, -4);
				$classPath = $pluginClassDir.$fichier;
				require($classPath);
				if(class_exists($className)){	// si la classe existe, on tente d'intancier un objet...	
					$myPlugin = new $className;
					
					$infPlg = $myPlugin -> getInfo();
					
					
					//$pluginList[$className] = $myPlugin -> listPlug();
					self::$multiArrayToParse[] = array('liste' => array('NOM' => $infPlg['name'],
																		'ID' => $className,
																		//'ACTIF' => $mod -> getAttribute('actif'),
																		//'TYPE' => $mod -> getAttribute('type'),
																		'DESCRIPTION' => $infPlg['desc'],
																		// 'LINK' => $this->urlAddQuery(array('id'=>$mod -> getAttribute('id')),true,)
																		'LINK' => BASE_URL.'/fr,plugin,'.strtolower($className).'.html'
																		));
				}
		  }
		}
		closedir($dossier);

		
	}
	public static function openDomXml($filePath){
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
	} 
}

?>