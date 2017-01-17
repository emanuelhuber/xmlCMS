<?php
class Xml_Module extends Xml_Model{
	
/* 	private $_path = null;
	private $_dom = null;
	private $_xPath = null; 
	public $filetime = 0; */
	
	
	public function __construct(){
		$this -> path = BASE_PATH.'/conf/module.xml';
		if($this -> _dom = self::openXmlFile($this -> path)){
			$this -> _xPath =  new DOMXPath($this -> _dom);
			$this -> filetime = self::getFileTime($this -> path);
			//return true;
		}else{
			$this -> error = TRUE;
			//return false;
		}
	}
	
	public function getModulesList(){
		$query = '//modules/item';
		$modules = $this->_xPath -> query($query);
		if($modules -> length>0){
			$modulesArray = array();
			foreach($modules as $module){
				$modulesArray[] = array('id' => $module -> getAttribute('id'),
										'nom' => $module -> getAttribute('nom'),
										'type' => $module -> getAttribute('type'),
										'actif' => $module -> getAttribute('actif'),
										'description' => $module -> getAttribute('description'));
			}
			return $modulesArray;
		}else{
			return 1;
		}
	}
	

	
	
	
	

}
?>