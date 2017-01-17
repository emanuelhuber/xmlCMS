<?php
class Atom{


	public $path 		= null;
	protected $_dom 	= null;
	protected $_xPath 	= null;
	protected static $_max = 10;
	/* public $filetime 	= 0; */
	
	public function __construct($path, $maxItem = 10){
		$this -> path = $path;
		self::$_max = $maxItem;
		if(!is_file($this -> path)){
			$this -> createAtom();
		}
			if($this -> _dom = self::openXmlFile($this -> path)){
				$this -> _xPath =  new DOMXPath($this -> _dom);
				
				//$this -> filetime = self::getFileTime($this -> path);
			}else{
				echo 'Problem!!!';
			}
	}
	
	public function createAtom(){
		$docXML = new DomDocument("1.0", "UTF-8");      // constructeur, création d'un document XML
		
		$feed = $docXML->createElement("feed");       // création d'un élément
		$feed -> setAttribute('xmlns','http://www.w3.org/2005/Atom');
		
		$node = $docXML->createElement("title");       // création d'un élément
		$feed -> appendChild($node);                    // ajout à la racine du document
		$text = $docXML -> createTextNode('TITRE'); 
		$node -> appendChild($text);
		
		$node = $docXML->createElement("updated");       // création d'un élément
		$feed -> appendChild($node);                    // ajout à la racine du document
		$text = $docXML -> createTextNode(date('c')); 
		$node -> appendChild($text);
		
		$node = $docXML->createElement("id");       // création d'un élément
		$feed -> appendChild($node);                    // ajout à la racine du document
		$text = $docXML -> createTextNode(ROOT_URL); 
		$node -> appendChild($text);
		
		$node = $docXML->createElement("subtitle");       // création d'un élément
		$feed -> appendChild($node);                    // ajout à la racine du document
		$text = $docXML -> createTextNode('SOUS-TITRE'); 
		$node -> appendChild($text);

		$docXML -> appendChild($feed);
		
		self::saveXmlFile($docXML, $this -> path);
		//$docXML->save('nom_fichier.xml');                    // enregistrement du fichier XM
	}
	
	

	
	public function deleteEntry($id){
		$updated = $this -> _dom -> getElementsByTagName('updated') -> item(0)->firstChild;		
		$updated -> replaceData ( 0 , 200 , date('c') );
		
		$query = '*[@ref="'.$id.'"]';
		$options = $this -> _xPath -> query($query);
		
		// si l'entrée existe déjà on la supprime
		// afin que la nouvelle entrée soit placée en haut du fichier
		if($options -> length>0){
			$myEntry = $options -> item(0);
			$this -> deleteNode($myEntry);
			self::saveXmlFile($this -> _dom, $this -> path);
		}else{
		}
	}
	
	public function addEntry($id, $title, $link, $summary){
		$this -> deleteEntry($id);

	// Nouvelle entrée
		$query2 = '/feed/entry';
		$optionNodes = $this -> _dom -> getElementsByTagName('entry');

		$entry = $this -> _dom -> createElement("entry");
		// si il existe déjà un ou des nodes, on insère le nouveau
		// node en tête !
		$n = $optionNodes -> length;
		if($n > 0){
			// on regarde si le nombre de node existant est plus petit que self::$_max
			if($n >= self::$_max){
				for( $i = self::$_max; $i <= $n; $i++ ){
					$refToDelete = $optionNodes -> item($i-1) -> getAttribute('ref');
					$this -> deleteEntry($refToDelete);
				}
			}
			$firstEntry = $optionNodes -> item(0);
			$newEntry = $firstEntry->parentNode->insertBefore($entry, $firstEntry);
		// si il n'existe pas de nodes, on ajoute le nouveau node sous le parent.
		}else{
			$doc = $this -> _dom -> getElementsByTagName('feed') -> item(0);
			$newEntry = $doc -> appendChild($entry);
		}
		
			$newEntry -> setAttribute('ref',$id);
			
			$nodeTitle = $this -> _dom -> createElement("title");
			$entry -> appendChild($nodeTitle);
			
			$nodeTitle -> setAttribute('type','html');
			$textTitle = $this -> _dom -> createTextNode($title); 
			$nodeTitle -> appendChild($textTitle);
			
			$nodeId = $this -> _dom -> createElement("id");
			$entry -> appendChild($nodeId);
			$textId = $this -> _dom -> createTextNode($id); 
			$nodeId -> appendChild($textId);
			
			$nodeUpdated = $this -> _dom -> createElement("updated");
			$entry -> appendChild($nodeUpdated);
			$textUpdated = $this -> _dom -> createTextNode(date('c')); 
			$nodeUpdated -> appendChild($textUpdated);
			
			$nodeLink = $this -> _dom -> createElement("link");
			$newLink = $entry -> appendChild($nodeLink);
			$newLink -> setAttribute("rel", "alternate");
			$newLink -> setAttribute("href", $link);
			
			$nodeSummary = $this -> _dom -> createElement("summary");
			$entry -> appendChild($nodeSummary);
			$nodeSummary -> setAttribute('type','html');
			$textSummary = $this -> _dom -> createTextNode($summary); 
			$nodeSummary -> appendChild($textSummary); 

		self::saveXmlFile($this -> _dom, $this -> path);		
	}
	
	public function delete(){
		unlink($this -> path);
	}
	
	public function getInfo($id='*'){
		$query = '/page/info/'.$id;	
		return $this -> xmlToArray($query);
	}
	
	public function getOption(){
		$query = '/page/option';
		$options = $this->_xPath -> query($query);
		if($options -> length>0){
			$options = $options -> item(0);
			return $options -> getAttribute('nb');
		}else{
			return 1;
		}
	}
	
	public function setInfo($array){
		foreach($array as $key => $value){
			if($this -> _dom -> getElementsByTagName($key) != null){
				$node = $this -> _dom -> getElementsByTagName($key)->item(0);
				$node->removeChild($node->firstChild);
				$newText = $this -> _dom -> createCDATASection($value);
				$node->appendChild($newText);
			}
		}
		self::saveXmlFile($this -> _dom, $this -> path);
		
	}
	
	/* public function getDesign(){
		$design = $this -> _dom -> getElementsByTagName('design') -> item(0);
		return array('theme' => $design -> getAttribute('nom'),
						'style' => $design -> getAttribute('style'),
						'squelette' => $design -> getAttribute('squelette'));
	} */
	public function getTemplates(){
		$design = $this -> _dom -> getElementsByTagName('design') -> item(0);
		$nbTpl = $design-> attributes -> length;
		if($nbTpl  > 0){
			
			$tempates = array();
			for ($i = 3; $i < $nbTpl; ++$i){	//  $design-> attributes as $key => $value) {
				$key = $design->attributes->item($i)->name;
				$tempates[$key] =  $design->getAttribute($key);
			}
			return $tempates;
		}
		return false;
	}
	public function setDesign($array){
		$design = $this -> _dom -> getElementsByTagName('design') -> item(0);
		foreach($array as $key => $value){
			$attName = $design -> getAttribute($key);
			if(!empty($attName)){
				$design -> setAttribute($key, $value);
			}
			/* if($this -> _dom -> getElementsByTagName($key) != null){
				$node = $this -> _dom -> getElementsByTagName($key)->item(0);
				$node->removeChild($node->firstChild);
				$newText = $this -> _dom -> createCDATASection($value);
				$node->appendChild($newText);
			} */
		}
		self::saveXmlFile($this -> _dom, $this -> path);
		
	}
	public function getContent(){
		$query = '/page/contenu/*';	
		return $this -> xmlToArray($query);
	}
	
	public function setContent($array){
		foreach($array as $key => $value){
			if($this -> _dom -> getElementsByTagName($key) != null){
				$node = $this -> _dom -> getElementsByTagName($key)->item(0);
				$node->removeChild($node->firstChild);
				$newText = $this -> _dom -> createCDATASection($value);
				$node->appendChild($newText);
			}
		}
		self::saveXmlFile($this -> _dom, $this -> path);
	}
	
	public function getTemplate($name){
		$design = $this -> _dom -> getElementsByTagName('design') -> item(0);
		return $design -> getAttribute($name);
	}
	
	private function xmlToArray($query){
		$infos = $this->_xPath -> query($query);
		$infoArray = array();
		foreach($infos as $info){
			$infoArray[$info ->  nodeName] = $info -> textContent;
		}
		return $infoArray;
	}
	
	protected static function openXmlFile($path){
		if(is_file($path)){
			$dom = new DomDocument();
			$dom -> formatOutput = true;
			$dom -> preserveWhiteSpace = true; 
			if($dom -> load($path)){
				return $dom;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
	
	protected static function saveXmlFile($dom,$path){
		$outXML = $dom->saveXML();
		$dom = new DOMDocument();
		$dom->preserveWhiteSpace = false;
		$dom->formatOutput = true;
		$dom->loadXML($outXML);
		if(is_file($path)) {
			$dom->save($path.'.tmp'); 
			unlink($path);
			rename($path.'.tmp', $path); # On renomme le fichier temporaire avec le nom de l'ancien
		} else {
			$dom->save($path); 
		}
		# On place les bons droits
		@chmod($path,0644);	// Returns TRUE on success or FALSE on failure. 
		# On vérifie le résultat
		if(is_file($path) && !is_file($path.'.tmp')){
			return true;
		}else{
			return false;
		}
	}
	
	public static function writeArray($data, $path){
		file_put_contents($path, serialize($data));

	}
	
	public static function openArray($path){
		if(is_file($path)){
			if(is_array(unserialize(file_get_contents($path)))){
				return unserialize(file_get_contents($path));
			}else{
				return array();
			}
		}else{
			return array();
		}
	}
	
	public static function getFileTime($path){
		return filemtime($path);
	}
	
	public function remove_children(&$node) {
	  while (isset($node->firstChild)) {
		while ($node->firstChild->firstChild) {
		  $this -> remove_children($node->firstChild);
		}
		$node->removeChild($node->firstChild);
	  }
	}
	
	public function deleteNode($node, $delParentWithoutChild=false) {
		$nodeWithoutChildren = false;
		$parent = $node->parentNode;
		if($delParentWithoutChild){
			if($node->hasChildNodes() ){
				foreach ($node->childNodes as $noeud) {
					if($noeud->nodeType == XML_ELEMENT_NODE){
					//echo 'yes!!!';
						// on copie les fils et les ajoutes au parent du
						// noeud à supprimer
						$parent -> appendChild($noeud);
						break;
					}
				}
			}
			/* $grandParent = $parent->parentNode;
			$grandParent->removeChild($parent); */
		}
		// on supprime le noeud à supprimer ainsi que ses enfants
		$this->deleteChildren($node);
		$oldnode = $parent->removeChild($node);

	}

	public function deleteChildren($node) {
		while(isset($node->firstChild)) {
			$this -> deleteChildren($node->firstChild);
			$node->removeChild($node->firstChild);
		}
	} 
	
	// source : http://ch.php.net/manual/fr/function.asort.php
	// author : richard at happymango dot me dot uk
	public static function sort2DArray($records, $field, $reverse=false){
		$hash = array();
		foreach($records as $record){
			$hash[$record[$field]] = $record;
		}
		($reverse)? krsort($hash) : ksort($hash);
		$records = array();
		foreach($hash as $record){
			$records []= $record;
		}
		return $records;
	}
	
	public static function moveNode($node,$direction='up'){
		switch($direction){
			case 'up':
				$itemBefore = $node -> previousSibling;
				while($itemBefore!=null and $itemBefore -> nodeType != XML_ELEMENT_NODE){
					$itemBefore = $itemBefore -> previousSibling;
				}
				if($itemBefore != null){ // si il y a un noeud avant le noeud $node
					// on déplace d'un cran le noeud vers le haut
					$itemBefore->parentNode->insertBefore($node, $itemBefore);
				}else{
					// noeud au top de la liste!
				}
				break;
			case 'down':
				$itemBefore = $node -> nextSibling;
				while($itemBefore!=null and $itemBefore -> nodeType != XML_ELEMENT_NODE){
					$itemBefore = $itemBefore -> nextSibling;
				}
				if($itemBefore != null){
					$node->parentNode->insertBefore($itemBefore, $node);
				}else{
					// noeud au top de la liste!
				}
				break;
			case 'left':
				$itemBefore = $node -> parentNode;
				while($itemBefore!=null and $itemBefore -> nodeType != XML_ELEMENT_NODE){
					$itemBefore = $itemBefore -> parentNode;
				}
				if($itemBefore != null){
					$itemBefore -> parentNode -> insertBefore($node, $itemBefore);
				}else{
					// noeud au top de la liste!
				}
				break;
			case 'right':
				
				$itemBefore = $node -> nextSibling;
				while($itemBefore!=null and $itemBefore -> nodeType != XML_ELEMENT_NODE){
					$itemBefore = $itemBefore -> nextSibling;
				}
				if($itemBefore!= null && $itemBefore -> hasChildNodes()){
					$itemBefore = $itemBefore -> lastChild;
					if($itemBefore != null){
						$itemBefore -> parentNode -> insertBefore($node, $itemBefore);
					}else{
						// noeud au top de la liste!
					}
				}elseif($itemBefore!= null){
					$itemBefore -> appendChild($node);
				}
				break;
			default :
				break;
		}
	}
	
	public static function clearDir($dossier) {
		$ouverture=@opendir($dossier);
		if (!$ouverture) return;
		while($fichier=readdir($ouverture)) {
			if ($fichier == '.' || $fichier == '..') continue;
				if (is_dir($dossier.'/'.$fichier)) {
					$r=clearDir($dossier.'/'.$fichier);
					if (!$r) return false;
				}
				else {
					$r=@unlink($dossier.'/'.$fichier);
					if (!$r) return false;
				}
		}
		closedir($ouverture);
		$r=@rmdir($dossier);
		if (!$r) return false;
			return true;
	}
	

}
?>