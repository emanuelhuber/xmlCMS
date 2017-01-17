<?php


class ModuleAdminErreur extends ModuleAdmin{
	
	private $_id = '';	// id de l'erreur (p.ex. 404, 503 etc.)
	
	public function __construct($url, $query, $urlArray, $conf){
		parent::__construct($url, $query, $urlArray, $conf);
		require(ROOT_PATH.$this->_config['librairie']['interstitium'].'erreur.class.php');
		self::$myPage = new Xml_Erreur($urlArray);
		
		$this -> _id = intval($urlArray[2]);
	}

	/* public function setBreadCrumbs(){
		//parent::setBreadCrumbs();
		$activePage = self::$myMenu -> getMenuItem($this -> _idPage);
		if(isset($activePage['nom'])){
			self::$arrayToParse['CURRENT_CRUMB'] = $activePage['nom'];
		}
		//self::$arrayToParse['CURRENT_CRUMB'] = $this -> _activNode -> getAttribute('nom');
		
	} 	*/
	
	public function setData(){
		self::$arrayToParse['CURRENT_CRUMB'] = self::$arrayToParse['INFO_TITRE'];
		
		$this -> _templateNameModule 	= 'page';
		//$this -> setBreadCrumbs();
		
		// Numéro de l'erreur
		self::$arrayToParse['ERREUR_CODE'] = $this -> _id;
		// Explication de l'erreur
		self::$arrayToParse['ERREUR_EXPLICATION'] = self::$myPage -> getErreur($this -> _id);
		
		if(isset($_SESSION['error']) && isset($_SESSION['error']['message'])){
			self::$arrayToParse['MESSAGE'] = $_SESSION['error']['message'] .'<br/>'.$_SESSION['error']['request'].'<br/>'.$_SESSION['error']['referer'];
		}
		
	}
	

	
	



}


?>


