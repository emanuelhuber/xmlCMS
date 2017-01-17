<?php
class Xml_Upload extends Xml_Model{
	
	
/* 	private $path = null;
	private $_dom = null;
	private $_xPath = null; 
	public $filetime = 0; */
	private $_id = '';
	private $_lg = '';
	private $_activNode = null;
	private static $_menu = array();
	private static $_depth = 0;
	
	public function __construct(){
		$this -> path = ROOT_PATH.'/data/upload/index.xml';
		// $this -> _id = 	$id;
		if($this -> _dom = self::openXmlFile($this -> path)){
			$this -> _xPath =  new DOMXPath($this -> _dom);
			$this -> setActivNode();
			//echo $this -> path;
		}else{
			echo 'Problem!!! Pour la construction de l objet de la classe Xml_Menu';
		}
	}

	
	public function fileCategorie(){
		$query = '//files/*';
		$items = $this -> _xPath -> query($query);
		
		$cats = array();

		foreach($items as $item){
			$cats[] = $item -> getAttribute('id');
		}
		return $cats;
	}
	
	public function getFiles($cat=false){
		if($cat){
			$dossier = opendir(dirname($this -> path).'/'.$cat);
			$cats = array();
			while ($filename = readdir($dossier)) {
				// si le fichier se trouve dans l'index
				if($filename != "." && $filename != ".." ){	// && !is_dir(ROOT_PATH.'/'.$this -> dirImg.$filename)) { 
					$filenamePart = pathinfo($filename);
					//echo dirname($this -> path).'/'.$cat ;
					$query = '//files/cat[@id="'.$cat.'"]/item[@id="'.$filenamePart['filename'].'"]';
					$items = $this -> _xPath -> query($query);
					if($items -> length > 0){
						$item = $items -> item(0);
						$cats[$item -> getAttribute('id')] = array('ext' => $item -> getAttribute('ext'),
																   'title' => $item -> getAttribute('title'),
																   'copyright' => $item -> getAttribute('copyright'),
																   'date' => $item -> getAttribute('date'),
																   'description' => $item ->  textContent);
					
					// sinon on l'ajoute dans l'index
					}else{
						$data = array('id' => $filenamePart['filename'],
								  'categorie' => $cat,
								  'ext' => $filenamePart['extension'],
								  'title' => $filenamePart['filename'],
								  'copyright' => '',
								  'date' => date('d.m.y'));
						if($cat == 'image' &&  in_array(strtolower($filenamePart['extension']),array('jpg','jpeg','jpe','gif','png'))){
							$filePath = dirname($this -> path).'/'.$cat.'/'.$filename;
							$miniaturePath = dirname($this -> path).'/'.$cat.'/miniatures/'.$filenamePart['filename'].'.jpg';
							if(is_file($miniaturePath))	unlink($miniaturePath); 	// Si le fichier existe déjà
							$ratio  = 96;  // en pixel
							$imageSizes = getimagesize($filePath);	// taille de l'image
							 // on teste si notre image est de type paysage ou portrait 
							if ($imageSizes[0] > $imageSizes[1]) { 
								$newY = round(($ratio/$imageSizes[0])*$imageSizes[1]);
								$newX = $ratio;
							}else{
								$newX = round(($ratio/$imageSizes[1])*$imageSizes[0]);
								$newY = $ratio;
							}						
							switch(strtolower($filenamePart['extension'])){
								case 'jpg':
								case 'jpeg': //pour le cas où l'extension est "jpeg"
								case 'jpe': //pour le cas où l'extension est "jpeg"
									$src_im = imagecreatefromjpeg ($filePath);
									$this -> thumbnail($src_im, $imageSizes, $newX, $newY, $miniaturePath );
									$this -> addFile($cat, $data, '');
									$cats[$filenamePart['filename']] = array('ext' => $filenamePart['extension'],
																	   'title' => $filenamePart['filename'],
																	   'copyright' => '',
																	   'date' => date('d.m.y'),
																	   'description' => '');
									break;
								case 'gif':
									$src_im = imagecreatefromgif($filePath);
									$this -> thumbnail($src_im, $imageSizes, $newX, $newY, $miniaturePath );
									$this -> addFile($cat, $data, '');
									$cats[$filenamePart['filename']] = array('ext' => $filenamePart['extension'],
																	   'title' => $filenamePart['filename'],
																	   'copyright' => '',
																	   'date' => date('d.m.y'),
																	   'description' => '');
									break;
								case 'png':
									$src_im = imagecreatefrompng($filePath);
									$this -> thumbnail($src_im, $imageSizes, $newX, $newY, $miniaturePath );
									$this -> addFile($cat, $data, '');
									$cats[$filenamePart['filename']] = array('ext' => $filenamePart['extension'],
																	   'title' => $filenamePart['filename'],
																	   'copyright' => '',
																	   'date' => date('d.m.y'),
																	   'description' => '');
									break;
								default:
									echo 'L\'image n\'est pas dans un format reconnu. Extensions autorisées : jpg/jpeg, gif, png<br/>';
									echo strtolower($filenamePart['extension']);
									break;
							} 
							// $im = imagecreatetruecolor($newX, $newY); 
							// imagecopyresampled($im, $src_im, 0, 0, 0, 0, $newX, $newY, $imageSizes[0], $imageSizes[1]); 
							// imagepng($im, $miniaturePath);    //  save new image
						}else{
							$this -> addFile($cat, $data, '');
							$cats[$filenamePart['filename']] = array('ext' => $filenamePart['extension'],
																	   'title' => $filenamePart['filename'],
																	   'copyright' => '',
																	   'date' => date('d.m.y'),
																	   'description' => '');
						}
					}
				}
			}
			
			/* $query = '//files/cat[@id="'.$cat.'"]/item';
			$items = $this -> _xPath -> query($query);

			foreach($items as $item){
			} */

			return $cats;
		}else{
			$query = '//files/cat/item';
		}
	}
	public function thumbnail($src_im, $imageSizes, $newX, $newY, $miniaturePath ){
		$im = imagecreatetruecolor($newX, $newY); 
		imagecopyresampled($im, $src_im, 0, 0, 0, 0, $newX, $newY, $imageSizes[0], $imageSizes[1]); 
		imagepng($im, $miniaturePath);    //  save new imag
	}
	public function getFile($cat, $id){
		$query = '//files/cat[@id="'.$cat.'"]/item[@id="'.$id.'"]';
		$items = $this -> _xPath -> query($query);
		if($items->length>0){
			$item = $items->item(0);
			return array('ext' => $item -> getAttribute('ext'),
					   'title' => $item -> getAttribute('title'),
						'copyright' => $item -> getAttribute('copyright'),
						'date' => $item -> getAttribute('date'),
						'description' => $item ->  textContent);
		}else{
			return false;
		}

		
	}
	
 	public function removeFile($cat,$id){
		$query = '//files/cat[@id="'.$cat.'"]/item[@id="'.$id.'"]';
		$items = $this -> _xPath -> query($query);
		if($items->length>0){
			$this -> deleteNode($items->item(0),true);
			self::saveXmlFile($this -> _dom,$this->path);
		}else{
			return false;
		}
	} 
	
	public function addFile($cat, $data, $description){
		$file = $this -> _dom -> createElement('item');
		
		$query = '//files/cat[@id="'.$cat.'"]';
		$items = $this -> _xPath -> query($query);
		if($items->length>0){
			$items -> item(0) -> appendChild($file);
			foreach($data as $key => $val){
				$file -> setAttribute($key ,$val);
			}
			$texte = $this -> _dom -> createCDATASection($description);
			$file -> appendChild($texte);
			self::saveXmlFile($this -> _dom,$this->path);
		}else{
			return false;
		}
	}
	
	
	public function editFile($cat, $id, $data, $description){
		$query = '//files/cat[@id="'.$cat.'"]/item[@id="'.$id.'"]';
		$items = $this -> _xPath -> query($query);
		if($items->length>0){
			$item = $items -> item(0);
			// Attribut title, copyright
			foreach($data as $key => $val){
				$item -> setAttribute($key, $val);
			}
			// CDATA description
			if($item -> hasChildNodes()){
				$item->removeChild($item->firstChild);
			}
			$newText = $this -> _dom -> createCDATASection($description);
			$item->appendChild($newText);
			self::saveXmlFile($this -> _dom,$this->path);
			
		}else{
			return false;
		}
	
	}
	
	public function deleteNodeId($id, $withChildren=false){
		$query = '/menu/langue//*[@id="'.$id.'"]';
		$item = $this->_xPath -> query($query);
		//$pageMenu = $menuXPathDom -> query($query);	// DomNodeList
		if($item->length>0){
			$this -> deleteNode($item->item(0),$withChildren);
			self::saveXmlFile($this -> _dom,$this->path);
		}else{
			return false;
		}
	}
	
	public function moveNodeId($id,$direction){
		$query = '/menu/langue//*[@id="'.$id.'"]';
		$item = $this->_xPath -> query($query);
		if($item->length>0){
			// seules les "rubriques" ainsi que les "chapitres" peuvent avoir des enfants!
			$itemBefore = $item -> item(0) -> nextSibling;
			while($itemBefore!=null and $itemBefore -> nodeType != XML_ELEMENT_NODE){
					$itemBefore = $itemBefore -> nextSibling;
			}
			if(($direction == 'right' && ($itemBefore->getAttribute('module')=='rubrique'
				or $itemBefore->getAttribute('module')=='chapitre'))
				or $direction == 'left' or $direction == 'up' or $direction == 'down'){
				self::moveNode($item->item(0),$direction);
				self::saveXmlFile($this -> _dom,$this->path);
			}else{
				/* self::moveNode($item->item(0),$direction);
				self::saveXmlFile($this -> _dom,$this->path); */
			}
			
		}else{
			//echo 'CA MARCHE';
		}
	}
	
	public function setActivNode(){
		$query = '/menu//page[@id="'.$this -> _id.'"]';		// We starts from the root element
		$reponse = $this->_xPath -> query($query);	// DomNodeList
		if($reponse->length>0){	// si il y a au moins 1 noeud dans le menu
			$this -> _activNode = $reponse -> item(0);
			return true;
		}else{
			//echo 'pas dans le menu';
			$this -> _activNode = null;
			return false;
		}
	}
	
	public function getMenuItem($id){
		$query = '/menu/langue//*[@id="'.$id.'"]';
		$item = $this->_xPath -> query($query);
		//$pageMenu = $menuXPathDom -> query($query);	// DomNodeList
		if($item->length>0){
			$item = $item -> item(0);
			return array('id' => $item -> getAttribute('id'),
						 'module' => $item -> getAttribute('id'),
						 'nom' => $item -> getAttribute('nom'),
						 'soeur' => $item -> getAttribute('soeur'),
						 'menu' => $item -> getAttribute('menu'),
						 'publication' => $item -> getAttribute('publication'),
						 'droits' => $item -> getAttribute('droits')
						 );
		}else{
			return false;
		}
		
	}
	
	public function setMenuItemAttribute($id,$array){
		$query = '/menu/langue//*[@id="'.$id.'"]';
		$item = $this->_xPath -> query($query);
		//$pageMenu = $menuXPathDom -> query($query);	// DomNodeList
		if($item->length>0){
			$item = $item -> item(0);
			foreach($array as $key => $value){
				$item -> setAttribute($key,$value);
			}
		}
		self::saveXmlFile($this -> _dom,$this->path);
	}
	
	public function addMenuItem($lg, $array=array(),$id,$name = 'page'){
		$query = '/menu/langue[@id="'.$lg.'"]';
		$mother = $this->_xPath -> query($query);
		//$pageMenu = $menuXPathDom -> query($query);	// DomNodeList
		if($mother->length>0){
			$mother = $mother -> item(0);
			$node = $this -> _dom -> createElement($name);
			$newnode = $mother->appendChild($node);
			$newnode -> setAttribute('id', $id);
			foreach($array as $key => $value){
				$newnode -> setAttribute($key, $value);
			}
			self::saveXmlFile($this -> _dom,$this->path);
			echo 'YES';
			return true;
		}else{
			echo 'NNNULLLL';
			return false;
		}
	}
	
	public function getLanguages(){
		//self::$arrayToParse['LANGUE_ABR'] 	=	$this -> _lg;
		$query = '/menu//langue';		// We starts from the root element
		$langues = $this->_xPath -> query($query);
		$lgArray = array();
		foreach($langues as $lang){
			// si une page soeur est définie
			if($this -> _activNode != null && $this -> _activNode->getAttribute('soeur-'.$lang->getAttribute('id'))){
				$link = $this -> _activNode -> getAttribute('soeur-'.$lang->getAttribute('id'));
			// sinon on prend la première page de la langue itérée
			}else{
				$link = $lang -> getElementsByTagName('page') -> item(0) -> getAttribute('id');
			}
			// langue en cours
			$activ = false;
			if($lang->getAttribute('id') == $this -> _lg){
				$activ = true;
			}
			$lgArray[] = array('name' => $lang->getAttribute('nom'),
								'active' => $activ,
								'id' 	=> $lang->getAttribute('id'),
								'link'	=> $link
								);	
		}
		return $lgArray;
	}
	
	public function getBreadCrumbs(){
		$query = '//page[@id="'.$this -> _id.'"]/ancestor::*';			// We starts select all the ancestor of the current page
		$ancestors = $this->_xPath -> query($query);
		// $lg = $ancestors ->item(1)->childNodes->item(1);
		$breadCrumbs = array();
		foreach($ancestors as $an){
			if($an->hasChildNodes()){
				$children = $an -> childNodes;
				$page = $an -> getElementsByTagName('page');
				if($page -> length > 0){
					$breadCrumbs[] = array('id' 	=> $an -> getAttribute('id'),
								   'name'	=> $an -> getAttribute('nom'),
								   'type' 	=> $an -> nodeName,
								   'module' => $an -> getAttribute('module'),
								   'link'	=> $page -> item(0) -> getAttribute('id')
									);
				}
			}
		} 
		return $breadCrumbs;
	}
	
	public function getChapters(){
		$chapterArray = array();
		$menuArray = array();
		
		// 1. On sélectionne la langue
		$query = '//langue[@id="'.$this -> _lg.'"]';			// We starts from the root element
		$langue = $this->_xPath -> query($query);
		$langue = $langue -> item(0);
		// Si la langue a des fils
		if($langue -> hasChildNodes()){
			$itemsLevel1 = $langue -> childNodes;
			// on regarde si la langue contient des chaptires
			$chapters = $langue -> getElementsByTagName('chapter');
			// si la langue contient des chapitres,
			if($chapters -> length>0){
				// on passe les chapitres en revue (pour en obtenir la liste
				foreach($chapters as $chap){
					// on regarde si le chapitre contient des fils de type "page"
					// dont la publication et l'affichage dans le menu sont autorisé (1)
					$query = '//chapter[@nom="'.$chap->getAttribute('nom').'"]//page[@publication="1" and @menu="1"]';	
					$pagesInChap = $this->_xPath -> query($query);
					// si le chapitre contient des pages, alors
					if($pagesInChap -> length > 0){
						$query = '//chapter[@nom="'.$chap->getAttribute('nom').'"]//*[@id="'.$this -> _id.'"]';			// We starts from the root element
						$chapActiv = $this->_xPath -> query($query);
						// si on a trouvé le chapitre actif
						$activ=false;
						if($chapActiv->length > 0){
							$menu = $chap -> childNodes;	
							$activ=true;
							$menuArray=$this -> getMenu($menu);
						}
						$chapterArray[]= array('link' => $pagesInChap -> item(0)->getAttribute('id') ,
											   'name'  => $chap->getAttribute('nom'),
											   't_class' => $activ);
					}
				}
			}
			else{
				// si il n'y a pas de chapitre dans la langue
				// on affiche le menu correspondant aux fils de la
				// langue
				$menuArray=$this -> getMenu($itemsLevel1);
			}
		}
		
		// sinon ?
		// on redirige la page vers l'accueil??
		
		return array('chapters' => $chapterArray,
					 'menu'		=> $menuArray);
	}
	
	private function isAccessAuthorized($pageRight){
		//return ($this -> _userRight & pow(2, $pageRight)) or pageRight<0);
	}
	
	public function getMenu($menu, $lg=''){
		if(!empty($lg)){
			self::$_menu = array();	// Réinitialise l'attribut
			$query = '//langue[@id="'.$lg.'"]';			// We starts from the root element
			$langue = $this->_xPath -> query($query);
			$menu = $langue -> item(0) -> childNodes;
		}

		foreach($menu as $elt){			// DomElement
			self::$_depth = 0;
			$this->parcourirMenu($elt);
		}
		return self::$_menu;
	}
	
	private function parcourirMenu($noeud){
		if($noeud->nodeType == XML_ELEMENT_NODE){
			// fonction pour créer automatiquement l'attribut de bloc
			// du template en fonction de la profondeur du menu.
			// 1 => menu1, 2=>menu1.menu2, 3=> menu1.menu2.menu2
			//$index = $this -> blockName('menu',$depth);
			$hasChild = false;
			$active = false;
			$childActive = false;
			// si le noeud est actif
			if($noeud->getAttribute('id') == $this -> _id){
				$active = true;
			//si un de ses petits fils est actif
			}elseif($noeud->hasChildNodes()){
				$hasChild = true;
				$query = '//*[@id="'.$noeud -> getAttribute('id').'"]//page[@id="'.$this -> _id.'"]';			// We starts from the root element
				$activChild = $this->_xPath -> query($query);
				if($activChild->length > 0){
					$childActive = true;
				}
			}elseif($noeud-> parentNode-> nodeName == 'chapter' && $noeud-> parentNode->getAttribute('id') == $this -> _id){
				$active = true;
			}
			//if($noeud -> nodeName == 'chapter') self::$_depth--;
			self::$_menu[] = array('name' 		=> $noeud -> getAttribute('nom'),
								  'type' 		=> $noeud -> nodeName,
								  'id'   		=> $noeud -> getAttribute('id'),
								  'module' 		=> $noeud -> getAttribute('module'),
								  'depth' 		=> self::$_depth,
								  'hasChild' 	=> $hasChild,
								  'active' 		=> $active,
								  'childActive' => $childActive,
								  'menu'		=> $noeud -> getAttribute('menu'),
								  'publication'	=> $noeud -> getAttribute('publication'),
								  'rights'		=> $noeud -> getAttribute('droits')
								  );
	
				// si le noeud a des fils
				if($noeud->hasChildNodes()){
					self::$_depth++;
					$enfants = $noeud->childNodes;
					foreach($enfants as $enfant){	// on parcourt les enfants...
					  $this->parcourirMenu($enfant);
					}
					self::$_depth--;
				}
		}
	}
	
	public function blockName($name,$depth){
		$blName = $name.$depth;
		if($depth==1){
			return $blName;
		}elseif($depth > 1){
			$blName = $name.'1';
			for($i = 2; $i <= $depth; $i++){
				$blName .= '.'.$name.$depth;
			}
			return $blName;
		}else{
			return false;
		}
		
	}
	
	
	
	
	

}
?>