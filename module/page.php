<?php


class ModulePage extends ModuleSquelette{
	
	public function __construct($url, $query, $urlArray, $conf){
		parent::__construct($url, $query, $urlArray, $conf);		
		require(ROOT_PATH.$this->_config['librairie']['interstitium'].'page.class.php');
		//$path = BASE_PATH.$this->_config['path']['data'].$urlArray[1].'/'.$urlArray[2].$this->_config['ext']['data'];
/* 		if(is_file($path)){
		}else{
			// 'PAGE_000' 'Problème = le fichier de données '.$path.' n\'existe pas !!'
			FrontController::errorMessage('PAGE_000');
			FrontController::redirect($_SESSION['langue'].',erreur,404.html');		// sinon, erreur! 
		} */
		self::$myPage = new Xml_Page($urlArray);
		if(self::$myPage -> error){
			// 'PAGE_000' 'Problème = le fichier de données '.$path.' n\'existe pas !!'
			FrontController::errorMessage('PAGE_000 | roblème = le fichier de données '.$path.' n\'existe pas !!');
			FrontController::redirect($_SESSION['langue'].',erreur,404.html');		// sinon, erreur! 
		}
	}
	
		
	public function setBreadCrumbs(){
		//parent::setBreadCrumbs();
		$activePage = self::$myMenu -> getMenuItem($this -> _idPage);
		if(isset($activePage['nom'])){
			self::$arrayToParse['CURRENT_CRUMB'] = $activePage['nom'];
		}
		//self::$arrayToParse['CURRENT_CRUMB'] = $this -> _activNode -> getAttribute('nom');
		
	}
	
	public function setData(){
		$this -> _templateNameModule 	= 'page';
		$this -> setBreadCrumbs();
		
		self::$arrayToParse['LINK_PRINT_PDF'] = $this->urlAddQuery(array('print'=>'pdf'),false);
		self::$arrayToParse['LINK_PRINT'] = $this->urlAddQuery(array('print'=>'print'),false);
		
/* 		$this-> echo_r(array_keys(self::$arrayToParse));
		$this-> echo_r((self::$multiArrayToParse));
		foreach(self::$multiArrayToParse as $key=>$value){
			foreach($value as $ke=>$va){
				echo '<h3>'.$ke.'</h3>';
				foreach($va as $k=>$v){
					echo $k.'<br/>';
				
				}
			}			
		} */
		
	}
	

	


}




























?>