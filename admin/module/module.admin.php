<?php


//extends ModuleSquelette
class ModuleAdminModule extends ModuleAdmin{
	
	public function __construct($url, $query, $urlArray, $conf){
		parent::__construct($url, $query, $urlArray, $conf);		
		require(ROOT_PATH.$this->_config['librairie']['interstitium'].'page.class.php');
		self::$myPage = new Xml_Page($urlArray);
	}
	
	public function setData(){
		/* $dom = $this -> _domData; */
		self::$arrayToParse['CURRENT_CRUMB'] = self::$arrayToParse['INFO_TITRE'];
		$this->_templateNameModule = 'page';
		
	/* 	$domPageInfo = $dom  -> getElementsByTagName('info') -> item(0);	// DomElement
		
		$domPageContenu = $dom -> getElementsByTagName('contenu') -> item(0);	// DomElement
		$domPageContenuPrincipal = $domPageContenu -> getElementsByTagName('principal') -> item(0) -> textContent;	// DomElement
		$domPageContenuSecondaire = $domPageContenu -> getElementsByTagName('secondaire') -> item(0) -> textContent;	// DomElement
		self::$arrayToParse['CONTENU'] = $this->parseContenu($domPageContenuPrincipal);
		self::$arrayToParse['CONTENU_SECONDAIRE'] = $this->parseContenu($domPageContenuSecondaire); */
		
		self::$arrayToParse['LIEN_CREER_PAGE'] = 'fr,menu,creer.html';
	
		//chargement du fichier
		$dom = self::openDomXml(BASE_PATH.$this->_config['path']['conf'].$this -> _urlArray[1].$this->_config['ext']['data']);
		$modules = $dom -> getElementsByTagName('item');
		
		foreach($modules as $mod){
			self::$multiArrayToParse[] = array('liste' => array('NOM' => $mod -> getAttribute('nom'),
																'ID' => $mod -> getAttribute('id'),
																'ACTIF' => $mod -> getAttribute('actif'),
																'TYPE' => $mod -> getAttribute('type'),
																'DESCRIPTION' => $mod -> getAttribute('description')
																));
		}
		

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