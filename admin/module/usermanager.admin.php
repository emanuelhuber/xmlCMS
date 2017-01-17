<?php

/*
TODO TODO
Créer des fonctions pour réduire les redondances dans le code..

*/

//extends ModuleSquelette
class ModuleAdminUsermanager extends ModuleAdmin{
	
	public function __construct($url, $query, $urlArray, $conf){
		parent::__construct($url, $query, $urlArray, $conf);		
		require(ROOT_PATH.$this->_config['librairie']['interstitium'].'page.class.php');
		//$path = BASE_PATH.$this->_config['path']['data'].$urlArray[1].'/'.$urlArray[2].$this->_config['ext']['data'];
		self::$myPage = new Xml_Page($urlArray);
	}
	
	



	
	public function setData(){
		self::$arrayToParse['CURRENT_CRUMB'] = self::$arrayToParse['INFO_TITRE'];
		$this->_templateNameModule = 'page';
		
		switch($this -> _action){
			case 'rights':
				$this -> selectRights();
				break;
			case 'groups':
				$this -> selectGroups();
				break;
			case 'users':
				$this -> selectUsers();
				break;
			default:
				echo 'Pas d action définie!!!! Erreur!!!';
				
				break;
		}
	}	
	
	public function selectGroups(){
		//require_once(ROOT_PATH.$this->_config['librairie']['interstitium'].'users.class.php');
		//$path = ROOT_PATH.$this->_config['path']['data'].'/login/groups.xml';
		//$users = new Xml_User(array('fr','login','users'),$root="root");
		//replace $users by $this -> _userObject
		
		$actionQuery = false;
		if(isset($this -> _urlQuery['action']) &&  !empty($this -> _urlQuery['action'])){
			$actionQuery = $this -> _urlQuery['action'];
		}
		$id = false;
		if(isset($this -> _urlQuery['id']) && !empty($this -> _urlQuery['id'])){
			$id = $this -> _urlQuery['id'];
		}
		
		self::$arrayToParse['LINK_GROUP'] = $this -> _url.$this->_config['ext']['web'];
		self::$arrayToParse['LINK_ADD_GROUP'] = $this -> _url.$this->_config['ext']['web'].'?action=add';
		
		$myGroup = $this -> _userObject -> setGroup($id);

		switch($actionQuery){			
			case 'edit':	// need a right ID
				$this->_templateNameModule = 'edit';
				
				if(isset($_POST) and !empty($_POST)){
					// TRAITEMENT DU FORMULAIRE (SAUVEGARDE DES DONNEES
					$dataForm = $_POST;
					// Ecriture des nouveaux droits
					(isset($dataForm['activated'])) ? $activateds = $dataForm['activated'] : $activateds = null;
					$newGroupRight = 0;
					if(is_array($activateds)){
						foreach($activateds as $i => $activated){
							$newGroupRight = $newGroupRight + pow(2, $i);
						}
					}
					
					$this -> _userObject -> editGroup($dataForm['name'],$newGroupRight,$dataForm['description']);
					
					self::$multiArrayToParse[]=array('info'=>array( 'DATE'	=> date('l j  F Y H:i:s'))); 
				}else{
					
				}

				$myGroup = $this -> _userObject -> group();
				$this -> parseArray($myGroup,'form_');
				
				$this -> formTarget($this -> _url.$this->_config['ext']['web'].'?id='.$myGroup['id'].'&action=edit', 'FICHIER_CIBLE');
				//$this -> cibleFormulaire($this -> _url.$this->_config['ext']['web'].'?id='.$myGroup['id'].'&action=edit', 'FICHIER_CIBLE');
				
				break;
			case 'delete':  // need a right ID
				$myGroup = $this -> _userObject -> group();
				$this -> parseArray($myGroup,'form_');
				if(empty($myGroup)){
					break;
				}
				
				/* self::$arrayToParse['RIGHT'] = $myGroup['right'];
				self::$arrayToParse['GRP_NAME'] = $myGroup['name'];
				self::$arrayToParse['GRP_DESCRIPTION'] = $myGroup['description']; */
				
				if(isset($_POST) and !empty($_POST)){
					if(isset($_POST['ok']) && $_POST['ok'] == 'ok'){
						$this -> _userObject -> deleteGroup(); 
						// ET ON AFFICHE LA PAGE D'ACCUEIL
						self::$multiArrayToParse[]=array('info'=>array( 'DATE'	=> date('l j  F Y H:i:s'))); 
						$this->_templateNameModule = 'page';
						break;
					}else{
						$this->_templateNameModule = 'page';
						break;
					}
				}else{
					$this->_templateNameModule = 'delete';
					$this -> formTarget($this -> _url.$this->_config['ext']['web'].'?id='.$id.'&action=delete', 'FICHIER_CIBLE');
					//$this -> cibleFormulaire($this -> _url.$this->_config['ext']['web'].'?id='.$id.'&action=delete', 'FICHIER_CIBLE');
				}

		
				break; 
			
			case 'add':
				if(isset($_POST) and !empty($_POST)){
					// TRAITEMENT DU FORMULAIRE (SAUVEGARDE DES DONNEES)
					$dataForm = $_POST;
					// Ecriture des nouveaux droits
					(isset($dataForm['activated'])) ? $activateds = $dataForm['activated'] : $activateds = null;
					$newGroupRight = 0;
					if(is_array($activateds)){
						foreach($activateds as $i => $activated){
							$newGroupRight = $newGroupRight + pow(2, $i);
						}
					}
					
					$this -> _userObject -> addGroup($dataForm['name'],$newGroupRight,$dataForm['description']);
					
					// ET ON AFFICHE LA PAGE D'ACCUEIL
					self::$multiArrayToParse[]=array('info'=>array( 'DATE'	=> date('l j  F Y H:i:s'))); 
					$this->_templateNameModule = 'page';
					break;
					
				}else{
					// AFFICHAGE DU FORMULAIRE
					$this->_templateNameModule = 'add';
					$this -> formTarget($this -> _url.$this->_config['ext']['web'].'?action=add', 'FICHIER_CIBLE');
					// $this -> cibleFormulaire($this -> _url.$this->_config['ext']['web'].'?action=add', 'FICHIER_CIBLE');
				}
				break;
			
				
			default:
				$this->_templateNameModule = 'page';
				
		}
		
		$groups = $this -> _userObject -> groupsList();	// array
		// AFFICHAGE DES GROUPES
		foreach($groups as $grp){
			self::$multiArrayToParse[]=array('listgroup'=>array('ID' 	=> $grp['id'],
														   'RIGHT'  => $grp['right'],
														   'GRP_NAME'	=>  $grp['name'],
														   'GRP_DESCRIPTION' => $grp['description'],
														   'LINK_EDIT'	 => $this -> _url.$this->_config['ext']['web'].'?id='.$grp['id'].'&action=edit',
														   'LINK_DELETE' => $this -> _url.$this->_config['ext']['web'].'?id='.$grp['id'].'&action=delete')); 
		}
		
		// Liste des droits activés
		$rights = $this -> _userObject -> rightsList();
		foreach($rights as $right){
			self::$multiArrayToParse[]=array('list'=>array('NB' 	=> $right['id'],
														   'ACTIV'  => intval($right['activated']),
														   'ACTIVATED' => $right['activated'],
														   'RGHT_NB'	=>  $right['id'],
														   'RGHT_NAME'	=>  $right['name'],
														   'RGHT_DESCRIPTION' => $right['description'])); 
		
		}
	}
	public function selectUsers(){
		//require(ROOT_PATH.$this->_config['librairie']['interstitium'].'users.class.php');
		//$usersObject = new Xml_User(array('fr','login','users'),$root="root");
		
		/* require_once(ROOT_PATH.$this->_config['librairie']['interstitium'].'groups.class.php');
		//$path = ROOT_PATH.$this->_config['path']['data'].'/login/groups.xml';
		$groupsClass = new Xml_Group(array('fr','usermanager','groups'), $root="root"); */
		
		$actionQuery = false;
		if(isset($this -> _urlQuery['action']) &&  !empty($this -> _urlQuery['action'])){
			$actionQuery = $this -> _urlQuery['action'];
		}
		$id = false;

		if(isset($this -> _urlQuery['id']) && $this -> _urlQuery['id']!=null){
			$id = intval($this -> _urlQuery['id']);
		}
		$myUser = $this -> _userObject -> setUser($id);
		
		switch($actionQuery){			
			case 'edit':
				$this->_templateNameModule = 'edit';
				
				if(isset($_POST) and !empty($_POST)){
					$dataForm = $_POST['user'];
					// si le group sélectionné existe vraiment
					if($this -> _userObject -> setGroup($dataForm['group'])){
						$myGroup = $this -> _userObject -> group();
						$groupname = $myGroup['name'];
						$username = $dataForm['username'];
						$email = $dataForm['email'];
						$group = $dataForm['group'];
						$password = $dataForm['password'];
						$droits = $myGroup['right'];
						$this -> _userObject -> editUser($username,$email,$group,$groupname,$password,$droits);
			
					}
					self::$multiArrayToParse[]=array('info'=>array( 'DATE'	=> date('l j  F Y H:i:s'))); 
				}
				
				$myUser = $this -> _userObject -> user();
				$this -> parseArray($myUser,'form_');
				
			/* 	self::$arrayToParse['USERNAME'] = $myUser['username'];
				self::$arrayToParse['GROUP'] = $myUser['groupname'];
				self::$arrayToParse['EMAIL'] = $myUser['email'];
				self::$arrayToParse['DROITS'] = $myUser['droits'];
				self::$arrayToParse['PASSWORD'] = $myUser['password']; */
				
				$this -> formTarget($this -> _url.$this->_config['ext']['web'].'?id='.$id.'&action=edit', 'FICHIER_CIBLE');
				//$this -> cibleFormulaire($this -> _url.$this->_config['ext']['web'].'?id='.$id.'&action=edit', 'FICHIER_CIBLE');
				
				break;
			case 'delete':
				$myUser = $this -> _userObject -> user();
				$this -> parseArray($myUser,'form_');
				if(empty($myUser)){
					break;
				}

				if(isset($_POST) and !empty($_POST)){
					if(isset($_POST['ok']) && $_POST['ok'] == 'ok'){
						
						$this -> _userObject -> deleteUser(); 
						// ET ON AFFICHE LA PAGE D'ACCUEIL
						self::$multiArrayToParse[]=array('info'=>array( 'DATE'	=> date('l j  F Y H:i:s'))); 
						$this->_templateNameModule = 'page';
						break;
					}else{
						$this->_templateNameModule = 'page';
						break;
					}
				}else{
					$this->_templateNameModule = 'delete';
					$this -> formTarget($this -> _url.$this->_config['ext']['web'].'?id='.$id.'&action=delete', 'FICHIER_CIBLE');
					//$this -> cibleFormulaire($this -> _url.$this->_config['ext']['web'].'?id='.$id.'&action=delete', 'FICHIER_CIBLE');
				}
	
		
				break; 
			case 'add':
				//$this -> _userObject -> setUser($id);		
				
				if(isset($_POST) and !empty($_POST)){
					$dataForm = $_POST['user'];
					// si le group sélectionné existe vraiment
					if($this -> _userObject -> setGroup($dataForm['group'])){
						$myGroup = $this -> _userObject -> group();
						$groupname = $myGroup['name'];
						$username = $dataForm['username'];
						$email = $dataForm['email'];
						$group = $dataForm['group'];
						$password = $dataForm['password'];
						$droits = $myGroup['right'];
						
						$this -> _userObject -> addUser($username,$email,$group,$groupname,$password,$droits);
						
						self::$multiArrayToParse[]=array('info'=>array( 'DATE'	=> date('l j  F Y H:i:s'))); 
						$this->_templateNameModule = 'page';
						break;
			
					}else{
						echo 'Problemmmmmm!!!';
					}
				}else{
					$this->_templateNameModule = 'add';				
				}
				
				
				$this -> formTarget($this -> _url.$this->_config['ext']['web'].'?action=add', 'FICHIER_CIBLE');
				//$this -> cibleFormulaire($this -> _url.$this->_config['ext']['web'].'?action=add', 'FICHIER_CIBLE');
				
				break;
			default:
				$this->_templateNameModule = 'page';
		}
		
				 
		self::$arrayToParse['LINK_USER'] = $this -> _url.$this->_config['ext']['web'];
		self::$arrayToParse['LINK_ADD_USER'] = $this -> _url.$this->_config['ext']['web'].'?action=add';
		$users = $this -> _userObject -> usersList();
		
		foreach($users as $user){
			/* ($user['logout']==1) ? $logout = true : $logout = false;
			if($user['date'] == 0){
				$dateLogin = '-';
			}else{
				$dateLogin = date('d/m/Y',$user['date']);
			} */
			self::$multiArrayToParse[]=array('list'=>array( 'USERNAME'		=> $user['username'],
															'GROUP'		=> $user['group'],
															'GROUPNAME'		=> $user['groupname'],
															'EMAIL'		=> $user['email'],
															'DROITS'	=> $user['droits'],
															'T_LOGOUT'	=> $user['logout'],
															'DATE'		=> $user['date'],
															'LINK_EDIT'=> $this -> _url.$this->_config['ext']['web'].'?id='.$user['id'].'&action=edit',
															'LINK_DELETE'=>$this -> _url.$this->_config['ext']['web'].'?id='.$user['id'].'&action=delete')); 
		}
		
		$groups = $this -> _userObject -> groupsList();
		foreach($groups as $grp){
			$selected = false;
			if(isset($myUser['group']) && $grp['id'] == $myUser['group']){
				$selected = true;
			}
			
			self::$multiArrayToParse[]=array('groups'=>array('ID' 	=> $grp['id'],
														   'RIGHT'  => $grp['right'],
														   'GRP_NAME'	=>  $grp['name'],
														   'GRP_DESCRIPTION' => $grp['description'],
														   'SELECTED' => $selected,
														   'LINK_EDIT'	 => $this -> _url.$this->_config['ext']['web'].'?id='.$grp['id'].'&action=edit',
														   'LINK_DELETE' => $this -> _url.$this->_config['ext']['web'].'?id='.$grp['id'].'&action=delete')); 
		}
	}
	public function selectRights(){
		require_once(ROOT_PATH.$this->_config['librairie']['interstitium'].'users.class.php');
		//$path = ROOT_PATH.$this->_config['path']['data'].'/login/groups.xml';
		//$usersObject = new Xml_User(array('fr','login','users'), $root="root");
		
		self::$arrayToParse['LINK_GROUP'] = $this -> _url.$this->_config['ext']['web'];
		self::$arrayToParse['LINK_ADD_GROUP'] = $this -> _url.$this->_config['ext']['web'].'?action=add';
	
			if(isset($_POST) and !empty($_POST)){
				$dataForm = $_POST;
				$names = $dataForm['name'];
				$descriptions = $dataForm['description'];
				(isset($dataForm['activated'])) ? $activateds = $dataForm['activated'] : $activateds = null;

				$this -> _userObject -> rightEdit($activateds,$names,$descriptions);
				

				self::$multiArrayToParse[]=array('info'=>array( 'DATE'	=> date('l j  F Y H:i:s'))); 
				
			} 
			
		$this->_templateNameModule = 'page';
		//$this -> cibleFormulaire($this -> _url.$this->_config['ext']['web'].'?action=edit', 'FICHIER_CIBLE');
		
		$this -> formTarget($_SERVER['REQUEST_URI'], 'FICHIER_CIBLE');
		
		// Liste des droits activés
		$rights = $this -> _userObject -> rightsList(true);
		foreach($rights as $right){
			self::$multiArrayToParse[]=array('list'=>array('NB' 	=> $right['id'],
														   'ACTIV'  => intval($right['activated']),
														   'ACTIVATED' => $right['activated'],
														   'RGHT_NB'	=>  $right['id'],
														   'RGHT_NAME'	=>  $right['name'],
														   'RGHT_DESCRIPTION' => $right['description'])); 
		
		}
		
		
		
		
	}
	
}			
			




?>