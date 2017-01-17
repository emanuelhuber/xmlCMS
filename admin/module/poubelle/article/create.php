<?php

//extends ModuleSquelette
class ModuleArticleCreate extends ModuleAdmin{
	
	private $_id = '';
	private static $_pageToEdit = null;
	
	public function __construct($url, $query, $urlArray, $conf){
		parent::__construct($url, $query, $urlArray, $conf);		
		require(ROOT_PATH.$this->_config['librairie']['interstitium'].'article.class.php');
		require(ROOT_PATH.$this->_config['librairie']['interstitium'].'page.class.php');
		$path = BASE_PATH.$this->_config['path']['data'].$urlArray[1].'/'.$urlArray[2].$this->_config['ext']['data'];
		self::$myPage = new Xml_Page($path);
	}
	



	
	public function setData(){
		$this -> _templateNameModule 	= 'index';
		
		if(isset($this -> _urlQuery['title']) && !empty($this -> _urlQuery['title']) 
			&& isset($this -> _urlQuery['lg']) && !empty($this -> _urlQuery['lg']) ){
			
			// Copier le fichier xml modèle
			// et renommer le fichiers selon le nom du document
			$origine = BASE_PATH.'/datamodel/'.$this->_module.'/';
			$destination = ROOT_PATH.$this->_config['path']['data'].$this->_module.'/';
			if(is_dir($origine) && is_dir($destination)){
				
				$dirName = self::removeAccents(urldecode($this -> _urlQuery['title']), $charset='utf-8',$del=false);
				$dirName = strtolower($dirName);
				$dirName = self::removeShortWords($dirName);
				$dirDest = $destination.$dirName;
				$dirDest = self::findUniqueDirName($dirDest);
				
				/* && is_dir($destination)){ */
				
				if(mkdir($dirDest)){
				
					$fileNameIndex = '00-index.xml';
					if(is_file($origine.'new.xml') && is_file($origine.$fileNameIndex) && is_dir($dirDest)){
						
						
						// Copy '00-index.xml'
						$idFile = self::copyFile($origine.$fileNameIndex, $dirDest.'/'.$fileNameIndex);
						
						// Dans le fichier xml => donner le bon titre
						$newPage = new Xml_Article($dirDest.'/'.$fileNameIndex);
					
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
						$InnermostDir = basename(rtrim($dirDest, '/'));		// just take the last part of the dir path
						$id = $lg.','.$this->_module.','.$InnermostDir;
					
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
						
					}else{
						echo '<br/> Pas pu trouver les fichiers d origine<br/>';
						
					}
				}else{
					echo '<br/> Pas pu créer le dossier<br/>';
				}
			}else{
				echo '<br/>Le dossier d origine na pas ete trouve <br/>';
			}
		}else{
		
			echo '<br/>Pas de bonne query<br/>';
		}
	}
	
	

}			





?>