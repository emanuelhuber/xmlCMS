<?php
//extends ModuleSquelette
class ModuleAdminChapter extends ModuleAdmin{

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
			$idChap = $this -> _urlQuery['id'];	// = lg,chapter,nom-du-chapitre
			$idArray = explode(',',$idChap);
			/* 
			// PAGE object
			self::$_page = new Xml_Page($idArray, 'root');
			 */
			/* if(self::$_page -> error){
				// redirection si le fichier n'existe pas
				$this -> _menu -> deleteNodeId($idChap);	// supprime du menu
				Xml_Page::removeId($idChap);				// supprime du flux, tags etc.
				FrontController::redirect('');
				//echo '<br/>pbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbb';
			} */
			self::$arrayToParse['FORM_ID'] =	$idChap;
			
			
			$this -> formTarget($_SERVER['REQUEST_URI'], 'FICHIER_CIBLE');
			
			
			switch($this -> _action){
				case 'editer':
					$this -> editChap($idChap);
					$this->_templateNameModule = 'editmenu';
					// cette fonction publie le contenu, si le lien
					// dsfsdfs/fr,page,editer?id=xx,xxxx,xxxx&publish=publish
					// a été cliqué
				//	$this -> publish($idChap);
					
					break;
				case 'supprimer':
					$this -> deleteChap($idChap);
					break;
				default:
					break;
			} 
			// parse data
			//$this -> parseInfo();
					
		}elseif(isset($this -> _urlQuery['title']) && !empty($this -> _urlQuery['title']) 
			&& isset($this -> _urlQuery['lg']) && !empty($this -> _urlQuery['lg']) 
			&& $this -> _action == 'create'){
			
			// Créer une page
			//Xml_Page::createPage($this -> _urlQuery['lg'],$this -> _urlQuery['title']);
			//$this -> createContent();
		}
	}
	//-------------------------
	//  EDITING CHAPTER
	//-------------------------
	public function editChap($idChap){
		// MENU FILE
		/* $pathMenu = ROOT_PATH.$this->_config['path']['arborescence'];
		$menuSite = new Xml_Menu($pathMenu, null, ''); */
		if(isset($_POST) and !empty($_POST)){
			$dataForm = $_POST['rubrique'];
			$this -> _menu -> setMenuItemAttribute($idChap,$dataForm);
			// date of modification (warning : modification are saved!)
			/* self::$multiArrayToParse[]=array('info'=>array( 'DATE'	=> date('l j  F Y H:i:s')));  */
			$this -> saveConfirmation();
		}
		$menuContent = $this -> _menu -> getMenuItem($idChap);
		self::$arrayToParse['NOM-PAGE'] = 	$menuContent['id'];
		self::$arrayToParse['ID'] = 	$menuContent['id'];
		self::$arrayToParse['NOM'] = 	$menuContent['nom'];
		($menuContent['menu']==1) ? self::$arrayToParse['SELECTED_1'] = 	'selected="selected"' : self::$arrayToParse['SELECTED_0'] = 	'selected="selected"';
		/* $pageObject = new Xml_Page($path);
		$infos = $pageObject -> getInfo();
		$this -> parseArray($infos,'form_'); */
		
		self::$arrayToParse['FORM_ID'] =	$idChap;
		self::$arrayToParse['FORM_TITRE'] =	$menuContent['nom'];
		self::$arrayToParse['CURRENT_CRUMB'] = 'Chapitre : '.self::$arrayToParse['FORM_TITRE'];
		
	

	}	
	//-------------------------
	//  EDITING CHAPTER
	//-------------------------
	public function deleteChap($idChap){	
		self::$arrayToParse['FORM_ID'] =	$idChap;
			
		$infos = $this -> _menu -> getMenuItem($idChap);
		if(!empty($infos)){		// si le chapitre est trouvé dans le menu
			$this -> parseArray($infos,'form_'); 
			
			self::$arrayToParse['CURRENT_CRUMB'] = 'Chapitre : '.self::$arrayToParse['FORM_NOM'];
			
			if(isset($_POST) and !empty($_POST)){
				if(isset($_POST['ok']) && $_POST['ok'] == 'ok'){	
					// SUPPRESSION DU CHAPITRE DU MENU
					/* $pageObject -> delete(); 			// delete file */
					$this -> _menu 	-> deleteNodeId($idChap, true);	// delete menu entry
					/* $tagObject 	-> deleteTags($id);		// delete tags */
					
					// AFFICHAGE DE LA PAGE D'ACCUEIL
					$this -> saveConfirmation();
					$this->_templateNameModule = 'confirmation';
					
				}else{	// redirection vers la page d'accueil
					$this->_templateNameModule = 'page';
					FrontController::redirect('');
				}
			}else{	// affichage du formulaire
				$this->_templateNameModule = 'page';
				$this -> formTarget($this->urlAddQuery(array('id'=>$idChap, 'action' => 'delete'),true), 'FICHIER_CIBLE');
			}
		}else{	// redirection vers la page d'accueil
			FrontController::redirect('');
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
			$idChap = $lg.','.$this->_module.','.$idFileNew;
			$array = array('nom' => urldecode($this -> _urlQuery['title']),
						   'module' => $this->_module,
						   'soeur' => '',
						   'menu' => '1',
						   'publication' => '0',
						   'droits' => '-1'
							);
			$this -> _menu -> addMenuItem($lg, $array, $idChap);
			// redirection vers la page d'édition
			FrontController::redirect('fr,page,editer.html?id='.$idChap);
		}else{
			echo 'Pas créer!!!';
		}
	} */
}			
?>