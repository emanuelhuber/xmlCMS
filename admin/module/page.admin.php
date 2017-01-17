<?php
//extends ModuleSquelette
class ModuleAdminPage extends ModuleAdmin{

	public function __construct($url, $query, $urlArray, $conf){
		parent::__construct($url, $query, $urlArray, $conf);		
		require(ROOT_PATH.$this->_config['librairie']['interstitium'].'page.class.php');
		self::$myPage = new Xml_Page($urlArray);
	}
	
	public function setData(){
		self::$arrayToParse['CURRENT_CRUMB'] = self::$arrayToParse['INFO_TITRE'];
		self::$multiArrayToParse[]= array('crumbs' => array('LINK' 	=> 'fr,menu,index.html',
																	'NAME' 	=> 'Menu',
																	'TITLE' 	=> 'Menu',
																	'IS_LINK' 	=> true
												));
		
		if(isset($this -> _urlQuery['id']) && !empty($this -> _urlQuery['id'])){
			$idPage = $this -> _urlQuery['id'];	// = lg,page,nom-de-la-page
			$idArray = explode(',',$idPage);
			
			// PAGE object
			self::$_page = new Xml_Page($idArray, 'root');
			
			if(self::$_page -> error){
				// redirection si le fichier n'existe pas
				$this -> _menu -> deleteNodeId($idPage);	// supprime du menu
				Xml_Page::removeId($idPage);				// supprime du flux, tags etc.
				FrontController::redirect('');
				//echo '<br/>pbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbb';
			}
			self::$arrayToParse['FORM_ID'] =	$idPage;
			
			
			$this -> formTarget($_SERVER['REQUEST_URI'], 'FICHIER_CIBLE');
			
			
			switch($this -> _action){
				case 'editer':
					$this -> editPage($idPage);
					// cette fonction publie le contenu, si le lien
					// dsfsdfs/fr,page,editer?id=xx,xxxx,xxxx&publish=publish
					// a été cliqué
					$this -> publish($idPage);
					
					break;
				case 'supprimer':
					$this -> deleteContent($idPage);
					break;
				default:
					break;
			} 
			// parse data
			$this -> parseInfo();
					
		}elseif(isset($this -> _urlQuery['title']) && !empty($this -> _urlQuery['title']) 
			&& isset($this -> _urlQuery['lg']) && !empty($this -> _urlQuery['lg']) 
			&& $this -> _action == 'create'){
			
			// Créer une page
			//Xml_Page::createPage($this -> _urlQuery['lg'],$this -> _urlQuery['title']);
			$this -> createContent();
		}
	}
	//-------------------------
	//  EDITING PAGE
	//-------------------------
	public function editPage($idPage){
		
		if(!isset($this -> _urlQuery['action']) or empty($this -> _urlQuery['action'])){
			$action = 'editcontent';
		}else{
			// marche pas chez free
			//	$action = filter_var($action, FILTER_SANITIZE_STRING);
			$action = $this -> _urlQuery['action'];
		}
	
		self::$arrayToParse['LINK_EDITCONTENT'] =	$this->urlAddQuery(array('id'=>$idPage),true);
		self::$arrayToParse['LINK_EDITMENU'] 	=	$this->urlAddQuery(array('id'=>$idPage, 'action' => 'editmenu'),true);
		self::$arrayToParse['LINK_EDITINFO'] 	=	$this->urlAddQuery(array('id'=>$idPage, 'action' => 'editinfo'),true);
		self::$arrayToParse['LINK_EDITDESIGN'] 	=	$this->urlAddQuery(array('id'=>$idPage, 'action' => 'editdesign'),true);
		self::$arrayToParse['LINK_EDITTEMPLATE'] 	=	$this->urlAddQuery(array('id'=>$idPage, 'action' => 'edittemplate'),true);
		
		$this->_templateNameModule = $action;
		
		switch($action){
			case 'editinfo':
				$this -> editInfo($idPage);
				break;
			case 'editmenu':
				$this -> editMenu($idPage);
				break;
			case 'editcontent':
				$this -> editContent();
				break;
			case 'editdesign':
				$this -> editDesign($idPage);
				break;
			case 'edittemplate':
				$this -> editTemplate($idPage);
				break;
			default:
				echo 'Pas d action définie!!!! Erreur!!!';
				$this->_templateNameModule = 'editcontent';
				$this -> editContent();
				break;
		}

	}	
	
	
/* 	
	//-------------------------
	//  CREATE PAGE
	//-------------------------
	public function createContent(){		
		// id-formating
		$idFile = self::removeAccents(urldecode($this -> _urlQuery['title']), $charset='utf-8',$del=false);
		$idFile = strtolower($idFile);
		$idFile = self::removeShortWords($idFile,1);	// supprime les mots d'une lettre
		
		$lg = $this -> _urlQuery['lg'];
		// Créé un nouveau contenu et si tout marche, renvoi l'id du fichier
		// sinon renvoi FALSE
		$idFileNew = Xml_Page::createPage($lg, $idFile);
		
		// si le fichier est créé
		if($idFileNew != false){
			// on créé une instance de cette page et on modifie les métadonnées
			$newPage = new Xml_Page(array('',$this->_module,$idFileNew), 'root');
			$data = array();
			$data['titre'] = urldecode($this -> _urlQuery['title']);
			$data['date'] = date('j.m.Y');
			if(isset($_SESSION['login_admin']['username']))	$data['auteur'] = $_SESSION['login_admin']['username'];
			$newPage -> setInfo($data);
			
			// ajouter les infos dans le menu
			$idPage = $lg.','.$this->_module.','.$idFileNew;
			$array = array('nom' => urldecode($this -> _urlQuery['title']),
						   'module' => $this->_module,
						   'soeur' => '',
						   'menu' => '1',
						   'publication' => '0',
						   'droits' => '-1'
							);
			$this -> _menu -> addMenuItem($lg, $array, $idPage);
			// redirection vers la page d'édition
			FrontController::redirect('fr,page,editer.html?id='.$idPage);
		}else{
			echo 'Pas créer!!!';
		}
	} */
}			
?>