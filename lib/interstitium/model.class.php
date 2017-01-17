<?php
class Xml_Model{
	
	// TO DO 
	// CREATE SOME CONSTANT LIKE "miniatures"
	
	// QUESTION : doit-on intégré la classe menu dans Xml_Model ?
	
	// QUESTION : doit-on intégré la classe lister dans Xml_Model ?
	public $idPage		 = null;	// fr,module,id		
	
	public $path 		= null;
	protected $_dom 	= null;
	protected $_xPath 	= null;
	public $filetime 	= 0;
	public  $error 		= FALSE;
	// TAGS
	private static $_tagArray 	= null;
	protected static $_tagPath 	= null;
	// SITE MAP
	public static $siteMapPath 	= null;
	private static $_siteMap		= null;
	// ATOM
	public static $atomPath 	= null;
	private static $_atom		= null;
	public static $atomMaxItem = 10;
	
	
	public function __construct($urlArray, $root='base', $create=FALSE){
		if($create === TRUE){
			$newId = $this -> createPage($urlArray);
			if($newId != FALSE)	$urlArray[2] = $newId;
		}
		$this -> _getPath($urlArray,$root);
		if(($this -> _dom = self::openXmlFile($this -> path)) ){
			$this -> _xPath =  new DOMXPath($this -> _dom);
			$this -> filetime = self::getFileTime($this -> path);
		}else{
			echo 'Problem!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!';
			echo $this -> path;
			$this -> error = TRUE;
		}
	}
	
	
		
	protected function _getPath($urlArray,$root){
		$this -> idPage = $urlArray[0].','.$urlArray[1].','.$urlArray[2];
		self::$_tagPath  = ROOT_PATH.'/data/'.$urlArray[1].'/tags-'.$urlArray[0].'.data';
		if($root == 'base'){ 
			$this -> path = BASE_PATH.'/data/'.$urlArray[1].'/'.$urlArray[2].'.xml';
		}else{
			$this -> path = ROOT_PATH.'/data/'.$urlArray[1].'/'.$urlArray[2].'.xml';
		}
	}
	
	

	
	public function delete(){
		if(unlink($this -> path)){
			self::removeId($this -> idPage);
			return true;
		}else{
			return false;
		}
	}
	
	public static function removeId($idPage){
		self::deleteEntryAtom($idPage);			// supprime du flux
		self::deleteTags($idPage);
		self::deleteEntrySiteMap($idPage);
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
	
	public function setOption($array){
		$query = '/page/option';
		$options = $this->_xPath -> query($query);
		if($options -> length>0){
			$options = $options -> item(0);
			foreach($array as $key => $value){
				$options -> setAttribute($key, $value);
			}
			self::saveXmlFile($this -> _dom, $this -> path);
		}else{
			return false;
		}
	}
	
	public function getInfo($node='*'){
		$query = '/page/info/'.$node;	
		return $this -> xmlToArray($this->_xPath, $query);
	}
	
	public function setInfo($array){
		$publ = $this -> getInfo('publication');
		foreach($array as $key => $value){
			if($this -> _dom -> getElementsByTagName($key) != null){
				$node = $this -> _dom -> getElementsByTagName($key)->item(0);
				$oldValue = $node -> textContent;
				if($node->hasChildNodes() ){
					if($key == 'motsclefs'){
						//$oldData = $node -> textContent;
						self::updateTags($value,$this -> idPage);
						// remove doublons
						$value = self::buildStringTag($value);
					}
					$node->removeChild($node->firstChild);
				}
				
				$newText = $this -> _dom -> createCDATASection($value);
				$node->appendChild($newText);
				if($key == 'droit'){
					
					// si la page n'est plus accessible par tout le monde
					if($value > -1 && $oldValue == -1 && $publ['publication'] == 1){
						// on la retire du flux
						$this -> unpublish();
					// si la page est publié et devient accessible à tous
					}elseif($value == -1 && $oldValue > -1 && $publ['publication'] == 1){
						// on ajoute au flux
						$this -> publish();
					}
				}
			}
		}
		self::saveXmlFile($this -> _dom, $this -> path);
	}
	
	public function getDesign(){
		$design = $this -> _dom -> getElementsByTagName('design') -> item(0);
		return array('theme' => $design -> getAttribute('theme'),
						'style' => $design -> getAttribute('style'),
						'squelette' => $design -> getAttribute('squelette'));
	}
	
	public function getTemplateHTML(){
		$design = $this -> _dom -> getElementsByTagName('design') -> item(0);
		if ($design->hasAttributes()) {
			$myHTML = array();
		  foreach ($design->attributes as $attr) {
			if($attr->nodeName!= 'theme' && $attr->nodeName!= 'style'){
				$myHTML[$attr->nodeName] =$attr->nodeValue;
			}
		  }
		}
		return $myHTML;
		/* return array('theme' => $design -> getAttribute('theme'),
						'style' => $design -> getAttribute('style'),
						'squelette' => $design -> getAttribute('squelette')); */
	}
	
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
				$design -> removeAttribute($key);
				$design -> setAttribute($key, $value);
			}
		}
		self::saveXmlFile($this -> _dom, $this -> path);
		$this -> _dom = self::openXmlFile($this -> path);
		
		$this -> _xPath =  new DOMXPath($this -> _dom);
	}
	public function getContent(){
		$query = '/page/contenu/*';	
		return $this -> xmlToArray($this->_xPath, $query);
	}
	
	public function setContent($array){
		foreach($array as $key => $value){
			if($this -> _dom -> getElementsByTagName($key) != null){
				$node = $this -> _dom -> getElementsByTagName($key)->item(0);
				if($node->firstChild != NULL){
					$node->removeChild($node->firstChild);
				}
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
	
	// set "publication" =1
	// if no rights	=> add to flux
	public function publish(){
		$infos = $this -> getInfo();
		if($infos['droit']<0 && $infos['publication'] == 1) {				
			$title= htmlentities($infos['titre'], ENT_QUOTES, "UTF-8");
			$link = ROOT_URL.'/'.$this -> idPage.'.html';
			$summary = htmlentities($infos['description'], ENT_QUOTES, "UTF-8");

			self::addEntryAtom($this -> idPage, $title, $link, $summary);
		}
	}
	
	public function unpublish(){
		$infos = $this -> getInfo();
		if($infos['publication'] == 0) {	
			self::deleteEntryAtom($this -> idPage);
		}
	}
	
	
	
	protected function xmlToArray($xpath, $query, $prefix='', $suffix=''){
		$infos = $xpath -> query($query);
		$infoArray = array();
		foreach($infos as $info){
			$infoArray[$prefix.$info ->  nodeName.$suffix] = $info -> textContent;
		}
		return $infoArray;
	}
	
	protected static function openXmlFile($path){
		if(is_file($path)){
			$dom = new DomDocument();
			$dom -> formatOutput = true;
			$dom -> preserveWhiteSpace = false; 
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
	
	public static function writeIni($data, $path, $section = false){
		$content ='';
		foreach($data as $key => $value){
			$content .= $key.'="'.$value.'"';
			$content .="\r\n";		// les retour chariot doivent être entre guillemet!
		}
		if (!$handle = fopen($path, 'w')){ 
			return false; 
		}
		if (!fwrite($handle, $content)){ 
			return false; 
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
	
	public static function deleteNode($node, $delParentWithoutChild=false) {
		$nodeWithoutChildren = false;
		$parent = $node->parentNode;
		if($delParentWithoutChild){
			if($node->hasChildNodes() ){
				while(isset($node->firstChild)) {
					$parent -> appendChild($node->firstChild);
					
				}
			}
			/* $grandParent = $parent->parentNode;
			$grandParent->removeChild($parent); */
		}
		// on supprime le noeud à supprimer ainsi que ses enfants
		self::deleteChildren($node);
		$oldnode = $parent->removeChild($node);

	}
	public static function deleteChildren(&$node) {
	  while ($node->firstChild) {
		while ($node->firstChild->firstChild) {
		  self::deleteChildren($node->firstChild);
		}
		$node->removeChild($node->firstChild);
	  }
	}
/* 	public static function deleteChildren($node) {
		while(isset($node->firstChild)) {
			echo $node->firstChild -> textContent .'<br/>';
			self::deleteChildren($node->firstChild);
			$node->removeChild($node->firstChild);
		}
	}  */
	

	
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
			// http://www.weirdog.com/blog/php/supprimer-les-accents-des-caracteres-accentues-en-php.html
	public static function wd_remove_accents($str, $charset='utf-8'){
		$str = htmlentities($str, ENT_NOQUOTES, $charset);
		
		$str = preg_replace('#\&([A-za-z])(?:acute|cedil|circ|grave|ring|tilde|uml)\;#', '\1', $str);
		$str = preg_replace('#\&([A-za-z]{2})(?:lig)\;#', '\1', $str); // pour les ligatures e.g. '&oelig;'
		$str = preg_replace('#\&[^;]+\;#', '', $str); // supprime les autres caractères
		
		return $str;
	}
	// source : http://www.weirdog.com/blog/php/trier-les-cles-accentuees-dun-tableau-associatif.html
	// APPLICATION:
	// uksort($this -> tagArray,array( __CLASS__, 'wd_unaccent_compare_ci'));
	public static function wd_unaccent_compare_ci($a, $b){
		return strcmp(strtolower(self::wd_remove_accents($a)), strtolower(self::wd_remove_accents($b)));
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

/* 	public static function copyFile($fileSource,$fileDest,$safe=true){
		$path_parts = pathinfo($fileDest);
		if(!is_file($fileSource) or !is_dir($path_parts['dirname'])){
			
			return false;
		}
		if($safe){	
			// $fileName = $path_parts['dirname'].'/'.$path_parts['filename'];		// FREE XXX filename existe pas!
			$name = substr($path_parts['basename'], 0, -4);
			$fileName = $path_parts['dirname'].'/'.$name;
			$ext = $path_parts['extension'];
			$fileDest = $fileName;
			$fileDest = self::findUniqueFileName($fileName,$ext);
			$fileDest = $fileDest.'.'.$ext;
		}
		if(copy($fileSource, $fileDest)){
			return $fileDest;
		}else{
			echo '<br/> Erreur de copy!!<br/>';
			return false;
		}
	} */
	
	// cherche un nom de fichier unique pour un fichier donné
	// et retourne le nom sans extension
	// (pour par exemple sauvegarder un fichier qui existe déjà 
	// sous un autre nom "monfichier-1.ext")
	public static function findUniqueFileName($filePath,$ext,$sep='.'){
		$filePathMod = $filePath;
		$i=0;
		while(is_file($filePathMod.$sep.$ext)){
			$filePathMod = $filePath.'-'.$i;
			$i++;
		}
		return $filePathMod;
	}
	
	public static function findUniqueDirName($dirName){
		$dirDest = rtrim($dirName, '/').'/';
		$i=0;
		while(is_dir($dirDest)){
			$dirDest = $dirName.'-'.$i;
			$i++;
		}
		return $dirDest;
	}
	
	//--------------------------------
	//--------------------------------
	//-------LANGUE FICHIER INI DICTIONNAIRE-----------
	//--------------------------------
	
	public static function createDictionnary($lg){	
	// créer un fichier .ini (dictionnaire)
		$langFolder = ROOT_PATH.'/data/squelette/';
		$dossier = opendir($langFolder);
		$tags = array();	// va contenir les clefs uniques (toutes langues comprises)
		while ($fichier = readdir($dossier)) {
			$path = $langFolder.$fichier;
			// si c'est un fichier
			if($fichier != "." && $fichier != ".." && !is_dir($path)) {
				$extension = pathinfo($fichier, PATHINFO_EXTENSION); 
				if($extension == 'ini'){
					$dic = parse_ini_file($path, false);
					$tags = array_merge($tags,array_keys($dic));
				}
			}
		}
		$tags = array_unique($tags);
		$myDic = array_fill_keys ($tags, 'A_TRADUIRE');
		self::writeIni($myDic, $langFolder.'squelette-'.$lg.'.ini', $section = false);
	}
	
	public static function getDictionnary($lg, $root='base'){
		if($root == 'base'){
			$filePath = BASE_PATH.'/data/squelette/squelette-'.$lg.'.ini';
		}else{
			$filePath = ROOT_PATH.'/data/squelette/squelette-'.$lg.'.ini';
		}
		if(is_file($filePath)){
			return parse_ini_file($filePath, true);
		}
	}
	
	public static function deleteDictionnary($lg){
		$filePath = ROOT_PATH.'/data/squelette/squelette-'.$lg.'.ini';
		
		if(is_file($filePath)){
			unlink($filePath);
			return true;
			//return parse_ini_file($filePath, true);
		}
		return false;
	}
	
	//----------------------------------------------------------------------
	//----------------------------------------------------------------------
	//------------  TAG FUNCTIONS ------------------------------------------
	//----------------------------------------------------------------------
	
	protected static function _loadTags(){
		// si le fichier n'est pas chargé, on le charge
		if(!is_array(self::$_tagArray))		self::$_tagArray = self::openArray(self::$_tagPath);
	}	
	
	public static function getTags($string = false){
		self::_loadTags();
		if($string){
			return self::implodeTags(array_keys(self::$_tagArray));
		}else{
			if(!is_array(self::$_tagArray)){
				self::$_tagArray = array();
			}
			return  (self::$_tagArray);
		}
	}
	
	
	public static function updateTags($newTag,$idPage){
			self::_loadTags();
			
			$newTags = self::explodeTags($newTag);
			// 1. Delete all the entries with the idPage of the page!
			self::deleteTags($idPage);
			// 2. add the new tag (if not existing) and add the page idPage!
			foreach($newTags as $newTag){
				self::$_tagArray[$newTag][] = $idPage;
			}
			self::saveTag();
	}
	
	public static function deleteTags($idPage){
		self::_loadTags();
		foreach(self::$_tagArray as $clef=>$value){
			// if the page-idPage exists for a tag
			if(in_array($idPage, self::$_tagArray[$clef])){
				// find the key(s) where the page-idPage is and delete it/them.
				$keysToDelete = array_keys(self::$_tagArray[$clef], $idPage);
				foreach($keysToDelete as $keyTo){
					if(count(self::$_tagArray[$clef]) == 1){	// si il n'y a qu'un id pour le tag,
						unset( self::$_tagArray[$clef]);		// on supprime le tag
					}else{
						unset( self::$_tagArray[$clef][$keyTo]);
					}
				}
			}
		}
		self::saveTag();
	
	}
	
	public static function saveTag(){
		self::writeArray(self::$_tagArray, self::$_tagPath);
	}
	
	public static function buildStringTag($tag){
		$tags = self::explodeTags($tag);
		return self::implodeTags($tags);
	}
	
	private static function implodeTags($tags){
		$tag = implode(',',$tags);
		$tag = str_replace(',', ', ', $tag);
		return $tag;
	}
	
	private static function sanitizeTag($tag){
		$tag = trim(trim($tag), ","); // supprimer les espaces + virgules en début/fin de taging
		$tag = strip_tags($tag); // supprimer les balises de codes
		$tag = str_replace(array('?','&','#','=','+','<','>'), '', $tag);
		$tag = preg_replace( '#\s+#', ' ', $tag );
		$tag = self::_utf8ToHtml($tag, true);
		/* $tag = utf8_decode($tag);
		$tag = htmlentities($tag, ENT_QUOTES);		//, 'UTF-8');
		$tag = utf8_encode($tag); */
		return $tag;
	}
	
	private static function explodeTags($tag){
		$tags = array();
		$tag = trim(trim($tag), ','); // supprimer les espaces + virgules en début/fin de string
		$tagsToSanitize = explode(',',$tag);
		foreach($tagsToSanitize as $i => $value){
			if ($value = self::sanitizeTag(trim($value)))
				$tags[$i] = $value;
		}
		return array_unique($tags);
	}
	
	// converts a UTF8-string into HTML entities
	//  - $utf8:        the UTF8-string to convert
	//  - $encodeTags:  booloean. TRUE will convert "<" to "&lt;"
	//  - return:       returns the converted HTML-string
	private static function _utf8ToHtml($utf8, $encodeTags) {
		$result = '';
		for ($i = 0; $i < strlen($utf8); $i++) {
			$char = $utf8[$i];
			$ascii = ord($char);
			if ($ascii < 128) {
				// one-byte character
				$result .= ($encodeTags) ? htmlentities($char) : $char;
			} else if ($ascii < 192) {
				// non-utf8 character or not a start byte
			} else if ($ascii < 224) {
				// two-byte character
				$result .= htmlentities(substr($utf8, $i, 2), ENT_QUOTES, 'UTF-8');
				$i++;
			} else if ($ascii < 240) {
				// three-byte character
				$ascii1 = ord($utf8[$i+1]);
				$ascii2 = ord($utf8[$i+2]);
				$unicode = (15 & $ascii) * 4096 +
						   (63 & $ascii1) * 64 +
						   (63 & $ascii2);
				$result .= "&#$unicode;";
				$i += 2;
			} else if ($ascii < 248) {
				// four-byte character
				$ascii1 = ord($utf8[$i+1]);
				$ascii2 = ord($utf8[$i+2]);
				$ascii3 = ord($utf8[$i+3]);
				$unicode = (15 & $ascii) * 262144 +
						   (63 & $ascii1) * 4096 +
						   (63 & $ascii2) * 64 +
						   (63 & $ascii3);
				$result .= "&#$unicode;";
				$i += 3;
			}
		}
		return $result;
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
	
	//-------------------------------------
	//--------FLUX ATOM--------------------
	//-------------------------------------
	public static function loadAtom(){
		self::$atomPath = ROOT_PATH.'/flux.xml';
		// si le fichier n'est pas chargé, on le charge
		if(self::$_atom == null){
			// si il n'y a pas de fichier de flux, on le créer
			if(!is_file(self::$atomPath)){ 
				self::$_atom = self::createAtom();
			}else{
				self::$_atom = self::openXmlFile(self::$atomPath);
			}
		}
	}
	
	public static function createAtom(){
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
		
		self::saveXmlFile($docXML, self::$atomPath);
		return($docXML);
		//$docXML->save('nom_fichier.xml');                    // enregistrement du fichier XM
	}
	
	public static function deleteEntryAtom($idPage){
		self::loadAtom();
		
		$updated = self::$_atom -> getElementsByTagName('updated') -> item(0)->firstChild;		
		$updated -> replaceData ( 0 , 200 , date('c') );
		
		$atomXPath =  new DOMXPath(self::$_atom);
		$query = '*[@ref="'.$idPage.'"]';
		$options = $atomXPath -> query($query);
		
		// si l'entrée existe déjà on la supprime
		// afin que la nouvelle entrée soit placée en haut du fichier
		if($options -> length>0){
			$myEntry = $options -> item(0);
			self::deleteNode($myEntry);
			self::saveXmlFile(self::$_atom, self::$atomPath);
		}else{
		}
	}	
	
	public static function addEntryAtom($idPage, $title, $link, $summary){
		self::loadAtom();
		
		$updated = self::$_atom -> getElementsByTagName('updated') -> item(0)->firstChild;		
		$updated -> replaceData ( 0 , 200 , date('c') );
		
		self::deleteEntryAtom($idPage);

	// Nouvelle entrée
		$query2 = '/feed/entry';
		$optionNodes = self::$_atom -> getElementsByTagName('entry');

		$entry = self::$_atom -> createElement("entry");
		// si il existe déjà un ou des nodes, on insère le nouveau
		// node en tête !
		$n = $optionNodes -> length;
		if($n > 0){
			// on regarde si le nombre de node existant est plus petit que self::$atomMaxItem
			if($n >= self::$atomMaxItem){
				for( $i = self::$atomMaxItem; $i <= $n; $i++ ){
					$refToDelete = $optionNodes -> item($i-1) -> getAttribute('ref');
					//$this -> deleteEntryAtom($refToDelete);
					self::deleteEntryAtom($refToDelete);
				}
			}
			$firstEntry = $optionNodes -> item(0);
			$newEntry = $firstEntry->parentNode->insertBefore($entry, $firstEntry);
		// si il n'existe pas de nodes, on ajoute le nouveau node sous le parent.
		}else{
			$doc = self::$_atom -> getElementsByTagName('feed') -> item(0);
			$newEntry = $doc -> appendChild($entry);
		}
		
			$newEntry -> setAttribute('ref',$idPage);
			
			$nodeTitle = self::$_atom -> createElement("title");
			$entry -> appendChild($nodeTitle);
			
			$nodeTitle -> setAttribute('type','html');
			$textTitle = self::$_atom -> createTextNode($title); 
			$nodeTitle -> appendChild($textTitle);
			
			$nodeId = self::$_atom -> createElement("id");
			$entry -> appendChild($nodeId);
			$textId = self::$_atom -> createTextNode($idPage); 
			$nodeId -> appendChild($textId);
			
			$nodeUpdated = self::$_atom -> createElement("updated");
			$entry -> appendChild($nodeUpdated);
			$textUpdated = self::$_atom -> createTextNode(date('c')); 
			$nodeUpdated -> appendChild($textUpdated);
			
			$nodeLink = self::$_atom -> createElement("link");
			$newLink = $entry -> appendChild($nodeLink);
			$newLink -> setAttribute("rel", "alternate");
			$newLink -> setAttribute("href", $link);
			
			$nodeSummary = self::$_atom -> createElement("summary");
			$entry -> appendChild($nodeSummary);
			$nodeSummary -> setAttribute('type','html');
			$textSummary = self::$_atom -> createTextNode($summary); 
			$nodeSummary -> appendChild($textSummary); 

		self::saveXmlFile(self::$_atom, self::$atomPath);		
	}
	//-------------------------------------
	//--------SITE MAP--------------------
	//-------------------------------------
	public static function loadSiteMap(){
		self::$siteMapPath = BASE_PATH.'/sitemap_total.xml';
		// si le fichier n'est pas chargé, on le charge
		if(self::$_siteMap == null){
			// si il n'y a pas de fichier de flux, on le créer
			if(!is_file(self::$siteMapPath)){ 
				self::$_siteMap = self::createSiteMap();
			}else{
				self::$_siteMap = self::openXmlFile(self::$siteMapPath);
			}
		}
	}
	
	public static function createSiteMap(){
		$docXML = new DomDocument("1.0", "UTF-8");       // constructeur, création d'un document XML
		
		$feed = $docXML->createElement("feed");       // création d'un élément
		/* $feed -> setAttribute('xmlns','http://www.w3.org/2005/Atom'); */
		
		$node = $docXML->createElement("title");       // création d'un élément
		$feed -> appendChild($node);                    // ajout à la racine du document
		$text = $docXML -> createTextNode('Site Map'); 
		$node -> appendChild($text);
		
		$node = $docXML->createElement("updated");       // création d'un élément
		$feed -> appendChild($node);                    // ajout à la racine du document
		$text = $docXML -> createTextNode(date('c')); 
		$node -> appendChild($text);
		
		$node = $docXML->createElement("id");       // création d'un élément
		$feed -> appendChild($node);                    // ajout à la racine du document
		$text = $docXML -> createTextNode(ROOT_URL); 
		$node -> appendChild($text);
		
		/* $node = $docXML->createElement("subtitle");       // création d'un élément
		$feed -> appendChild($node);                    // ajout à la racine du document
		$text = $docXML -> createTextNode('SOUS-TITRE'); 
		$node -> appendChild($text); */

		$docXML -> appendChild($feed);
		
		self::saveXmlFile($docXML, self::$siteMapPath);
		return($docXML);
		//$docXML->save('nom_fichier.xml');                    // enregistrement du fichier XM
	}
	
	public static function generatePublicSiteMap(){
		self::loadSiteMap();
		$siteMapXPath =  new DOMXPath(self::$_siteMap);
		// select tous les noeuds publier et n'ayant aucun droit.
		$query = '*[@publication="1"] | *[@droit="-1"]';
		$public = $siteMapXPath -> query($query);
		if($public -> length > 0){
			$siteMapDom = new DomDocument("1.0", "UTF-8");
			$urlset = $siteMapDom->createElement('urlset');
			$urlset -> setAttribute('xmlns','http://www.sitemaps.org/schemas/sitemap/0.9');
			foreach($public as $pb){
				$link = ROOT_URL.'/'.$pb -> getAttribute('id').'.html';
				
				$url = $siteMapDom -> createElement('url');
				$urlset -> appendChild($url);
				
				$node = $siteMapDom -> createElement('loc');
				$url -> appendChild($node);
				$text = $siteMapDom -> createTextNode($link); 
				$node -> appendChild($text);
				
				$node = $siteMapDom -> createElement('lastmod');
				$url -> appendChild($node);
				$text = $siteMapDom -> createTextNode(date('c')); 
				$node -> appendChild($text);
				
				$node = $siteMapDom -> createElement('changefreq');
				$url -> appendChild($node);
				$text = $siteMapDom -> createTextNode('monthly'); 
				$node -> appendChild($text);
				
				
				$node = $siteMapDom -> createElement('priority');
				$url -> appendChild($node);
				$text = $siteMapDom -> createTextNode('0.5'); 
				$node -> appendChild($text);
				
				
				
			}
			$siteMapDom -> appendChild($urlset);
			
			self::saveXmlFile($siteMapDom, ROOT_PATH.'/sitemap.xml');
		}
	}
	
	public static function deleteEntrySiteMap($idPage){
		self::loadSiteMap();
		
		$updated = self::$_siteMap -> getElementsByTagName('updated') -> item(0)->firstChild;		
		$updated -> replaceData ( 0 , 200 , date('c') );
		
		$siteMapXPath =  new DOMXPath(self::$_siteMap);
		$query = '*[@id="'.$idPage.'"]';
		$options = $siteMapXPath -> query($query);
		
		// si l'entrée existe déjà on la supprime
		// afin que la nouvelle entrée soit placée en haut du fichier
		if($options -> length>0){
			$myEntry = $options -> item(0);
			self::deleteNode($myEntry);
			self::saveXmlFile(self::$_siteMap, self::$siteMapPath);
		}else{
		}
	}	
	
	public static function addEntrySiteMap($idPage, $link, $array){	//$title=NULL, $summary=NULL, $right=NULL, $publication=NULL){
		self::loadSiteMap();
		
		$updated = self::$_siteMap -> getElementsByTagName('updated') -> item(0)->firstChild;		
		$updated -> replaceData ( 0 , 200 , date('c') );
		
		self::deleteEntrySiteMap($idPage);

	// Nouvelle entrée
		$query2 = '/feed/entry';
		$optionNodes = self::$_siteMap -> getElementsByTagName('entry');

		$entry = self::$_siteMap -> createElement("entry");
		// si il existe déjà un ou des nodes, on insère le nouveau
		// node en tête !
		$n = $optionNodes -> length;
		if($n > 0){
			$firstEntry = $optionNodes -> item(0);
			$newEntry = $firstEntry->parentNode->insertBefore($entry, $firstEntry);
		// si il n'existe pas de nodes, on ajoute le nouveau node sous le parent.
		}else{
			$doc = self::$_siteMap -> getElementsByTagName('feed') -> item(0);
			$newEntry = $doc -> appendChild($entry);
		}
		
			$newEntry -> setAttribute('id',$idPage);
			$newEntry -> setAttribute('link',$link);

			$nodeUpdated = self::$_siteMap -> createElement("updated");
			$entry -> appendChild($nodeUpdated);
			$textUpdated = self::$_siteMap -> createTextNode(date('c')); 
			$nodeUpdated -> appendChild($textUpdated);
			
			foreach($array as $key => $val){
				if($key == 'droit'){	// and $array['droit'] == number
					$newEntry -> setAttribute('droit',$val);
				}
				if($key == 'publication'){
					$newEntry -> setAttribute('publication',$val);
				}
				if($key == 'title'){
					$nodeTitle = self::$_siteMap -> createElement("title");
					$entry -> appendChild($nodeTitle);
					$nodeTitle -> setAttribute('type','html');
					$textTitle = self::$_siteMap -> createTextNode($val); 
					$nodeTitle -> appendChild($textTitle);
				}
		
		
				if($key == 'summary'){
					$nodeSummary = self::$_siteMap -> createElement("summary");
					$entry -> appendChild($nodeSummary);
					$nodeSummary -> setAttribute('type','html');
					$textSummary = self::$_siteMap -> createTextNode($val); 
					$nodeSummary -> appendChild($textSummary);
				}
			}

		self::saveXmlFile(self::$_siteMap, self::$siteMapPath);		
	}

}
?>