<?php

//extends ModuleSquelette
class ModuleMenuIndex extends ModuleAdmin{
	
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
		// MOVE THE MENU ITEMS!!
		if(isset($this -> _urlQuery['move']) && !empty($this -> _urlQuery['move'])
			&& isset($this -> _urlQuery['id']) && !empty($this -> _urlQuery['id'])){
			$move = $this -> _urlQuery['move'];
			$id = $this -> _urlQuery['id'];
			//echo $move;
			$menuSite -> moveNodeId($id,$move);
			FrontController::redirect('');
		// DELETE ONE LANGUAGE!!
		}elseif(isset($this -> _urlQuery['action']) && ($this -> _urlQuery['action']=='delete')
			&& isset($this -> _urlQuery['id']) && !empty($this -> _urlQuery['id'])){
			$id = $this -> _urlQuery['id'];
			if($menuSite -> deleteLanguage($id)){
				$langFile = ROOT_PATH.$this->_config['path']['data'].'squelette/squelette-'.$id.'.ini';
				if(is_file($langFile)){
					unlink($langFile);
				}
				FrontController::redirect('');
			}
		}
		// ---------------------------
		// to show the menu!
		$languages = $menuSite -> getLanguages();
	
		foreach($languages as $lg){
			$menu = $menuSite -> getMenu('',$lg['id']);
			
			self::$multiArrayToParse[] = array('arbo1' => array('NAME' => $lg['name'],
																'ID' => $lg['id'],
																'LINK_DELETE' => $this->urlAddQuery(array('id'=>$lg['id'], 'action' => 'delete'),true)));
			//	$this-> echo_r($menu);
			$block=0;
			foreach($menu as $elt){
				$toLeft = true;
				$toRight = true;
				if($elt['depth']<1){
					$toLeft = false;
					// pour la coloration des blocs
					$block++;
					$block = $block%2; 	// si pair => 1 
					
				}
					
				
				if($elt['type']=='chapter'){
					$toLeft = false;
					$toRight = false;
				}
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
				
				$name = 'menu';
				$index = $name.'1';
				$elt['depth']++;
				if($elt['depth']>2){
					for($i = 2; $i <= $elt['depth']; $i++){
						$index .= '.'.$name.$elt['depth'];
					}
				}
				$class='';
				if($elt['active'] and !$elt['hasChild']){
					$class='actifnochild';
				}elseif($elt['active']){
					$class='actif';
				}elseif($elt['childActive']){
					$class='actif';
				}
				$link = $elt['id'].$this->_config['ext']['web'];
				if($elt['type']=='chapter'){
					$link = '#';
				}
				$fix = '.html?id=';
				$indent = self::indent($elt['depth'], '&nbsp&nbsp;', $start = 1);
				$indentmod = self::indentMod($elt['depth']+2, 'arbo', $start = 2);
				if($elt['module']!='erreur'){
				/* self::$multiArrayToParse[] = array('arbo1.arbo2' => 
														array('NOM' => $elt['name'],
															'MODULE' => $elt['module'],
															'INDENT' => $indent,
															'LIEN_REMONTER' => $this->urlAddQuery(array('id'=>$elt['id'], 'move' => 'up'),true),
															'LIEN_DESCENDRE' => $this->urlAddQuery(array('id'=>$elt['id'], 'move' => 'down'),true),
															'LIEN_GAUCHE' => $this->urlAddQuery(array('id'=>$elt['id'], 'move' => 'left'),true),
															'LIEN_DROITE' => $this->urlAddQuery(array('id'=>$elt['id'], 'move' => 'right'),true),
															'GAUCHE' => 'right',
															'LIEN_APERCU' => 'fr,'.$elt['module'].',apercu'.$fix.$elt['id'],
															'LIEN_EDITER' => 'fr,'.$elt['module'].',editer'.$fix.$elt['id'],
															'LIEN_EDITER_MENU' => 'fr,menu,editer'.$fix.$elt['id'],
															'LIEN_EDITER_DESIGN' => 'fr,'.$elt['module'].',editerdesign'.$fix.$elt['id'],
															'LIEN_CREATE' => 'fr,'.$elt['module'].',create'.$fix.$elt['id'],
															'LIEN_SUPPRIMER' => 'fr,'.$elt['module'].',supprimer'.$fix.$elt['id'],
															//'LIEN_PAS_PUBLIER' => 'fr,'.$elt['module'].',publier,'.$fix.$elt['id'],
															'LIEN_PUBLIER' => 'fr,menu,publier'.$fix.$elt['id'],
															'T_PUBLIER' => $elt['publication'],
															'DROITS' => $droit_name, 
															'RUBRIQUE_TRUE' =>true,
															'DEPTH' => $elt['depth'],
															'T_IN_MENU' =>$elt['menu'],
															'T_CHILDREN' => $elt['hasChild'],
															'T_LEFT'	=> $toLeft,
															'T_RIGHT' => $toRight,
															'BLOCK'		=> $block
															)); */
				self::$multiArrayToParse[] = array('arbo1'.$indentmod => 
														array('NOM' => $elt['name'],
															'MODULE' => $elt['module'],
															'INDENT' => $indent,
															'LIEN_REMONTER' => $this->urlAddQuery(array('id'=>$elt['id'], 'move' => 'up'),true),
															'LIEN_DESCENDRE' => $this->urlAddQuery(array('id'=>$elt['id'], 'move' => 'down'),true),
															'LIEN_GAUCHE' => $this->urlAddQuery(array('id'=>$elt['id'], 'move' => 'left'),true),
															'LIEN_DROITE' => $this->urlAddQuery(array('id'=>$elt['id'], 'move' => 'right'),true),
															'GAUCHE' => 'right',
															'LIEN_APERCU' => 'fr,'.$elt['module'].',apercu'.$fix.$elt['id'],
															'LIEN_EDITER' => 'fr,'.$elt['module'].',editer'.$fix.$elt['id'],
															'LIEN_EDITER_MENU' => 'fr,menu,editer'.$fix.$elt['id'],
															'LIEN_EDITER_DESIGN' => 'fr,'.$elt['module'].',editerdesign'.$fix.$elt['id'],
															'LIEN_CREATE' => 'fr,'.$elt['module'].',create'.$fix.$elt['id'],
															'LIEN_SUPPRIMER' => 'fr,'.$elt['module'].',supprimer'.$fix.$elt['id'],
															//'LIEN_PAS_PUBLIER' => 'fr,'.$elt['module'].',publier,'.$fix.$elt['id'],
															'LIEN_PUBLIER' => 'fr,menu,publier'.$fix.$elt['id'],
															'T_PUBLIER' => $elt['publication'],
															'DROITS' => $droit_name, 
															'RUBRIQUE_TRUE' =>true,
															'DEPTH' => $elt['depth'],
															'T_IN_MENU' =>$elt['menu'],
															'T_CHILDREN' => $elt['hasChild'],
															'T_LEFT'	=> $toLeft,
															'T_RIGHT' => $toRight,
															'BLOCK'		=> $block
															));
				}
				
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