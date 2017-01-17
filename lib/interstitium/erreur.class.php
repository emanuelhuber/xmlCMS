<?php
class Xml_Erreur extends Xml_Model{
	
	public function __construct($urlArray, $root='base'){
		parent::__construct($urlArray, $root);
	}
	
	protected function _getPath($urlArray,$root){
		$this -> idPage = $urlArray[0].','.$urlArray[1].','.$urlArray[2];
		//self::$_tagPath  = ROOT_PATH.'/data/'.$urlArray[1].'/tags-'.$urlArray[0].'.data';
		if($root == 'base'){ 
			$this -> path = BASE_PATH.'/data/'.$urlArray[1].'/'.$urlArray[1].'-'.$urlArray[0].'.xml';
		}else{
			$this -> path = ROOT_PATH.'/data/'.$urlArray[1].'/'.$urlArray[1].'-'.$urlArray[0].'.xml';
		}
	}
	
	public function getErreur($nb=''){
		$query = '/page/contenu/principal/erreur'.$nb;
		$err = $this->_xPath -> query($query);
		if($err -> length > 0){
			$err = $err -> item(0);
			return $err -> textContent;
		}else{	// erreur par défaut
			$query = '/page/contenu/principal/erreur';
			$err = $this->_xPath -> query($query);
			if($err -> length>0){
				$err = $err -> item(0);
				return $err -> textContent;
			}else{
				return false;
			}
		}
	
	}
	

	
	
	
	

}
?>