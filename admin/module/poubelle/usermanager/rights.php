<?php

//extends ModuleSquelette
class ModuleAdminUsermanager extends ModuleAdmin{
	
	public function __construct($url, $query, $urlArray, $conf){
		parent::__construct($url, $query, $urlArray, $conf);		
		require(ROOT_PATH.$this->_config['librairie']['interstitium'].'page.class.php');
		//$path = BASE_PATH.$this->_config['path']['data'].$urlArray[1].'/'.$urlArray[2].$this->_config['ext']['data'];
		self::$myPage = new Xml_Page($urlArray);
	}
	
	



	
	public function setData(){
		self::$arrayToParse['CURRENT_CRUMB'] = self::$arrayToParse['INFO_TITRE'];
		//$dom = $this -> _domData;
		//self::$arrayToParse['SECONDAIRE'] = $dom-> getElementsByTagName('secondaire') -> item(0)->firstChild->data;
		
		$this->_templateNameModule = 'page';
		
		require_once(ROOT_PATH.$this->_config['librairie']['interstitium'].'groups.class.php');
		$path = ROOT_PATH.$this->_config['path']['data'].'/login/groups.xml';
		$groupsClass = new Xml_Group($path );
		

		
		self::$arrayToParse['LINK_GROUP'] = $this -> _url.$this->_config['ext']['web'];
		self::$arrayToParse['LINK_ADD_GROUP'] = $this -> _url.$this->_config['ext']['web'].'?action=add';
		

		
		
	
			if(isset($_POST) and !empty($_POST)){
				$dataForm = $_POST;
				$names = $dataForm['name'];
				$descriptions = $dataForm['description'];
				(isset($dataForm['activated'])) ? $activateds = $dataForm['activated'] : $activateds = null;

				$groupsClass -> rightEdit($activateds,$names,$descriptions);
				

				self::$multiArrayToParse[]=array('info'=>array( 'DATE'	=> date('l j  F Y H:i:s'))); 
				
			} 
		
			
		$this->_templateNameModule = 'page';
		//$this -> cibleFormulaire($this -> _url.$this->_config['ext']['web'].'?action=edit', 'FICHIER_CIBLE');
		
		$this -> formTarget($_SERVER['REQUEST_URI'], 'FICHIER_CIBLE');
		
		// Liste des droits activés
		$rights = $groupsClass -> rightsList(true);
		foreach($rights as $right){
			self::$multiArrayToParse[]=array('list'=>array('NB' 	=> $right['id'],
														   'ACTIV'  => intval($right['activated']),
														   'ACTIVATED' => $right['activated'],
														   'RGHT_NB'	=>  $right['id'],
														   'RGHT_NAME'	=>  $right['name'],
														   'RGHT_DESCRIPTION' => $right['description'])); 
		
		}
		
		
		
		
	}
	
}			
			




?>