<?php
class Xml_User extends Xml_Model{
	
/* 	private $path = null;
	private $_dom = null;
	private $_xPath = null; 
	public $filetime = 0; */
	
	private $_activeUserNode = null;
	private $_activeGroupNode = null;
	
	public function __construct($urlArray, $root='base',$create = FALSE){
		parent::__construct($urlArray, $root, $create);
	}
	

	
	private static function _getUserAttributes($node){
		/* ($node -> getAttribute('logout')==1) ? $logout = true : $logout = false; */
		if($node -> getAttribute('date') == 0){
			$dateLogin = '-';
		}else{
			$dateLogin = date('d.m.Y',$node -> getAttribute('date'));
		}
		
		return array('id' => $node -> getAttribute('id'),
					'username'  => $node -> getAttribute('username'),
					'groupname'  => $node -> getAttribute('groupname'),
					'group'  => $node -> getAttribute('group'),
					'actif'  => $node -> getAttribute('actif'),
					'email'  => $node -> getAttribute('email'),
					'droits'  => $node -> getAttribute('droits'),
					'logout'  => $node -> getAttribute('logout'),
					'date'  => $dateLogin,
					'timestamp'  => $node -> getAttribute('date'),
					'password'	=>  $node -> textContent
					);
	}
	
	public function usersList(){
		$usersList = $this -> _dom  -> getElementsByTagName('user');
		$users = array();
		foreach($usersList as $user){
			$users[] = self::_getUserAttributes($user);
		}
		return $users;
	}
	
	public function getUser($id){
		//echo 'ID = '.$id;
		$query = '//contenu/users/user[@username="'.$id.'"]';		// requête
		$user = $this -> _xPath  -> query($query);
		if($user -> length > 0){
			return self::_getUserAttributes($user -> item(0));
		}else{
			return false;
		}
	}
	
	public function setUser($id){
		//echo 'ID = '.$id;
		$query = '//contenu/users/user[@id="'.$id.'"]';		// requête
		$user = $this -> _xPath  -> query($query);
		if($user -> length > 0){
			$this -> _activeUserNode = $user -> item(0);
			return true;
		}else{
			$this -> _activeUserNode = false;
			return false;
		}
	}
	public function user(){
		if($this -> _activeUserNode!=false){
			return self::_getUserAttributes($this -> _activeUserNode);
		}else{
			return false;
		}
	}
	
	public function addUser($username,$email,$group,$groupname,$password,$droits){
		$this -> _activeUserNode = $this -> _dom -> createElement('user');
		$domNodeUsers = $this -> _dom -> getElementsByTagName('users') -> item(0);
		$this -> _activeUserNode = $domNodeUsers -> appendChild($this -> _activeUserNode);

		$usersList = $this -> _dom -> getElementsByTagName('users') -> item(0) -> getElementsByTagName('user');
		$id = 1 + $usersList -> length;
		$this -> _activeUserNode -> setAttribute('id',$id);
		
		$this -> _activeUserNode -> setAttribute('email',$email);
		$this -> _activeUserNode -> setAttribute('username',$username);
		$this -> _activeUserNode -> setAttribute('group',$group);
		$this -> _activeUserNode -> setAttribute('groupname',$groupname);
		$this -> _activeUserNode -> setAttribute('droits',$droits);	
		
			$this -> _activeUserNode -> setAttribute('date','0');
			$this -> _activeUserNode -> setAttribute('logout','0');
		
		// Ecriture nouveau "password"
		$newText = $this -> _dom->createCDATASection($password);
		$this -> _activeUserNode->appendChild($newText);

		$this -> saveUser();
	}
	
	public function logOutUser($id){
		//echo 'ID = '.$id;
		$query = '//contenu/users/user[@username="'.$id.'"]';		// requête
		$user = $this -> _xPath  -> query($query);
		if($user -> length > 0){
			$user -> item(0) -> setAttribute('logout','1');
			$this -> saveUser();
			return true;
		}else{
			return false;
		}
	}	
	public function logInUser($id){
		$query = '//contenu/users/user[@username="'.$id.'"]';		// requête
		$user = $this -> _xPath  -> query($query);
		if($user -> length > 0){
			$user -> item(0) -> setAttribute('logout','0');
			$user -> item(0) -> setAttribute('date',$_SERVER['REQUEST_TIME']);
			$this -> saveUser();
			return true;
		}else{
			return false;
		}
	}
	
	public function editUser($username,$email,$group,$groupname,$password,$droits){
		if($this -> _activeUserNode!=false){
			
			$this -> _activeUserNode -> setAttribute('email',$email);
			$this -> _activeUserNode -> setAttribute('username',$username);
			$this -> _activeUserNode -> setAttribute('group',$group);
			$this -> _activeUserNode -> setAttribute('groupname',$groupname);
			$this -> _activeUserNode -> setAttribute('droits',$droits);
			
			// Ecriture nouveau "password"
			$groupName = $this -> _activeUserNode -> getElementsByTagName('name') -> item(0);
			$this -> _activeUserNode -> removeChild($this -> _activeUserNode -> firstChild);
			$newText = $this -> _dom->createCDATASection($password);
			$this -> _activeUserNode->appendChild($newText);
	
			$this -> saveUser();
			
/* 			if($this -> domGroups = self::$_cms -> openDomXml($this -> pathGroup)){
				$this -> XPathGroups =  new DOMXPath($this -> domGroups);
			} */		
		}else{
			
			return false;
		}
	}
	
	public function deleteUser(){
		//$oldchapter = $this -> _dom->removeChild($this -> _activeUserNode);
		
		$this -> deleteNode($this -> _activeUserNode);
		// Reinitialisation de l'ID
		$usersList = $this -> _dom ->  getElementsByTagName('user');
		foreach($usersList as $i => $usr){
			$usr -> setAttribute('id',$i);
		}
		$this -> saveUser();
	}
	
	public function saveUser(){
		self::saveXmlFile($this -> _dom, $this -> path);
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
	
	
	
	// USER
	/* $domPathUser = ROOT_PATH.$this->_config['path']['data'].'/login/connection.xml';						
	if($userDom = self::openDomXml($domPathUser)){
		$userXPathDom =  new DOMXPath($userDom);
	} */

	




}



?>