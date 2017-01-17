<?php

//extends ModuleSquelette
class ModuleUsermanagerUsers extends ModuleAdmin{
	
	public function __construct($url, $query, $urlArray, $conf){
		parent::__construct($url, $query, $urlArray, $conf);		
		require(ROOT_PATH.$this->_config['librairie']['interstitium'].'page.class.php');
		$path = BASE_PATH.$this->_config['path']['data'].$urlArray[1].'/'.$urlArray[2].$this->_config['ext']['data'];
		self::$myPage = new Xml_Page($path);
	}

	
	public function setData(){
		self::$arrayToParse['CURRENT_CRUMB'] = self::$arrayToParse['INFO_TITRE'];
		
		$domPathUser = ROOT_PATH.$this->_config['path']['data'].'/login/connection.xml';	

		require(ROOT_PATH.$this->_config['librairie']['interstitium'].'users.class.php');
		$usersObject = new Xml_User($domPathUser);
		
		require_once(ROOT_PATH.$this->_config['librairie']['interstitium'].'groups.class.php');
		$path = ROOT_PATH.$this->_config['path']['data'].'/login/groups.xml';
		$groupsClass = new Xml_Group($path );
		
		$actionQuery = false;
		if(isset($this -> _urlQuery['action']) &&  !empty($this -> _urlQuery['action'])){
			$actionQuery = $this -> _urlQuery['action'];
		}
		$id = false;

		if(isset($this -> _urlQuery['id']) && $this -> _urlQuery['id']!=null){
			$id = intval($this -> _urlQuery['id']);
		}
		$myUser = $usersObject -> setUser($id);
		
		switch($actionQuery){			
			case 'edit':
				$this->_templateNameModule = 'edit';
				
				if(isset($_POST) and !empty($_POST)){
					$dataForm = $_POST['user'];
					// si le group sélectionné existe vraiment
					if($groupsClass -> setGroup($dataForm['group'])){
						$myGroup = $groupsClass -> group();
						$groupname = $myGroup['name'];
						$username = $dataForm['username'];
						$email = $dataForm['email'];
						$group = $dataForm['group'];
						$password = $dataForm['password'];
						$droits = $myGroup['right'];
						$usersObject -> editUser($username,$email,$group,$groupname,$password,$droits);
			
					}
					self::$multiArrayToParse[]=array('info'=>array( 'DATE'	=> date('l j  F Y H:i:s'))); 
				}
				
				$myUser = $usersObject -> user();
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
				$myUser = $usersObject -> user();
				$this -> parseArray($myUser,'form_');
				if(empty($myUser)){
					break;
				}

				if(isset($_POST) and !empty($_POST)){
					if(isset($_POST['ok']) && $_POST['ok'] == 'ok'){
						
						$usersObject -> deleteUser(); 
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
				//$usersObject -> setUser($id);		
				
				if(isset($_POST) and !empty($_POST)){
					$dataForm = $_POST['user'];
					// si le group sélectionné existe vraiment
					if($groupsClass -> setGroup($dataForm['group'])){
						$myGroup = $groupsClass -> group();
						$groupname = $myGroup['name'];
						$username = $dataForm['username'];
						$email = $dataForm['email'];
						$group = $dataForm['group'];
						$password = $dataForm['password'];
						$droits = $myGroup['right'];
						
						$usersObject -> addUser($username,$email,$group,$groupname,$password,$droits);
						
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
		$users = $usersObject -> usersList();
		
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
		
		$groups = $groupsClass -> groupsList();
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
}			
			




?>