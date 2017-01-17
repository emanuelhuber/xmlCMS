<?php
//extends ModuleSquelette
class ModuleAdminPage extends ModuleAdmin{

	
	public function __construct($url, $query, $urlArray, $conf){
		parent::__construct($url, $query, $urlArray, $conf);		
		require(ROOT_PATH.$this->_config['librairie']['interstitium'].'page.class.php');
		$path = BASE_PATH.$this->_config['path']['data'].$urlArray[1].'/'.$urlArray[2].$this->_config['ext']['data'];
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
			$id = $this -> _urlQuery['id'];
			$idArray = explode(',',$id);
				
			// TAG object
			/* $pathTag = ROOT_PATH.$this->_config['path']['data'].'tags-'.$idArray[0].'.data';
			require(ROOT_PATH.$this->_config['librairie']['interstitium'].'tags.class.php');
			$this -> _tags = new Tags($pathTag); */
			
			// PAGE object
			self::$_page = new Xml_Page($idArray, 'root');
			
			
			if(self::$_page -> error){
				// redirection si le fichier n'existe pas
			/* 	$this -> _menu -> deleteNodeId($id);
				self::$_page 	-> deleteTags($id);				// delete tags
				$this -> removeTofluxSyndication(self::$arrayToParse['FORM_ID']);		 // Flux ATOM	
				// XXX
				FrontController::redirect('fr,menu,index.html');  */
				echo '<br/>pbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbb';
				
			}
			
			
			switch($this -> _action){
				case 'editer':
					$this -> editPage($id);
					break;
				/* case 'create':
					$this -> createContent(); */
					//break;
				case 'supprimer':
					$this -> deleteContent($id);
					//break;
				default:
					break;
			} 
			
			
			
		}elseif(isset($this -> _urlQuery['title']) && !empty($this -> _urlQuery['title']) 
			&& isset($this -> _urlQuery['lg']) && !empty($this -> _urlQuery['lg']) ){
			$this -> createContent();
		}
		
		
		

	}
	
	//-------------------------
	//  EDITING PAGE
	//-------------------------
	public function deleteContent($id){
		
		// Pour l'affichage des infos sur la page
		// à supprimer
		$infos = self::$_page -> getInfo();
		$this -> parseArray($infos,'form_');
		self::$arrayToParse['FORM_ID'] =	$id;
		
		self::$arrayToParse['IS_ONLINE'] 	=	false;
		if($infos['publication'] == 1){
			self::$arrayToParse['IS_ONLINE'] 	=	true;
		}
		(intval($infos['droit'])<0) ? self::$arrayToParse['HAS_RIGHT'] = false :  self::$arrayToParse['HAS_RIGHT'] = true;
		$rights = $this -> _groups -> rightsList();

		foreach($rights as $right){
			if(intval($infos['droit']) == intval($right['right'])){
				self::$arrayToParse['RIGHT_NAME'] = $right['name'];
			}
		}
		
		$itemMenu = $this -> _menu -> getMenuItem($id);
		if(!empty($itemMenu)){		// si la page est trouvé dans le menu
		
			if(isset($_POST) and !empty($_POST)){
				if(isset($_POST['ok']) && $_POST['ok'] == 'ok'){	
					// On supprime la page
					self::$_page -> delete(); 			// delete file
					$this -> _menu 	-> deleteNodeId($id);	// delete menu entry
					// $this -> _tags 	-> deleteTags($id);		// delete tags
					
					// ET ON AFFICHE LA PAGE D'ACCUEIL
					self::$multiArrayToParse[]=array('info'=>array( 'DATE'	=> date('l j  F Y H:i:s'))); 
					$this->_templateNameModule = 'confirmation';
					
				}else{
					$this->_templateNameModule = 'page';
					$redirectPaht = basename(parse_url($_SERVER['REQUEST_URI'],PHP_URL_PATH ));
					$redirectPaht  = $_SERVER['SERVER_NAME'].rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
					FrontController::redirect('');
					
				}
			}else{
				$this->_templateNameModule = 'page';
				$this -> formTarget($this->urlAddQuery(array('id'=>$id, 'action' => 'delete'),true), 'FICHIER_CIBLE');
			}
		}else{	// redirection vers la page d'accueil
			FrontController::redirect('');
		}
	}
	
	
	//-------------------------
	//  EDITING PAGE
	//-------------------------
	public function createContent(){		
		// id-formating
		$idFile = self::removeAccents(urldecode($this -> _urlQuery['title']), $charset='utf-8',$del=false);
		$idFile = strtolower($idFile);
		$idFile = self::removeShortWords($idFile,1);	// supprime les mots d'une lettre
		
		// Créé un nouveau contenu et si tout marche, renvoi l'id du fichier
		// sinon renvoi FALSE
		$idFileNew = Xml_Page::createContent($this->_module,$idFile);
		
		// si le fichier est créé
		if($idFileNew != false){
			$newPage = new Xml_Page(array('',$this->_module,$idFileNew), 'root');
			$data = array();
			$data['titre'] = urldecode($this -> _urlQuery['title']);
			if(isset($_SESSION['login_admin']['username']))	$data['auteur'] = $_SESSION['login_admin']['username'];
			$newPage -> setInfo($data);
			
			// ajouter les infos dans le menu
			$lg = $this -> _urlQuery['lg'];
			$id = $lg.','.$this->_module.','.$idFileNew;
			$array = array('nom' => urldecode($this -> _urlQuery['title']),
						   'module' => $this->_module,
						   'soeur' => '',
						   'menu' => '1',
						   'publication' => '0',
						   'droits' => '-1'
							);
			$this -> _menu -> addMenuItem($lg, $array, $id);
			
			// redirection vers la page d'accueil
			FrontController::redirect('');
		}else{
			echo 'Pas créer!!!';
		}
			
		//echo 'Y a eu un probleme!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!';
		
	}
	
	//-------------------------
	//  EDITING PAGE
	//-------------------------
	public function editPage($id){
		
	
		if(!isset($this -> _urlQuery['action']) or empty($this -> _urlQuery['action'])){
			$action = 'editcontent';
		}else{
			$action = $this -> _urlQuery['action'];
		}
	
		self::$arrayToParse['LINK_EDITCONTENT'] =	$this->urlAddQuery(array('id'=>$id),true);
		self::$arrayToParse['LINK_EDITMENU'] 	=	$this->urlAddQuery(array('id'=>$id, 'action' => 'editmenu'),true);
		self::$arrayToParse['LINK_EDITINFO'] 	=	$this->urlAddQuery(array('id'=>$id, 'action' => 'editinfo'),true);
		self::$arrayToParse['LINK_EDITDESIGN'] 	=	$this->urlAddQuery(array('id'=>$id, 'action' => 'editdesign'),true);
		
		$infos = self::$_page -> getInfo();
	
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
					$this -> editInfoXml($id, $postData, $infos);
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
				$this -> editDesign($id);
				break;
			default:
				echo 'Pas d action définie!!!! Erreur!!!';
				$this->_templateNameModule = 'editcontent';
				$this -> editContent();
				break;
		}
		
		$this -> publish($id, $infos);
	}	

}			
			




?>