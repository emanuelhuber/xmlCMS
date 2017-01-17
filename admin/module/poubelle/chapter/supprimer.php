<?php

//extends ModuleSquelette
class ModuleChapterSupprimer extends ModuleAdmin{
	
	public function __construct($url, $query, $urlArray, $conf){
		parent::__construct($url, $query, $urlArray, $conf);		
		require(ROOT_PATH.$this->_config['librairie']['interstitium'].'page.class.php');
		$path = BASE_PATH.$this->_config['path']['data'].$urlArray[1].'/'.$urlArray[2].$this->_config['ext']['data'];
		self::$myPage = new Xml_Page($path);
	}
	


	public function setData(){
	
		self::$multiArrayToParse[]= array('crumbs' => array('LINK' 	=> 'fr,menu,index.html',
																	'NAME' 	=> 'Menu',
																	'TITLE' 	=> 'Menu',
																	'IS_LINK' 	=> true
												));
		
		if(isset($this -> _urlQuery['id']) && !empty($this -> _urlQuery['id'])){
			$id = $this -> _urlQuery['id'];
			$idArray = explode(',',$id);
			// MENU
			$pathMenu = ROOT_PATH.$this->_config['path']['arborescence'];
			$menuSite = new Xml_Menu($pathMenu, null, '');

			self::$arrayToParse['FORM_ID'] =	$id;
			
			$infos = $menuContent = $menuSite -> getMenuItem($id);
			if(!empty($infos)){		// si le chapitre est trouvé dans le menu
				$this -> parseArray($infos,'form_'); 
				
				self::$arrayToParse['CURRENT_CRUMB'] = 'Chaptire : '.self::$arrayToParse['FORM_NOM'];
				
				if(isset($_POST) and !empty($_POST)){
					if(isset($_POST['ok']) && $_POST['ok'] == 'ok'){	
						// SUPPRESSION DU CHAPITRE DU MENU
						/* $pageObject -> delete(); 			// delete file */
						$menuSite 	-> deleteNodeId($id, true);	// delete menu entry
						/* $tagObject 	-> deleteTags($id);		// delete tags */
						
						// AFFICHAGE DE LA PAGE D'ACCUEIL
						self::$multiArrayToParse[]=array('info'=>array( 'DATE'	=> date('l j  F Y H:i:s'))); 
						$this->_templateNameModule = 'confirmation';
						
					}else{	// redirection vers la page d'accueil
						$this->_templateNameModule = 'page';
						FrontController::redirect('');
					}
				}else{	// affichage du formulaire
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