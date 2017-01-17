<?php

//extends ModuleSquelette
class ModulePageCreate extends ModuleAdmin{
	
	public function __construct($url, $query, $urlArray, $conf){
		parent::__construct($url, $query, $urlArray, $conf);		
		require(ROOT_PATH.$this->_config['librairie']['interstitium'].'page.class.php');
		$path = BASE_PATH.$this->_config['path']['data'].$urlArray[1].'/'.$urlArray[2].$this->_config['ext']['data'];
		self::$myPage = new Xml_Page($path);
	}
	
/* 	public function setBreadCrumbs(){
		parent::setBreadCrumbs();

	} */


	
	public function setData(){
		$this -> _templateNameModule 	= 'page';
		
		if(isset($this -> _urlQuery['title']) && !empty($this -> _urlQuery['title']) 
			&& isset($this -> _urlQuery['lg']) && !empty($this -> _urlQuery['lg']) ){
			
			// Copier le fichier xml modèle
			// et renommer le fichiers selon le nom du document
			$origine = BASE_PATH.'/datamodel/'.$this->_module.'/';
			$destination = ROOT_PATH.$this->_config['path']['data'].$this->_module.'/';
			if(is_dir($origine) && is_dir($destination)){
				if(is_file($origine.'new.xml')){
					
					// Copy & Rename
					$fileName = self::removeAccents(urldecode($this -> _urlQuery['title']), $charset='utf-8',$del=false);
					$fileName = strtolower($fileName);
					$fileName = self::removeShortWords($fileName);
					$idFile = self::copyFile($origine.'new.xml', $destination.$fileName.'.xml');
					$path_parts = pathinfo($idFile);
					$idFile = $path_parts['filename'];
					
					
					$newPage = new Xml_Page($destination.$fileName.'.xml');
					
					$data = array();
					$data['titre'] = urldecode($this -> _urlQuery['title']);
					if(isset($_SESSION['login_admin']['username']))	$data['auteur'] = $_SESSION['login_admin']['username'];
					$newPage -> setInfo('',$data);
					
					// ajouter les infos dans le menu
					$path = ROOT_PATH.$this->_config['path']['arborescence'];
					$id = 	null;
					$lg = 	'fr';
					$menuSite = new Xml_Menu($path, $id, $lg);
					
					$lg = $this -> _urlQuery['lg'];
					$id = $lg.','.$this->_module.','.$idFile;
					$array = array('nom' => urldecode($this -> _urlQuery['title']),
								   'module' => $this->_module,
								   'soeur' => '',
								   'menu' => '1',
								   'publication' => '0',
								   'droits' => '-1'
									);
					$menuSite -> addMenuItem($lg, $array, $id);
					
					// redirection vers la page d'accueil
					FrontController::redirect('');
				}
			}

			echo 'Y a eu un probleme!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!';
			
		}	
			echo 'Y a eu un probleme 2222222222!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!';
	}
	
	public static function copyFile($fileSource,$fileDest,$safe=true){
		$path_parts = pathinfo($fileDest);
		if(!is_file($fileSource) or !is_dir($path_parts['dirname'])){
			echo 'fauy!!!';
			return false;
		}
		if($safe){	
			$fileName = $path_parts['dirname'].'/'.$path_parts['filename'];
			$ext = $path_parts['extension'];
			$fileDest = $fileName;
			
			$fileDest = self::findUniqueFileName($fileName,$ext);
		}
		if(copy($fileSource, $fileDest.'.'.$ext)){
			return $fileDest;
		}else{
			return false;
		}
	}
	

	
	
	


}			
			




?>