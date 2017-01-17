<?php

//extends ModuleSquelette
class ModulePluginGooglemap extends ModuleAdmin{
protected $_plugin = '';
	
	public function __construct($url, $query, $urlArray, $conf){
		parent::__construct($url, $query, $urlArray, $conf);		
		require(ROOT_PATH.$this->_config['librairie']['interstitium'].'page.class.php');
		$path = BASE_PATH.$this->_config['path']['data'].$urlArray[1].'/'.$urlArray[2].$this->_config['ext']['data'];
		self::$myPage = new Xml_Page($path);
		$this->_plugin = $urlArray[2];
	}
	
	public function setData(){
		$this->_templateNameModule = 'page';
		self::$arrayToParse['CURRENT_CRUMB'] = self::$arrayToParse['INFO_TITRE'];
			
		
		$this -> formTarget($_SERVER['REQUEST_URI'], 'FICHIER_CIBLE');
		
		
		// LIEN pour editer l'API-KEY (apparement superflu dans la nouvelle version de googlemap)
		//self::$arrayToParse['EDIT_LINK'] = 	$this->urlAddQuery(array('id'=>'api.ini', 'action'=>'edit'),true);
	
	
	
		// liste de dossier contenant les cartes googlemap
		$dossier = opendir($folder =  ROOT_PATH.$this -> _config['path']['data'].'plugin/'.$this->_plugin.'/');
		while ($fichier = readdir($dossier)) {
			// STYLE - fichier CSS
			if($fichier != "." && $fichier != ".." && is_dir($folder.$fichier.'/')) {
				self::$multiArrayToParse[] = array('liste' => array('ID' => $fichier,
																  'DELETE_LINK' => $this->urlAddQuery(array('id'=>$fichier, 'action'=>'delete'),true)
																));
			}
		}
		
		
		
		if(isset($this -> _urlQuery['id']) && !empty($this -> _urlQuery['id'])
			&& isset($this -> _urlQuery['action']) && !empty($this -> _urlQuery['action'])){
			$id = $this -> _urlQuery['id'];
			
			self::$arrayToParse['ID'] = 	$id;
			
			$path = $folder.$id.'/';
			if(is_dir($path)){
				if($this -> _urlQuery['action']=='delete'){
					$this->_templateNameModule = 'delete';
					if(isset($_POST) and !empty($_POST)){
						// si on veut supprimer l'encart, on le supprime
						if(isset($_POST['ok']) && $_POST['ok'] == 'ok'){	
							// On supprime la page
							self::clearDir($path);
							FrontController::redirect(basename($this->urlAddQuery('',true)));
						}else{
							//$this->_templateNameModule = 'page';
							 FrontController::redirect(basename($this->urlAddQuery('',true)));
							// echo basename($this->urlAddQuery('',true));
							
						}
					}
				}
			}else{
				echo $path;
			}
			/* self::$multiArrayToParse[]= array('crumbs' => array('LINK' 	=> $this->urlAddQuery(array(),true),
															'NAME' 	=> self::$arrayToParse['INFO_TITRE'],
															'TITLE' 	=> self::$arrayToParse['INFO_TITRE'],
															'IS_LINK' 	=> true
										));
					self::$arrayToParse['CURRENT_CRUMB'] = $id; */
			
		}
		
	}
		
	// fonction des classes de métiers (lib/interstitium/model.class.php)
	public static function clearDir($dossier) {
		$ouverture=@opendir($dossier);
		if (!$ouverture) return;
		while($fichier=readdir($ouverture)) {
			if ($fichier == '.' || $fichier == '..') continue;
				if (is_dir($dossier.'/'.$fichier)) {
					$r=self::clearDir($dossier.'/'.$fichier);
					if (!$r) return false;
				}
				else {
					$r=@unlink($dossier.'/'.$fichier);
					if (!$r) return false;
				}
		}
		closedir($ouverture);
		$r=@rmdir($dossier);
		if (!$r) return false;
			return true;
	}

}




		
		


?>