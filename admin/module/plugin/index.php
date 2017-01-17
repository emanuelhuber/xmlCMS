<?php


//extends ModuleSquelette
class ModuleAdminPlugin extends ModuleAdmin{
	
	public function __construct($url, $query, $urlArray, $conf){
		parent::__construct($url, $query, $urlArray, $conf);		
		require(ROOT_PATH.$this->_config['librairie']['interstitium'].'page.class.php');
		self::$myPage = new Xml_Page($urlArray);
	}
	

	
	public function setData(){
		$this->_templateNameModule = 'page';
		self::$arrayToParse['CURRENT_CRUMB'] = self::$arrayToParse['INFO_TITRE'];
		
		//chargement du fichier
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
		
		
		}
		
		
	}
}

?>