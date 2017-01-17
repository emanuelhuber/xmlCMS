<?php

//extends ModuleSquelette
class ModuleUsermanagerGroups extends ModuleAdmin{
	
	public function __construct($url, $query, $urlArray, $conf){
		parent::__construct($url, $query, $urlArray, $conf);		
		require(ROOT_PATH.$this->_config['librairie']['interstitium'].'page.class.php');
		$path = BASE_PATH.$this->_config['path']['data'].$urlArray[1].'/'.$urlArray[2].$this->_config['ext']['data'];
		self::$myPage = new Xml_Page($path);
	}
	


	
	public function setData(){
		$this->_templateNameModule = 'page';
		self::$arrayToParse['CURRENT_CRUMB'] = self::$arrayToParse['INFO_TITRE'];
		
		require_once(ROOT_PATH.$this->_config['librairie']['interstitium'].'groups.class.php');
		$path = ROOT_PATH.$this->_config['path']['data'].'/login/groups.xml';
		$groupsObject = new Xml_Group($path );
		
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
		
		$myGroup = $groupsObject -> setGroup($id);

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
					
					$groupsObject -> editGroup($dataForm['name'],$newGroupRight,$dataForm['description']);
					
					self::$multiArrayToParse[]=array('info'=>array( 'DATE'	=> date('l j  F Y H:i:s'))); 
				}else{
					
				}

				$myGroup = $groupsObject -> group();
				$this -> parseArray($myGroup,'form_');
				
				$this -> formTarget($this -> _url.$this->_config['ext']['web'].'?id='.$myGroup['id'].'&action=edit', 'FICHIER_CIBLE');
				//$this -> cibleFormulaire($this -> _url.$this->_config['ext']['web'].'?id='.$myGroup['id'].'&action=edit', 'FICHIER_CIBLE');
				
				break;
			case 'delete':  // need a right ID
				$myGroup = $groupsObject -> group();
				$this -> parseArray($myGroup,'form_');
				if(empty($myGroup)){
					break;
				}
				
				/* self::$arrayToParse['RIGHT'] = $myGroup['right'];
				self::$arrayToParse['GRP_NAME'] = $myGroup['name'];
				self::$arrayToParse['GRP_DESCRIPTION'] = $myGroup['description']; */
				
				if(isset($_POST) and !empty($_POST)){
					if(isset($_POST['ok']) && $_POST['ok'] == 'ok'){
						$groupsObject -> deleteGroup(); 
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
					
					$groupsObject -> addGroup($dataForm['name'],$newGroupRight,$dataForm['description']);
					
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
		
		$groups = $groupsObject -> groupsList();	// array
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
		$rights = $groupsObject -> rightsList();
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