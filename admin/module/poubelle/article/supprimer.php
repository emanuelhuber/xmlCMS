<?php

//extends ModuleSquelette
class ModuleArticleSupprimer extends ModuleAdmin{
	
	private $_id = '';
	//private static $_pageToEdit = null;
	
	public function __construct($url, $query, $urlArray, $conf){
		parent::__construct($url, $query, $urlArray, $conf);		
		require(ROOT_PATH.$this->_config['librairie']['interstitium'].'article.class.php');
		require(ROOT_PATH.$this->_config['librairie']['interstitium'].'page.class.php');
		$path = BASE_PATH.$this->_config['path']['data'].$urlArray[1].'/'.$urlArray[2].$this->_config['ext']['data'];
		self::$myPage = new Xml_Page($path);
	}
	
	


	
	public function setData(){
		
		if(isset($this -> _urlQuery['id']) && !empty($this -> _urlQuery['id'])){
			$id = $this -> _urlQuery['id'];
			$idArray = explode(',',$id);
			
			// DATA FILE
			//$pathData = ROOT_PATH.$this->_config['path']['data'].$idArray[1].'/'.$idArray[2].$this->_config['ext']['data'];
			$pathData = ROOT_PATH.$this->_config['path']['data'].$idArray[1].'/'.$idArray[2].'/00-'.'index'.$this->_config['ext']['data'];
			// redirection si le fichier n'existe pas
			if(!is_file($pathData)) 	FrontController::redirect('');
			self::$_page = new Xml_Article($pathData);
			
			// MENU
			$pathMenu = ROOT_PATH.$this->_config['path']['arborescence'];
			$menuSite = new Xml_Menu($pathMenu, null, '');
			
			// TAG
			$pathTag = ROOT_PATH.$this->_config['path']['data'].'tags-'.$idArray[0].'.data';
			require(ROOT_PATH.$this->_config['librairie']['interstitium'].'tags.class.php');
			$tagObject = new Tags($pathTag);
			
			
			
/* 			if(!isset($this -> _urlQuery['action']) or empty($this -> _urlQuery['action'])){
				$this -> _urlQuery['action'] = 'editcontent';
			}
			$this -> setGlobalContent($this -> _urlQuery['action'],$pathData,$id); */
			self::$arrayToParse['FORM_ID'] =	$id;
			$infos = self::$_page -> getInfo();
			$this -> parseArray($infos,'form_');
			self::$multiArrayToParse[]= array('crumbs' => array('LINK' 	=> 'fr,menu,index.html',
															'NAME' 	=> 'Menu',
															'TITLE' 	=> 'Menu',
															'IS_LINK' 	=> true
										));
			self::$arrayToParse['CURRENT_CRUMB'] = 'supprimer la collection d\'articles  «&nbsp;'.self::$arrayToParse['FORM_TITRE'].'&nbsp;»';
			
			if(isset($_POST) and !empty($_POST)){
				if(isset($_POST['ok']) && $_POST['ok'] == 'ok'){	
					// On supprime la page
					self::$_page -> delete(); 				// delete file
					$menuSite 	-> deleteNodeId($id);		// delete menu entry
					$tagObject 	-> deleteTags($id);			// delete tags
					$this -> removeTofluxSyndication($id);	// delete from RSS	
					
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
			
		}else{
			echo 'problemmee, pas de id!!!';
		}
	}
	


}			
			




?>