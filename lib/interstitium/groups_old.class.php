<?php
class Xml_Group extends Xml_Model{
	
/* 	private $path = null;
	private $_dom = null;
	private $_xPath = null; 
	public $filetime = 0; */
	
	private $_activeGroupNode = null;
	
	public function __construct($urlArray, $root='base',$create = FALSE){
		parent::__construct($urlArray, $root, $create);
	}
	
	private static function _getGroupAttributes($node){
		return array('id' => $node -> getAttribute('id'),
								'right'  => $node -> getAttribute('right'),
								'name'	=>  $node -> getElementsByTagName('name') -> item(0)->nodeValue,
								'description' => $node -> getElementsByTagName('description') -> item(0)->nodeValue);
	}
	
	public function groupsList(){
		$groupsList = $this -> _dom -> getElementsByTagName('groups') -> item(0) -> getElementsByTagName('grp');
		$groups = array();
		foreach($groupsList as $grp){
			$groups[] = self::_getGroupAttributes($grp);
					/* array('id' => $grp -> getAttribute('id'),
								'right'  => $grp -> getAttribute('right'),
								'name'	=>  $grp -> getElementsByTagName('name') -> item(0)->nodeValue,
								'description' => $grp -> getElementsByTagName('description') -> item(0)->nodeValue); */
		}
		return $groups;
	}
	
	public function setGroup($id){
		$query = '//groups/grp[@id="'.$id.'"]';		// requête
		$group = $this -> _xPath  -> query($query);
		if($group -> length > 0){
			$this -> _activeGroupNode = $group -> item(0);
			return true;
		}else{
			$this -> _activeGroupNode = false;
			return false;
		}
	}
	
	public function group(){
		if($this -> _activeGroupNode!=false){
			return self::_getGroupAttributes($this -> _activeGroupNode);
		}else{
			return false;
		}
	}
	/* public function group($id){
		$query = '//groups/grp[@id="'.$id.'"]';		// requête
		$group = $this -> _xPath  -> query($query);
		if($group -> length > 0){
			$this -> _activeGroupNode = $group -> item(0);
			$group = array('id' => $this -> _activeGroupNode -> getAttribute('id'),
						'right'  => $this -> _activeGroupNode -> getAttribute('right'),
						'name'	=>  $this -> _activeGroupNode -> getElementsByTagName('name') -> item(0)->nodeValue,
						'description' => $this -> _activeGroupNode -> getElementsByTagName('description') -> item(0)->nodeValue);
		}else{
			$this -> _activeGroupNode = false;
			$group = false;
			echo 'pas trouve id';
		}
		return $group;
	} */
	
	public function addGroup($name,$right,$description){
		$this -> _activeGroupNode = $this -> _dom -> createElement('grp');
		$domNodeGroups = $this -> _dom -> getElementsByTagName('groups') -> item(0);
		$this -> _activeGroupNode = $domNodeGroups -> appendChild($this -> _activeGroupNode);
		
		//$this -> _activeGroupNode -> setAttribute('id','a'.($this -> _dom -> length - 1));
		
		
		$this -> _activeGroupNode -> setAttribute('right',$right);
		
		// Ecriture nouveau "nom de groupe"
		$groupName = $this -> _dom -> createElement('name');
		$groupName = $this -> _activeGroupNode -> appendChild($groupName);
		
		$newText = $this -> _dom->createCDATASection($name);
		$groupName->appendChild($newText);
		
		// Ecriture nouvelle "description de groupe"
		$groupDescription = $this -> _dom -> createElement('description');
		$groupDescription = $this -> _activeGroupNode -> appendChild($groupDescription);
		$newText = $this -> _dom->createCDATASection($description);
		$groupDescription->appendChild($newText);
		
		// Reinitialisation de l'ID
		$groupsList = $this -> _dom -> getElementsByTagName('groups') -> item(0) -> getElementsByTagName('grp');
		foreach($groupsList as $i => $grp){
			$grp -> setAttribute('id','a'.$i);
		}
		
		
		$this -> saveGroup();
	}
	
	public function editGroup($name,$right,$description){
		if($this -> _activeGroupNode!=false){
			$this -> _activeGroupNode -> setAttribute('right',$right);
			
			// Ecriture nouveau "nom de groupe"
			$groupName = $this -> _activeGroupNode -> getElementsByTagName('name') -> item(0);
			$groupName->removeChild($groupName->firstChild);
			$newText = $this -> _dom->createCDATASection($name);
			$groupName->appendChild($newText);
			
			// Ecriture nouvelle "description de groupe"
			$groupDescription = $this -> _activeGroupNode -> getElementsByTagName('description') -> item(0);
			$groupDescription->removeChild($groupDescription->firstChild);
			$newText = $this -> _dom->createCDATASection($description);
			$groupDescription->appendChild($newText);
			
			// Reinitialisation de l'ID
			/* foreach($groups as $i => $grp){
				$group -> setAttribute('id','a'.$i);
			} */
			
			$this -> saveGroup();
			
/* 			if($this -> _dom = self::$cms -> openDomXml($this -> path)){
				$this -> _xPath =  new DOMXPath($this -> _dom);
			} */		
		}else{
			
			return false;
		}
	}
	
	public function deleteGroup(){
		$this -> deleteNode($this -> _activeGroupNode);
		// Reinitialisation de l'ID
		$groupsList = $this -> _dom -> getElementsByTagName('groups') -> item(0) -> getElementsByTagName('grp');
		foreach($groupsList as $i => $grp){
			$grp -> setAttribute('id','a'.$i);
		}
		$this -> saveGroup();
	}
	
	public function saveGroup(){
		self::saveXmlFile($this -> _dom, $this -> path);
	}
	
	public function rightsList($all=false){
			if($all){
				$query = '//contenu/rights/item';
			}else{
				$query = '//contenu/rights/item[@activated="1"]';
			}
			$domRights = $this -> _xPath-> query($query);	// DomNodeList
			if($domRights -> length>0){	// si il y a au moins 1 noeud
				// ($userRight & pow(2, $noeud->getAttribute('droits')))
				$rights = array();
				foreach($domRights as $rig){
					$activated = false;
					if($this -> _activeGroupNode!=false){
						if(pow(2, $rig -> getAttribute('id')) &  $this -> _activeGroupNode -> getAttribute('right')){
							$activated = true;
						}
					}elseif($rig -> getAttribute('activated')=='1'){
						$activated = true;
					}
					$rights[]= array('id' 	=> $rig -> getAttribute('id'),
								   'name'	=>  $rig -> getElementsByTagName('name') -> item(0)->nodeValue,
								   'description' => $rig -> getElementsByTagName('description') -> item(0)->nodeValue, 
								   'activated'  => $activated,
								   'right'	=>  $rig -> getAttribute('id')
								   );
				}
				return $rights;
			}else{
				return false;
			}
	
	}
	
	public function rightEdit($activateds,$names,$descriptions){
		$rightsList = $this -> _dom -> getElementsByTagName('rights') -> item(0) -> getElementsByTagName('item');
		foreach($names as $i => $name){
			(isset($activateds[$i]) && $activateds[$i]== 'on') ? $activ = 1 : $activ = 0;			
			if($i>=0 && $i <=30){		// nombre de droits limités à 31 (cf. "bits")
				$noeud = $rightsList -> item($i);

				$noeud -> setAttribute('activated',$activ);
				// on enregistre les noms et descriptions
				$noeudName = $noeud -> getElementsByTagName('name') -> item(0);
				$noeudName->removeChild($noeudName->firstChild);
				$newText = $this -> _dom->createCDATASection($name);
				$noeudName->appendChild($newText);

				$noeudDescription = $noeud -> getElementsByTagName('description') -> item(0);
				$noeudDescription->removeChild($noeudDescription->firstChild);
				$newText = $this -> _dom->createCDATASection($descriptions[$i]);
				$noeudDescription->appendChild($newText);
			}else{
				echo 'erreur';
			}
		}
		
			
			$this -> saveGroup();
		
	
	}
	

}



?>