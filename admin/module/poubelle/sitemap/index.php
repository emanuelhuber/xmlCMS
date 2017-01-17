<?php

//extends ModuleSquelette
class ModuleSitemapIndex extends ModuleAdmin{
	
	public function __construct($url, $query, $urlArray, $conf){
		parent::__construct($url, $query, $urlArray, $conf);		
		require(ROOT_PATH.$this->_config['librairie']['interstitium'].'page.class.php');
		$path = BASE_PATH.$this->_config['path']['data'].$urlArray[1].'/'.$urlArray[2].$this->_config['ext']['data'];
		self::$myPage = new Xml_Page($path);
	}
	
/* 	public function setBreadCrumbs(){
		 parent::setBreadCrumbs();
			self::$arrayToParse['CURRENT_CRUMB'] = $this -> _activNode -> getAttribute('nom');	
	} */
	
	public function setData(){
		$this->_templateNameModule = 'page';
				
		self::$arrayToParse['CURRENT_CRUMB'] = self::$arrayToParse['INFO_TITRE'];
		
		self::$arrayToParse['LIEN_CREER_PAGE'] = 'fr,menu,creer.html';
		self::$arrayToParse['LIEN_LANGUE'] = 'fr,menu,langue.html';
		
		$path = ROOT_PATH.$this->_config['path']['arborescence'];
		$id = 	null;
		$lg = 	'fr';
		$menuSite = new Xml_Menu($path, $id, $lg);
		
		
		// ---------------------------
		// to show the menu!
		$languages = $menuSite -> getLanguages();
	
		foreach($languages as $lg){
			$menu = $menuSite -> getMenu('',$lg['id']);
			
			/* self::$multiArrayToParse[] = array('arbo1' => array('NAME' => $lg['name'],
																'ID' => $lg['id'],
																'LINK_DELETE' => $this->urlAddQuery(array('id'=>$lg['id'], 'action' => 'delete'),true))); */
			//	$this-> echo_r($menu);
			$block=0;
			foreach($menu as $elt){
				$droit_name = '';
				if($elt['rights'] < 0){
					$droit_name = '-';
				}else{
					$rights = $this -> _groups -> rightsList();
					foreach($rights as $right){
						if(intval($elt['rights']) == intval($right['right'])){
							$droit_name = $right['name'];
						}
					}
				}
				
				
				if($elt['module']!='chapitre' && $elt['module']!='rubrique'){
					if(is_file($classPath = ROOT_PATH.$this -> _config['path']['module'].$elt['module'].$this -> _config['ext']['class'])){
						require_once($classPath);
							echo 'yes';
						
						//$className =  $elt['module'];
						$className = str_replace("-", " ", $elt['module']);
						$forbiddenCharacters = array(" ", ".", "/", "\\", "*", "A", "E", "I", "O", "U");
						// la première lettre de chaque mot est passée en majuscule et on concatène les mots
						$className = str_replace($forbiddenCharacters, "", ucwords($className));
						// on ajoute le préfixe "Module"
						$className = 'Module'.$className;
						
						if(class_exists($className)){	// si la classe existe, on tente d'intancier un objet...	
							$myModule[$elt['module']] = new $className('url',null,explode(',',$elt['id']),$this->_config);
							$pluginList[$className] = $myModule[$elt['module']] -> listPlug();
						}
					
					
						self::$multiArrayToParse[] = array('sitemap' => 
															array('NOM' 		=> $elt['name'],
																'MODULE' 		=> $elt['module'],
																'T_PUBLIER' 	=> $elt['publication'],
																'DROITS' 		=> $droit_name, 
																'RUBRIQUE_TRUE' => true,
																'DEPTH' 		=> $elt['depth'],
																'T_IN_MENU' 	=> $elt['menu'],
																'TITRE'			=> 'titre'
																));
					}
				}
				
				/* if($elt['module']!='chapitre' && $elt['module']!='rubrique'){
					//if(is_file($classPath = ROOT_PATH.$this -> _config['path']['module'].$elt['module'].$this -> _config['ext']['class'])){
					if(is_file($classPath = ROOT_PATH.$this -> _config['librairie']['interstitium'].$elt['module'].$this -> _config['ext']['lib'])){
						require_once($classPath);
						echo $elt['module'].'<br/>';
						
						//$className =  $elt['module'];
						$className = str_replace("-", " ", $elt['module']);
						$forbiddenCharacters = array(" ", ".", "/", "\\", "*");
						// la première lettre de chaque mot est passée en majuscule et on concatène les mots
						$className = str_replace($forbiddenCharacters, "", ucwords($className));
						// on ajoute le préfixe "Module"
						$className = 'Xml_'.$className;
						
						if(class_exists($className)){	// si la classe existe, on tente d'intancier un objet...	
							$myModule[$elt['module']] = new $className();
							$pluginList[$className] = $myModule[$elt['module']] -> listPlug();
						}else{
							echo $className.' ---- ';
						}
					
					
						self::$multiArrayToParse[] = array('sitemap' => 
															array('NOM' 		=> $elt['name'],
																'MODULE' 		=> $elt['module'],
																'T_PUBLIER' 	=> $elt['publication'],
																'DROITS' 		=> $droit_name, 
																'RUBRIQUE_TRUE' => true,
																'DEPTH' 		=> $elt['depth'],
																'T_IN_MENU' 	=> $elt['menu'],
																'TITRE'			=> 'titre'
																));
					}else{
						//echo $classPath.' ---- ';
					}
				} */
				
				
			}
		} 
	}
				
	
	
	private static function indent($n, $string, $start = 1){
		if($n != $start){
			  for($i = $start; $i < $n; $i++){
				$string .= $string;
			  }
			return $string;
		}else{
			return '';
		}
	}
	private static function indentMod($n, $string, $start = 1){
		if($n != $start){
				//$string2 = $string.$start;
				$string2 = '';
			  for($i = $start; $i < $n; $i++){
				$string2 = $string2.'.'.$string.$i;
			  }
			return $string2;
		}else{
			return '';
		}
	}
	

}
?>