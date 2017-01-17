<?php
class Xml_Pagemulti extends Xml_Model{
	
/* 	private $path = null;
	private $_dom = null;
	private $_xPath = null; 
	public $filetime = 0; */
	
	
	
	public function __construct($urlArray, $root='base',$create = FALSE){
		parent::__construct($urlArray, $root, $create);
	}
	
	public static function createPage($urlArray){
		$xmlChain = '<?xml version="1.0" encoding="UTF-8"?>
					<page>
					  <info>
						<titre><![CDATA[title]]></titre>
						<auteur><![CDATA[author]]></auteur>
						<date><![CDATA[00.00.0000]]></date>
						<description><![CDATA[description]]></description>
						<motsclefs><![CDATA[key words]]></motsclefs>
						<droit><![CDATA[-1]]></droit>
						<commentaire><![CDATA[0]]></commentaire>
						<image><![CDATA[#]]></image>
						<miniature><![CDATA[#]]></miniature>
						<publication>0</publication>
					  </info>
					   <design theme="defaut" style="monStyleDefaut" squelette="squelette.html" page="pagemulti.html"/>
					  <contenu>
						<principal></principal>
						<secondaire><![CDATA[]]></secondaire>
					  </contenu>
					</page>';
					
		$dom = new DOMDocument();
		$dom -> loadXML($xmlChain); 
		
		$filePath = ROOT_PATH.'/data/'.$urlArray[1].'/'.$urlArray[2];
		$ext = 'xml';
		$fileDest = self::findUniqueFileName($filePath,$ext);
		$fileDest = $fileDest.'.'.$ext;
		
		$fileName =  basename($fileDest,'.'.$ext);
		
		if(self::saveXmlFile($dom, $fileDest)){
			$idPage = $urlArray[0].','.$urlArray[1].','.$fileName;
			$infos = array(//'id'=>	$idPage,
							//'link'=> ROOT_URL.'/'.$idPage.'.html',
							'title'=> 'title',
							'description'=> 'pas de description / brouillon',
							'droit'=> -1,
						//	'summary'=> ,
							'publication'=> 0 );
			self::addEntrySiteMap($idPage, 'title', $infos);
			return $fileName;
		}else{
			return false;
		}
	}
	public function getPages(){
	
	}
	
	public function setInfo($array){
		parent::setInfo($array);
		self::addEntrySiteMap($this -> idPage,ROOT_URL.'/'.$this -> idPage.'.html', $array);
	}
	
	
	public function  publishBloc($id){	
		$query = '/page/contenu/principal/bloc['.$id.']';
		$blocs = $this -> _xPath -> query($query);
		if($blocs -> length > 0){
			$mybloc = $blocs -> item(0);
			$publish = $mybloc ->  getAttribute('publish');
			$mybloc ->  setAttribute('publish',abs($publish -1));
			self::saveXmlFile($this -> _dom, $this -> path);
		}else{
			return FALSE;
		}
	}
	
	public function getBlocs(){		
		$query = '/page/contenu/principal/bloc';
		$blocs = $this -> _xPath -> query($query);
		if($blocs -> length > 0){
			$blocsArray = array();
		
			foreach($blocs as $bloc){
				$blocsArray[] = array('publish' 	=> $bloc -> getAttribute('publish'),
									 'titre' 	=> $bloc -> getElementsByTagName('titre')-> item(0) -> nodeValue,
									 'contenu'	=> $bloc -> getElementsByTagName('content')-> item(0) -> nodeValue
									 );
				
			}
			return $blocsArray;
		}else{
			return FALSE;
		}
	}
	public function getBloc($id){	
		$query = '/page/contenu/principal/bloc['.$id.']';
		$blocs = $this -> _xPath -> query($query);
		if($blocs -> length > 0){
			$mybloc = $blocs -> item(0);
			return array('publish' 	=> $mybloc -> getAttribute('publish'),
						'titre' 	=> $mybloc -> getElementsByTagName('titre')-> item(0) -> nodeValue,
						'contenu'	=> $mybloc -> getElementsByTagName('content')-> item(0) -> nodeValue
								 );
		
		}else{
			return FALSE;
		}
	
	}
	public function setBloc($dataArray, $id){
		$query = '/page/contenu/principal/bloc['.$id.']';
		$blocs = $this -> _xPath -> query($query);
		if($blocs -> length > 0){
			$mybloc = $blocs -> item(0);
			foreach($dataArray as $key => $value){
				$node = $mybloc -> getElementsByTagName($key)->item(0);
				if($node->hasChildNodes() ){
					$node->removeChild($node->firstChild);
				}
				$newText = $this -> _dom -> createCDATASection($value);
				$node->appendChild($newText);
			}
		}else{
			return FALSE;
		}
		self::saveXmlFile($this -> _dom, $this -> path);
	}
	
	public function deleteBloc($id){
		$query = '/page/contenu/principal/bloc['.$id.']';
		$blocs = $this -> _xPath -> query($query);
		if($blocs -> length > 0){
			$mybloc = $blocs -> item(0);
			$mybloc->parentNode->removeChild($mybloc); 	
			self::saveXmlFile($this -> _dom, $this -> path);
		}else{
			return FALSE;
		}
	}
	
	public function addBloc($titre, $contenu =''){
		$myBloc = $this -> _dom -> createElement('bloc');
		$query = '/page/contenu/principal/bloc';
		$blocs = $this -> _xPath -> query($query);
		// Si il existe déjà des noeuds "bloc",
		// on insère le nouveau noeud à la fin de la liste
		if($blocs -> length > 0){
			$firstChild = $blocs -> item($blocs -> length - 1);
			$firstChild -> parentNode -> insertBefore($myBloc, $firstChild);
		
		// sinon on insère le noeud (tout simplement)
		}else{
			$domPrincipal = $this -> _dom -> getElementsByTagName('principal') -> item(0);
			$myBloc = $domPrincipal -> appendChild($myBloc);
		}
		$myBloc -> setAttribute('publish',0);
		$nodeChildren = array('titre'		=> $titre,
							  'content'		=> $contenu);
		foreach($nodeChildren as $key=>$value){
			$childNode = $this -> _dom -> createElement($key);
			$childNode = $myBloc -> appendChild($childNode);
			if($value!=''){
				$newText = $this -> _dom -> createCDATASection($value);
				$childNode->appendChild($newText);
			}
		}
		
		self::saveXmlFile($this -> _dom, $this -> path);
	}
	
	public function moveNodeId($id,$direction){
		$query = '/page/contenu/principal/bloc['.$id.']';
		$items = $this-> _xPath -> query($query);
		if($items->length>0){
			// seules les "rubriques" ainsi que les "chapitres" peuvent avoir des enfants!
			$itemBefore = $items -> item(0) -> nextSibling;
			while($itemBefore!=null and $itemBefore -> nodeType != XML_ELEMENT_NODE){
					$itemBefore = $itemBefore -> nextSibling;
			}			
			if($direction == 'up' or $direction == 'down'){
				self::moveNode($items->item(0),$direction);
				self::saveXmlFile($this -> _dom, $this -> path);
			}else{
				/* self::moveNode($item->item(0),$direction);
				self::saveXmlFile($this -> _dom,$this->path); */
			}
			
		}else{
			echo 'CA MARCHE'.$id;
		}
	}
	
	

}
?>