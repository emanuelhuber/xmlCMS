<?php
class Xml_Rubrique extends Xml_Model{
	
	// CONSTANTE
	// 		- MODULE NAME = [page]
	
	public function __construct($urlArray, $root='base',$create = FALSE){
		$this -> idPage = $urlArray[0].','.$urlArray[1].','.$urlArray[2];
		return true;
	}
	public function setInfo($infos){
		return true;
	}
	
	public function getPages(){
	
	}
	
	
	
	
	

}
?>