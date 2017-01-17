<?php
class Xml_Menu extends Xml_Model{
	
	
/* 	private $path = null;
	private $_dom = null;
	private $_xPath = null; 
	public $filetime = 0; */
	// private $_id = '';
	private $_lg = '';
	//private $_activNode = null;
	private static $_menu = array();
	private static $_depth = 0;
	
	//protected static $arboPath	= '/data/arborescence.xml'; 
	
	public function __construct($urlArray, $root='base'){
		parent::__construct($urlArray, $root);
		if(!empty($urlArray) && is_array($urlArray)){
			$this -> idPage = 	$urlArray[0].','.$urlArray[1].','.$urlArray[2];
			$this -> _lg = 	$urlArray[0];
		}
		//$this -> setActivNode();
	}
	
	protected function _getPath($urlArray,$root){
		if($root == 'base'){ 
			$this -> path = BASE_PATH.'/data/arborescence.xml';
			//echo $this -> path;
		}else{
			$this -> path = ROOT_PATH.'/data/arborescence.xml';
		}
	}
	
	public function deleteNodeId($id, $withChildren=false){
		$query = '/menu/langue//*[@id="'.$id.'"]';
		$item = $this->_xPath -> query($query);
		//$pageMenu = $menuXPathDom -> query($query);	// DomNodeList
		if($item->length>0){
			$this -> deleteNode($item->item(0),$withChildren);
			self::saveXmlFile($this -> _dom,$this->path);
		}else{
			return false;
		}
	}
	
	public function moveNodeId($id,$direction){
		$query = '/menu/langue//*[@id="'.$id.'"]';
		$items = $this->_xPath -> query($query);
		if($items->length>0){
			// seules les "rubriques" ainsi que les "chapitres" peuvent avoir des enfants!
			$itemBefore = $items -> item(0) -> nextSibling;
			while($itemBefore!=null and $itemBefore -> nodeType != XML_ELEMENT_NODE){
					$itemBefore = $itemBefore -> nextSibling;
			}
			if($itemBefore==null){
				$module = '';
			}else{
				$module = $itemBefore->getAttribute('module');
			}	
			
			if(($direction == 'right' && ($module =='rubrique'
				or $module =='chapter'))
				or $direction == 'left' or $direction == 'up' or $direction == 'down'){
				self::moveNode($items->item(0),$direction);
				self::saveXmlFile($this -> _dom,$this->path);
			}else{
				/* self::moveNode($item->item(0),$direction);
				self::saveXmlFile($this -> _dom,$this->path); */
			}
			
		}else{
			//echo 'CA MARCHE';
		}
	}
	
	public function setActivNode(){
		$query = '/menu//page[@id="'.$this -> idPage.'"]';		// We starts from the root element
		$reponse = $this->_xPath -> query($query);	// DomNodeList
		if($reponse->length>0){	// si il y a au moins 1 noeud dans le menu
			//$this -> _activNode = $reponse -> item(0);
			return $reponse -> item(0);
		}else{
			//echo 'pas dans le menu';
			//$this -> _activNode = null;
			return null;
		}
	}
	
	public function getMenuItem($id){
		$query = '/menu/langue//*[@id="'.$id.'"]';
		$item = $this->_xPath -> query($query);
		//$pageMenu = $menuXPathDom -> query($query);	// DomNodeList
		if($item->length>0){
			$item = $item -> item(0);
			return array('id' => $item -> getAttribute('id'),
						 'module' => $item -> getAttribute('id'),
						 'nom' => $item -> getAttribute('nom'),
						 'soeur' => $item -> getAttribute('soeur'),
						 'menu' => $item -> getAttribute('menu'),
						 'publication' => $item -> getAttribute('publication'),
						 'droits' => $item -> getAttribute('droits')
						 );
		}else{
			return false;
		}
		
	}
	
	public function setMenuItemAttribute($id,$array){
		$query = '/menu/langue//*[@id="'.$id.'"]';
		$item = $this->_xPath -> query($query);
		//$pageMenu = $menuXPathDom -> query($query);	// DomNodeList
		if($item->length>0){
			$item = $item -> item(0);
			foreach($array as $key => $value){
				$item -> setAttribute($key,$value);
			}
			self::saveXmlFile($this -> _dom,$this->path);
		}
	}
	
	public function addMenuItem($lg, $array=array(),$id,$name = 'page'){
		$query = '/menu/langue[@id="'.$lg.'"]';
		//echo $query;
		$mother = $this->_xPath -> query($query);
		//$pageMenu = $menuXPathDom -> query($query);	// DomNodeList
		if($mother->length>0){
			$mother = $mother -> item(0);
			$node = $this -> _dom -> createElement($name);
			$newnode = $mother->appendChild($node);
			$newnode -> setAttribute('id', $id);
			foreach($array as $key => $value){
				$newnode -> setAttribute($key, $value);
			}
			self::saveXmlFile($this -> _dom,$this->path);
			return true;
		}else{
			echo 'NNNULLLL';
			return false;
		}
	}
	
	public function deleteLanguage($id){
		$query = '/menu/langue[@id="'.$id.'"]';
		$mother = $this->_xPath -> query($query);
		// on supprime la langue que si toutes ses pages sont supprimées
		if($mother->length > 0){
			$item = $mother->item(0);
			if($item ->hasChildNodes()){
				return false;
			}else{
				$this -> deleteNode($item,true);
				self::saveXmlFile($this -> _dom,$this->path);
				self::deleteDictionnary($id);
				return true;
			}
		}
	}
	public function addLanguage($name, $idLangue){
		$query = '/menu';
		$mother = $this->_xPath -> query($query);
		//$pageMenu = $menuXPathDom -> query($query);	// DomNodeList
		if($mother->length>0){
			$mother = $mother -> item(0);
			$node = $this -> _dom -> createElement('langue');
			$newnode = $mother->appendChild($node);
			$newnode -> setAttribute('id', htmlentities($idLangue, ENT_QUOTES, "UTF-8"));
			$newnode -> setAttribute('nom', htmlentities($name, ENT_QUOTES, "UTF-8"));
			/* foreach($array as $key => $value){
				$newnode -> setAttribute($key, $value);
			} */
			self::saveXmlFile($this -> _dom,$this->path);
			
			self::createDictionnary($idLangue);
			
			
			return true;
		}else{
			
			return false;
		}
	}
	public function getLanguages(){
		//self::$arrayToParse['LANGUE_ABR'] 	=	$this -> _lg;
		$query = '/menu//langue';		// We starts from the root element
		$langues = $this->_xPath -> query($query);
		$lgArray = array();
		foreach($langues as $lang){
			// si une page soeur est définie
			$activNode = $this -> setActivNode();
			if($activNode != null && $activNode->getAttribute('soeur-'.$lang->getAttribute('id'))){
				$link = $ctivNode -> getAttribute('soeur-'.$lang->getAttribute('id'));
			// sinon on prend la première page de la langue itérée
			}else{
			
				$firstNode = $lang -> getElementsByTagName('page');
				if($firstNode -> length >0){
					$link = $firstNode -> item(0) -> getAttribute('id');
				}else{
					$link = false;
				}
			}
			// langue en cours
			$activ = false;
			if($lang->getAttribute('id') == $this -> _lg){
				$activ = true;
			}
			$lgArray[] = array('name' => $lang->getAttribute('nom'),
								'active' => $activ,
								'id' 	=> $lang->getAttribute('id'),
								'link'	=> $link
								);	
		}
		return $lgArray;
	}
	
	public function getBreadCrumbs(){
		$query = '//page[@id="'.$this -> idPage.'"]/ancestor::*';			// We starts select all the ancestor of the current page
		$ancestors = $this->_xPath -> query($query);
		// $lg = $ancestors ->item(1)->childNodes->item(1);
		$breadCrumbs = array();
		foreach($ancestors as $an){
			if($an->hasChildNodes()){
				$children = $an -> childNodes;
				$page = $an -> getElementsByTagName('page');
				if($page -> length > 0){
					$breadCrumbs[] = array('id' 	=> $an -> getAttribute('id'),
								   'name'	=> $an -> getAttribute('nom'),
								   'type' 	=> $an -> nodeName,
								   'module' => $an -> getAttribute('module'),
								   'link'	=> $page -> item(0) -> getAttribute('id')
									);
				}
			}
		} 
		return $breadCrumbs;
	}
	
	public function getChapters(){
		$myChapter = array();
		$chapterArray = array();
		$menuArray = array();

		// liste des chapitres de la langue contenant au moins une page
		// qui soit dans le menu et publier
		$query = '//langue[@id="'.$this -> _lg.'"] //chapter[descendant::page[@publication="1" and @menu="1"]]';	
		//echo $query;
		$chapters = $this->_xPath -> query($query);
		// si le chapitre contient des pages, alors
		if($chapters -> length > 0){
			//echo 'YES!!!';
			// le chapitre correspondant à la page active
			$activChapName = '';
			$query = '//langue[@id="'.$this -> _lg.'"]/chapter[descendant::page[@id="'.$this -> idPage.'"]]';	
			$activChapters = $this->_xPath -> query($query);
			// si il y a un chapitre correspondant à la page active
			if($activChapters -> length ==1){
				$activChapter = $activChapters -> item(0);
				$link = $activChapter -> getAttribute('id');
				$activChapName = $activChapter -> getAttribute('nom');
				$id = explode(',',$link);
				$myChapter = array( 'link'  => $link ,
									'id' 	=> $id[2],
									'name'  => $activChapName
									);
				// le menu = les fils du chapitre actif
				$menuArray = $this -> getMenu($activChapter -> childNodes);
			}else{
				// le menu = les fils du premier chapitre
				$menuArray = $this -> getMenu($chapters -> item(0) -> childNodes);
			}
			foreach($chapters as $chap){
				// pour le liens du chapitre, on prend la première page qui soit dans le menu et publier
				$query = '//chapter[@nom="'.$chap->getAttribute('nom').'"]//page[@publication="1" and @menu="1"]';	
				$firstPage = $this->_xPath -> query($query);
				if($firstPage -> length > 0){
					$activ = false;
					if($activChapName == $chap->getAttribute('nom')){
						$activ = true;
					}
					$chapterArray[]= array('link' => $firstPage -> item(0)->getAttribute('id') ,
										   'name'  => $chap->getAttribute('nom'),
										   't_class' => $activ);
				}
			}
		}else{
			// si il n'y a pas de chapitre dans la langue, on renvoit
			// les fils de la langue
			$query = '//langue[@id="'.$this -> _lg.'"] /*';	
			$menu = $this->_xPath -> query($query);
			if($menu -> length > 0){
				$menuArray=$this -> getMenu($menu);
			}
		}
		return array('chapters' => $chapterArray,
					 'menu'		=> $menuArray,
					 'myChapter' => $myChapter);		
	}
	
/* 	private function isAccessAuthorized($pageRight){
		//return ($this -> _userRight & pow(2, $pageRight)) or pageRight<0);
	} */
	
	public function getMenu($menu, $lg=''){
		if(!empty($lg)){
			self::$_menu = array();	// Réinitialise l'attribut
			$query = '//langue[@id="'.$lg.'"]';			// We starts from the root element
			$langue = $this->_xPath -> query($query);
			$menu = $langue -> item(0) -> childNodes;
		}

		foreach($menu as $elt){			// DomElement
			self::$_depth = 0;
			$this->parcourirMenu($elt);
		}
		return self::$_menu;
	}
	
	private function parcourirMenu($noeud){
		if($noeud->nodeType == XML_ELEMENT_NODE){
			// fonction pour créer automatiquement l'attribut de bloc
			// du template en fonction de la profondeur du menu.
			// 1 => menu1, 2=>menu1.menu2, 3=> menu1.menu2.menu2
			//$index = $this -> blockName('menu',$depth);
			$hasChild = false;
			$active = false;
			$childActive = false;
			$areChildrenPub = false;
			if($noeud->hasChildNodes()){
				$hasChild = true;
			}
			/* DETERMINER SI LE NOEUD EST ACTIF */
				// si le noeud est actif
			if($noeud->getAttribute('id') == $this -> idPage){
				$active = true;
				// si le noeud a des enfants
			}elseif($hasChild){
				$query = '//*[@id="'.$noeud -> getAttribute('id').'"]//page[@id="'.$this -> idPage.'"]';			// We starts from the root element
				$activChild = $this->_xPath -> query($query);
				//si un de ses petits fils est actif
				if($activChild->length > 0){
					$childActive = true;
				}
				// si le noeud est le fils du chapitre actif
			}elseif($noeud-> parentNode-> nodeName == 'chapter' && $noeud-> parentNode->getAttribute('id') == $this -> idPage){
				$active = true;
			}
			// test dans le cas d'une rubrique si la rubrique a des enfants et si ses enfants sont publiés
			if($hasChild){
				$query = '//rubrique[@id="'.$noeud -> getAttribute('id').'"]/*[@publication="1"]';			// We starts from the root element
				$publChildren = $this->_xPath -> query($query);
				if($publChildren -> length > 0){
					$areChildrenPub = true;
				}
			}
			//if($noeud -> nodeName != 'rubrique' Or ($noeud -> nodeName == 'rubrique' && $hasChild && $areChildrenPub)){
				//if($noeud -> nodeName == 'chapter') self::$_depth--;
				self::$_menu[] = array('name' 		=> $noeud -> getAttribute('nom'),
									  'type' 		=> $noeud -> nodeName,
									  'id'   		=> $noeud -> getAttribute('id'),
									  'module' 		=> $noeud -> getAttribute('module'),
									  'depth' 		=> self::$_depth,
									  'hasChild' 	=> $hasChild,
									  'active' 		=> $active,
									  'childActive' => $childActive,
									  'childPubl'	=> $areChildrenPub,
									  'menu'		=> $noeud -> getAttribute('menu'),
									  'publication'	=> $noeud -> getAttribute('publication'),
									  'rights'		=> $noeud -> getAttribute('droits')
									  );
			//}
	
			// si le noeud a des fils
			if($hasChild){
				self::$_depth++;
				$enfants = $noeud->childNodes;
				foreach($enfants as $enfant){	// on parcourt les enfants...
				  $this->parcourirMenu($enfant);
				}
				self::$_depth--;
			}
		}
	}
	
/* 	public function blockName($name,$depth){
		$blName = $name.$depth;
		if($depth==1){
			return $blName;
		}elseif($depth > 1){
			$blName = $name.'1';
			for($i = 2; $i <= $depth; $i++){
				$blName .= '.'.$name.$depth;
			}
			return $blName;
		}else{
			return false;
		}
		
	} */
	
	
	
	
	

}
?>