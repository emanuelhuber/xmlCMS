<?php
class Xml_Page extends Xml_Model{
	
/* 	private $_path = null;
	private $_dom = null;
	private $_xPath = null; 
	public $filetime = 0; */
	
	
	public function __construct($urlArray){
		parent::__construct($urlArray);
	}
	
	public function getUser(string $id){
		$query = '/page/contenu/user[@name="'.$id.'"]';	
		$user = $this->_xPath -> query($query);
		if($user -> length>0){
			$userArray = array();
			$userArray['name'] =		$user ->  getAttribute('name');
			$userArray['type'] =		$user ->  getAttribute('type');
			$userArray['email'] =		$user ->  getAttribute('email');
			$userArray['rights'] =		$user ->  getAttribute('rights');
			$userArray['logout'] =		$user ->  getAttribute('logout');
			$userArray['date'] =		$user ->  getAttribute('date');
			$userArray['password'] =	$user -> textContent;
			
		}else{
			return false;
		}
		
		$usersArray = array();
		foreach($users as $user){
			$usersArray[$users ->  getAttribute('name')] = $info -> textContent;
		}
		return $usersArray;
	}

	
	
	
	

}
?>