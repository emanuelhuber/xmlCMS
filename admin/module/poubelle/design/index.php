<?php

//extends ModuleSquelette
class ModuleDesignIndex extends ModuleAdmin{
	
/* 	protected $_page	= null;
	protected $_tags	= null;
	protected $_menu	= null; */
	
	public function __construct($url, $query, $urlArray, $conf){
		parent::__construct($url, $query, $urlArray, $conf);		
		
		require(ROOT_PATH.$this->_config['librairie']['interstitium'].'page.class.php');
		$path = BASE_PATH.$this->_config['path']['data'].$urlArray[1].'/'.$urlArray[2].$this->_config['ext']['data'];
		self::$myPage = new Xml_Page($path);
		
	}
	
	


	public function setData(){
		self::$arrayToParse['CURRENT_CRUMB'] = self::$arrayToParse['INFO_TITRE'];
		$this -> _templateNameModule 	= 'page';
	/* 	self::$multiArrayToParse[]= array('crumbs' => array('LINK' 	=> 'fr,menu,index.html',
																	'NAME' 	=> 'Menu',
																	'TITLE' 	=> 'Menu',
																	'IS_LINK' 	=> true
												)); */
		
		
		if(isset($this -> _urlQuery['id']) && !empty($this -> _urlQuery['id'])){
			$id = $this -> _urlQuery['id'];
			$idArray = explode(',',$id);
			
			// tag object
			$pathTag = ROOT_PATH.$this->_config['path']['data'].$idArray[1].'/tags-'.$idArray[0].'.data';
			require(ROOT_PATH.$this->_config['librairie']['interstitium'].'tags.class.php');
			$this -> _tags = new Tags($pathTag);
			
			// DATA FILE
			$pathData = ROOT_PATH.$this->_config['path']['data'].$idArray[1].'/'.$idArray[2].$this->_config['ext']['data'];
			if(!isset($this -> _urlQuery['action']) or empty($this -> _urlQuery['action'])){
				$this -> _urlQuery['action'] = 'editcontent';
			}
			
			// redirection si le fichier n'existe pas
			if(!is_file($pathData)) 	FrontController::redirect($id.'.html');
			
			$this -> setGlobalContent($this -> _urlQuery['action'],$pathData,$id);
				
			
		}	
	}
	
	//-------------------------
	//  EDITING
	//-------------------------
	
	public function setGlobalContent($action,$path,$id){
		// page object
		self::$_page = new Xml_Page($path);
		
		self::$arrayToParse['LINK_EDITCONTENT'] =	$this->urlAddQuery(array('id'=>$id),true);
		self::$arrayToParse['LINK_EDITMENU'] 	=	$this->urlAddQuery(array('id'=>$id, 'action' => 'editmenu'),true);
		self::$arrayToParse['LINK_EDITINFO'] 	=	$this->urlAddQuery(array('id'=>$id, 'action' => 'editinfo'),true);
		self::$arrayToParse['LINK_EDITDESIGN'] 	=	$this->urlAddQuery(array('id'=>$id, 'action' => 'editdesign'),true);
		
		$infos = self::$_page -> getInfo();
		$oldData = self::$_page -> getInfo();	// data of xml
		$this -> parseArray($infos,'form_');
		self::$arrayToParse['FORM_ID'] =	$id;

		self::$arrayToParse['CURRENT_CRUMB'] = 'Page : '.self::$arrayToParse['FORM_TITRE'];
		
		// Si le contenu est publié
		if($infos['publication'] == 1){
			self::$arrayToParse['IS_ONLINE'] 	=	true;
			self::$arrayToParse['LINK_PUBLISH'] 	=	$this->urlAddQuery(array('publish' => 'unpublish'),false);
		}else{
			self::$arrayToParse['IS_ONLINE'] 	=	false;
			self::$arrayToParse['LINK_PUBLISH'] 	=	$this->urlAddQuery(array('publish' => 'publish'),false);
		}
		// Si y'a pas de droits
		(intval($infos['droit'])<0) ? self::$arrayToParse['HAS_RIGHT'] = false :  self::$arrayToParse['HAS_RIGHT'] = true;
		
		$this -> formTarget($_SERVER['REQUEST_URI'], 'FICHIER_CIBLE');
		$this -> formTarget($_SERVER['REQUEST_URI'], 'ADD_FLUX_CIBLE');
		

		// marche pas chez free
	//	$action = filter_var($action, FILTER_SANITIZE_STRING);
		switch($action){
			case 'editinfo':
				$this->_templateNameModule = 'editinfo';
				if(isset($_POST['info']) and !empty($_POST['info'])){
					$postData = $_POST['info'];
					// edit xml file
					$this -> editInfoXml($id, $postData, $oldData);
					$data = array('droits' => $postData['droit']);
					$this ->  updateMenu($id, $data);
				}
				// parse data
				$this -> parseInfo();
				break;
			case 'editmenu':
				$this->_templateNameModule = 'editmenu';
				$this -> editMenu($id);
				break;
			case 'editcontent':
				$this->_templateNameModule = 'editcontent';
				$this -> editContent();
				break;
			case 'editdesign':
				$this->_templateNameModule = 'editdesign';
				$this -> editDesign($path,$id);
				break;
			default:
				echo 'Pas d action définie!!!! Erreur!!!';
				$this->_templateNameModule = 'editcontent';
				$this -> editContent($path,$id);
				break;
		}
		
		// PUBLIER (ONLINE)
		if(isset($this -> _urlQuery['publish']) && $this -> _urlQuery['publish']=='publish'){
			// Si pas de droits => ajouter au flux rss
			if(($oldData['droit']<0 && $oldData['publication']!=1)) {
				// $oldData['titre']='Page : '.$oldData['titre'];
				$this -> addTofluxSyndication(self::$arrayToParse['FORM_ID'],$oldData);		 // Flux ATOM				
			}
			self::$arrayToParse['IS_ONLINE'] 	=	true;
			// Actualiser la date de création du fichier (aujourd'hui)
			self::$_page -> setInfo($id, array('publication'=> 1, 'date' => date('d.m.Y')));
			$this ->  updateMenu($id, array('publication'=> 1));			// Actualiser le menu
		
		// RETIRER DE LA PUBLICATIO (OFF-LINE)
		}elseif(isset($this -> _urlQuery['publish']) && $this -> _urlQuery['publish']=='unpublish'){
			// supprimer du flux rss
			$this -> removeTofluxSyndication(self::$arrayToParse['FORM_ID']);		 // Flux ATOM				
			self::$arrayToParse['IS_ONLINE'] 	=	false;
			// actualiser le fichier _id.xml ainsi que 00-index.xml
			self::$_page -> setInfo($id, array('publication'=> 0, 'date' => date('d.m.Y')));
			$this ->  updateMenu($id, array('publication'=> 0));			// Actualiser le menu
		}
		
	}
		

}			
			




?>