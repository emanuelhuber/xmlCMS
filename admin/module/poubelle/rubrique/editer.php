<?php

//extends ModuleSquelette
class ModuleRubriqueEditer extends ModuleAdmin{
	
	public function __construct($url, $query, $urlArray, $conf){
		parent::__construct($url, $query, $urlArray, $conf);		
		require(ROOT_PATH.$this->_config['librairie']['interstitium'].'page.class.php');
		$path = BASE_PATH.$this->_config['path']['data'].$urlArray[1].'/'.$urlArray[2].$this->_config['ext']['data'];
		self::$myPage = new Xml_Page($path);
	}
	



	
	public function setData(){
		$this -> _templateNameModule 	= 'editinfo';
		self::$arrayToParse['CURRENT_CRUMB'] = self::$arrayToParse['INFO_TITRE'];
		self::$multiArrayToParse[]= array('crumbs' => array('LINK' 	=> 'fr,menu,index.html',
																	'NAME' 	=> 'Menu',
																	'TITLE' 	=> 'Menu',
																	'IS_LINK' 	=> true
												));
		if(isset($this -> _urlQuery['id']) && !empty($this -> _urlQuery['id'])){
			
			$id = $this -> _urlQuery['id'];
			$idArray = explode(',',$id);
			
			// DATA FILE
			$pathData = ROOT_PATH.$this->_config['path']['data'].$idArray[1].'/'.$idArray[2].$this->_config['ext']['data'];
			if(!isset($this -> _urlQuery['action']) or empty($this -> _urlQuery['action'])){
				$this -> _urlQuery['action'] = 'editcontent';
			}
		
			$this->_templateNameModule = 'editmenu';
			$this -> editRubriqueInMenu($pathData,$id);
			
			$this -> formTarget($_SERVER['REQUEST_URI'], 'FICHIER_CIBLE');
			/* 
			$this -> setGlobalContent($this -> _urlQuery['action'],$pathData,$id); */
			
		}	
	}
	
	//-------------------------
	//  EDITING
	//-------------------------
	
	public function editRubriqueInMenu($path,$id){
		// MENU FILE
		$pathMenu = ROOT_PATH.$this->_config['path']['arborescence'];
		$menuSite = new Xml_Menu($pathMenu, null, '');
		if(isset($_POST) and !empty($_POST)){
			$dataForm = $_POST['rubrique'];
			$menuSite -> setMenuItemAttribute($id,$dataForm);
			// date of modification (warning : modification are saved!)
			self::$multiArrayToParse[]=array('info'=>array( 'DATE'	=> date('l j  F Y H:i:s'))); 
		}
		$menuContent = $menuSite -> getMenuItem($id);
		self::$arrayToParse['NOM-PAGE'] = 	$menuContent['id'];
		self::$arrayToParse['ID'] = 	$menuContent['id'];
		self::$arrayToParse['NOM'] = 	$menuContent['nom'];
		($menuContent['menu']==1) ? self::$arrayToParse['SELECTED_1'] = 	'selected="selected"' : self::$arrayToParse['SELECTED_0'] = 	'selected="selected"';
		/* $pageObject = new Xml_Page($path);
		$infos = $pageObject -> getInfo();
		$this -> parseArray($infos,'form_'); */
		
		self::$arrayToParse['FORM_ID'] =	$id;
		self::$arrayToParse['FORM_TITRE'] =	$menuContent['nom'];
	}
	
	

}			
			




?>