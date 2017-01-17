<?php

//extends ModuleSquelette
class ModulePageSupprimer extends ModuleAdmin{
	
	public function __construct($url, $query, $urlArray, $conf){
		parent::__construct($url, $query, $urlArray, $conf);		
		require(ROOT_PATH.$this->_config['librairie']['interstitium'].'page.class.php');
		$path = BASE_PATH.$this->_config['path']['data'].$urlArray[1].'/'.$urlArray[2].$this->_config['ext']['data'];
		self::$myPage = new Xml_Page($path);
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
			
			// DATA FILE
			$pathData = ROOT_PATH.$this->_config['path']['data'].$idArray[1].'/'.$idArray[2].$this->_config['ext']['data'];
			self::$_page = new Xml_Page($pathData);
			
			// MENU
			$pathMenu = ROOT_PATH.$this->_config['path']['arborescence'];
			$menuSite = new Xml_Menu($pathMenu, null, '');
			
			// TAG
			$pathTag = ROOT_PATH.$this->_config['path']['data'].'tags-'.$idArray[0].'.data';
			require(ROOT_PATH.$this->_config['librairie']['interstitium'].'tags.class.php');
			$tagObject = new Tags($pathTag);
			
			// redirection si le fichier n'existe pas
			if(!is_file($pathData)){
				$menuSite 	-> deleteNodeId($id);	// delete menu entry
				$tagObject 	-> deleteTags($id);		// delete tags
				$this -> removeTofluxSyndication($id);	// delete from RSS
				FrontController::redirect('');
			}			
			
			
			
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
			
			$itemMenu = $menuSite -> getMenuItem($id);
			if(!empty($itemMenu)){		// si la page est trouvé dans le menu
			
				if(isset($_POST) and !empty($_POST)){
					if(isset($_POST['ok']) && $_POST['ok'] == 'ok'){	
						// On supprime la page
						self::$_page -> delete(); 			// delete file
						$menuSite 	-> deleteNodeId($id);	// delete menu entry
						$tagObject 	-> deleteTags($id);		// delete tags
						
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
			
		}else{
			echo 'problemmee, pas de id!!!';
		}
	}
	

}			
			




?>