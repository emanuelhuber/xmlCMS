<?php

//extends ModuleSquelette
class ModuleAdminDictionnaire extends ModuleAdmin{
	
	public function __construct($url, $query, $urlArray, $conf){
		parent::__construct($url, $query, $urlArray, $conf);		
		require(ROOT_PATH.$this->_config['librairie']['interstitium'].'page.class.php');
		self::$myPage = new Xml_Page($urlArray);
	}
	

	
	public function setData(){
		$this->_templateNameModule = 'page';
		$this -> formTarget($_SERVER['REQUEST_URI'], 'FICHIER_CIBLE');

		self::$arrayToParse['CURRENT_CRUMB'] = self::$arrayToParse['INFO_TITRE'];
		
		$langFolder = ROOT_PATH.$this->_config['path']['data'].'squelette/';
		$dossier = opendir($langFolder);
		
		$tags = array();	// va contenir les clefs uniques (toutes langues comprises)
		$langues = array();	// liste des différentes langues
		$pahtFiles = array();	// liste des fichiers de langue
		
		if(isset($this -> _urlQuery['lg']) && !empty($this -> _urlQuery['lg'])){
			$myLangue = trim($this -> _urlQuery['lg']);
		}else{
			$myLangue = false;
		}
		
		while ($fichier = readdir($dossier)) {
			$path = $langFolder.$fichier;
			// si c'est un fichier
			if($fichier != "." && $fichier != ".." && !is_dir($path)) {
				$extension = pathinfo($fichier, PATHINFO_EXTENSION); 
				if($extension == 'ini'){
					$dic = parse_ini_file($path, false);
					$pahtFiles[] = $path;
					$tags = array_merge($tags,array_keys($dic));
					self::$arrayToParse['CONTENT'] = trim(file_get_contents($langFolder.$fichier));
					$file = explode('-', substr($fichier, 0, -4));
					$langues[] = $file[1];	// la langue du fichier
					$active = '';
					if($myLangue == false){
						$active = 'selected';
						$myLangue = $file[1];
					}elseif($file[1] == $myLangue){
						$active = 'selected';
					}
					self::$multiArrayToParse[] = array('langues' => array('ID' => $file[1],
																		  'LINK' => $this->urlAddQuery(array('lg'=>$file[1])),
																		  'ACTIVE' => $active));
				}
			}
		}
		
		$tags = array_unique($tags);
		
		
		// AJOUTER UN TAG !
		if(isset($_POST) and !empty($_POST)){
			if(isset($_POST['tag']) && !empty($_POST['tag'])){
				$tag = strtoupper(trim($_POST['tag']));
				$tag = $this -> removeAccents($tag);
				$tag = preg_replace('/([^a-z0-9]+)/i', '_', $tag);
				$tag = str_replace(' ', '_', $tag);

			//	if(!in_array($tag, $tags)){
				foreach($pahtFiles as $pf){
					$myDic = parse_ini_file($pf, false);
					if(!isset($myDic[$tag])){
						$myDic[$tag] = 'A_TRADUIRE';
						// enregistrer!
						self::writeIni($myDic, $pf, $section = false);
					}
				}
			}
		}
		
		// SUPPRIMER UN TAG !
		if(isset($this -> _urlQuery['delete']) && !empty($this -> _urlQuery['delete'])){
			$mot = $this -> _urlQuery['delete'];
			foreach($pahtFiles as $pf){
				$myDic = parse_ini_file($pf, false);
				if(array_key_exists($mot, $myDic)){
					unset($tags[array_search($mot, $tags)]);
					unset($myDic[$mot]);
					// enregistrer!
					self::writeIni($myDic, $pf, $section = false);
				}
			}
		}
		
		// nom du fichier sans l'attribut de langue;
		$filename = $file[0].'-'.$myLangue.'.ini';
		$path = $langFolder.$filename;
		
		if(is_file($path)){
			$dic = parse_ini_file($path, false);
			// ecrire le fichier
			if(isset($_POST) and !empty($_POST)){
				$content = trim(file_get_contents($path));
				if(isset($_POST['def']) && is_array($_POST['def'])){
					$postDef = $_POST['def'];
					$dic = array_combine($tags,$postDef);
				}
			}
			
			$this -> writeIni($dic, $path, $section = false);
			
			foreach($dic as $key => $val){
				self::$multiArrayToParse[] = array('mots' => array('TAG' => $key,
																   'DEF' => $val,
																   'LINK_DELETE' => $this->urlAddQuery(array('delete'=>$key))));	
				
			}
		}
		

		
	}
	
	
	public static function removeAccents($str, $charset='utf-8',$del=true){
		$str = htmlentities($str, ENT_NOQUOTES, $charset);
		$str = preg_replace('#\&([A-za-z])(?:acute|cedil|circ|grave|ring|tilde|uml)\;#', '\1', $str);
		$str = preg_replace('#\&([A-za-z]{2})(?:lig)\;#', '\1', $str); // pour les ligatures e.g. '&oelig;'
		if($del){
			$str = preg_replace('#\&[^;.]+\;#', '', $str); // supprime les autres caractères
		}else{
			$str = preg_replace('/([^a-z0-9]+)/i', '-', $str);
			$str = trim($str,'-');	// Supprimer les tirets en début et fin
		}
		return $str;
	}


}
?>