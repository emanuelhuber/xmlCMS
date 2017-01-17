<?php

class Xml_Gallerie extends Xml_Model{
	
	// TO DO 
	// CREATE SOME CONSTANT LIKE "miniatures"
	
/* 	private $path = null;
	private $_dom = null;
	private $_xPath = null; 
	public $filetime = 0; */
	public $authorArray 	= array();
	public $dateArray 		= array();
	public $tagArray 		= array();
	public $articlesList 	= array();
	public $dirPath 		= null;
	public $domListe 		= null;
	public $xPathListe 		= null;
	public $errorList 		= FALSE;
	public $id_Element		= null;		// id de l'article, p.ex. "la-revolution-francaise-et-ses-consequences"
	public $dirImg			= null;		// id de l'article, p.ex. "la-revolution-francaise-et-ses-consequences"

	
	public function __construct($urlArray, $root='base',$create = FALSE){
		$this -> _getPath($urlArray,$root);
		parent::__construct($urlArray, $root,$create);
	
		if($this -> domListe = self::openXmlFile($this -> dirPath.'/00-index.xml')){
			$this -> xPathListe =  new DOMXPath($this -> domListe);
		}else{
			$this -> errorList = TRUE;
		}
	}
/* 	public function getContent(){
		$query = '/page/contenu/*';	
		$content = $this -> xmlToArray($this->_xPath, $query);
		$query = '/page/contenu/*';	
	} */
	
	public static function createPage($urlArray){
		// 1. Create directory with unique names
		$dirPath = ROOT_PATH.'/data/'.$urlArray[1].'/'.$urlArray[2];
		$dirPath = self::findUniqueDirName($dirPath);
		$dirName = basename($dirPath);
		if(is_dir(ROOT_PATH.'/data/'.$urlArray[1].'/') && (mkdir($dirPath))){
			//2. Create index file
			$indexXml = '<?xml version="1.0" encoding="UTF-8"?>
						<page>
						  <info>
							<titre><![CDATA[Titre collection de gallerie]]></titre>
							<auteur><![CDATA[auteur]]></auteur>
							<date><![CDATA[22.05.2010]]></date>
							<description><![CDATA[Description.]]></description>
							<motsclefs><![CDATA[mots, clefs]]></motsclefs>
							<droit><![CDATA[-1]]></droit>
							<commentaire><![CDATA[0]]></commentaire>
							<publication><![CDATA[0]]></publication>
							<image><![CDATA[#]]></image>
							<miniature><![CDATA[#]]></miniature>
						  </info>
						  <design squelette="squelette.html" article="gallerie.html" index="gallerie-index.html" theme="defaut" style="monStyleDefaut"/>
						  <option nb="100"/>
						  <contenu>
							<chapeau><![CDATA[]]></chapeau>
							<principal>
							</principal>
							<secondaire><![CDATA[]]></secondaire>
						  </contenu>
						</page>';
						
			$dom = new DOMDocument();
			$dom -> loadXML($indexXml); 
			
			$filePath = ROOT_PATH.'/data/'.$urlArray[1].'/'.$dirName.'/00-index.xml';
			
			if(self::saveXmlFile($dom, $filePath)){
				$idPage = $urlArray[0].','.$urlArray[1].','.$dirName;
				$infos = array(//'id'=>	$idPage,
								//'link'=> ROOT_URL.'/'.$idPage.'.html',
								'title'=> 'title',
								'description'=> 'pas de description / brouillon',
								'droit'=> -1,
							//	'summary'=> ,
								'publication'=> 0 );
				self::addEntrySiteMap($idPage, 'title', $infos);
				return $dirName;
			}else{
				return false;
			}
		}
	}
	
	public function moveNodeId($id,$direction){
		$query = '//article[@id="'.$id.'"]';
		$items = $this-> xPathListe -> query($query);
		if($items->length>0){
			// seules les "rubriques" ainsi que les "chapitres" peuvent avoir des enfants!
			$itemBefore = $items -> item(0) -> nextSibling;
			while($itemBefore!=null and $itemBefore -> nodeType != XML_ELEMENT_NODE){
					$itemBefore = $itemBefore -> nextSibling;
			}			
			if($direction == 'up' or $direction == 'down'){
				self::moveNode($items->item(0),$direction);
				self::saveXmlFile($this -> domListe, $this -> dirPath.'/00-index.xml');
			}else{
				/* self::moveNode($item->item(0),$direction);
				self::saveXmlFile($this -> _dom,$this->path); */
			}
			
		}else{
			echo 'CA MARCHE'.$id;
		}
	}
	
	public function getDesign(){
		$design = $this -> domListe -> getElementsByTagName('design') -> item(0);
		return array('theme' => $design -> getAttribute('theme'),
						'style' => $design -> getAttribute('style'),
						'squelette' => $design -> getAttribute('squelette'));
	}
	
	protected function _getPath($urlArray,$root){
		$this -> idPage = $urlArray[0].','.$urlArray[1].','.$urlArray[2];
		self::$_tagPath  = ROOT_PATH.'/data/'.$urlArray[1].'/tags-'.$urlArray[0].'.data';
		if(isset($urlArray[3])){	// si un article est demandé
			$fileName = $urlArray[3];
			$this -> id_Element = $urlArray[3];
			$this -> dirImg = 'data/'.$urlArray[1].'/'.$urlArray[2].'/'.$urlArray[3].'/';
		}else{
			$fileName = '/00-index';
		}
		if($root == 'base'){ 
			$this -> dirPath = BASE_PATH.'/data/'.$urlArray[1].'/'.$urlArray[2];
		}else{
			$this -> dirPath = ROOT_PATH.'/data/'.$urlArray[1].'/'.$urlArray[2];
		}
		$this -> path = $this -> dirPath .'/'.$fileName.'.xml';
	}
	// supprime la collection d'article
	public function delete(){
		parent::delete();
		/* if(is_file($this -> path)){
			unlink($this -> path);
		}else{
			return false;
		} */
		self::clearDir($this -> dirPath.'/');
	}
	
	public function getInfo($node='*'){
		$query = '/page/info/'.$node;	
		$infos = $this -> xmlToArray($this->_xPath, $query);
		if(!empty($this -> id_Element)){
			$infos = array_merge($infos,$this -> xmlToArray($this -> xPathListe, $query, $prefix='collection_'));
		}
		return $infos;
		
		
	}
	
	/* public function getDesign(){
		$design = $this -> domListe -> getElementsByTagName('design');
		$design = $design	-> item(0);
		return array('theme' => $design -> getAttribute('nom'),
						'style' => $design -> getAttribute('style'),
						'squelette' => $design -> getAttribute('squelette'));
	} */
	
	public function setImage($array){
		if(isset($array['id'])){
			$query = '//contenu/images/img[@id="'.$array['id'].'"]';
			$images = $this -> _xPath -> query($query);
			if($images -> length > 0){
				$image = $images -> item(0);
				if(isset($array['alt'])) $image -> setAttribute('alt', $array['alt']);
				if(isset($array['title'])) $image -> setAttribute('title', $array['title']);
				if(isset($array['description'])){
					$image->removeChild($image->firstChild);
					$newText = $this -> _dom -> createCDATASection($array['description']);
					$image->appendChild($newText);
				}
				self::saveXmlFile($this -> _dom, $this -> path);
			}
		
		}
	}
	public function getDirImages(){
		return array('/'.$this -> dirImg, '/'.$this -> dirImg.'miniatures/');
	}
	
	public function getImage(){
		$query = '//contenu/images';
		$nodeImages = $this -> _xPath -> query($query);
		// si le node "image" n'existe pas on le créé
		if($nodeImages -> length == 0){
			$node = $this -> _dom -> getElementsByTagName('contenu')->item(0);
			$nodeImages = $this -> _dom -> createElement("images");
			$node -> appendChild($nodeImages);
			self::saveXmlFile($this -> _dom, $this -> path);
			
		}
		$nodeImages = $this -> _xPath -> query($query);
		$nodeImages = $nodeImages -> item(0);
		// FROM THE FOLDER
		$dossier = opendir(ROOT_PATH.'/'.$this -> dirImg);
		$imageArray = array();
		while ($filename = readdir($dossier)) {
			//$pathCss = $folder.$style;
			if($filename != "." && $filename != ".." && file_exists(ROOT_PATH.'/'.$this -> dirImg.'miniatures/'.$filename) && !is_dir(ROOT_PATH.'/'.$this -> dirImg.$filename)) { 
				$query = '//contenu/images/img[@id="'.$filename.'"]';
				$images = $this -> _xPath -> query($query);
				if($images -> length > 0){
					//echo $filename;
					$nodeIMG = $images -> item(0);
					$imageArray[$filename] = array('id' => $filename,
										'src' => $this -> dirImg.$filename,
										'src_miniature' => $this -> dirImg.'miniatures/'.$filename,
										'title' =>$nodeIMG -> getAttribute('title'),
										'alt' => $nodeIMG -> getAttribute('alt'),
										'description' => $nodeIMG  -> nodeValue
										); 
				}else{
					$nodeIMG = $this -> _dom -> createElement("img");
					$nodeImages -> appendChild($nodeIMG);
					
					$nodeIMG -> setAttribute('id',$filename);
					// $nodeIMG -> setAttribute('src',$this -> dirImg.$filename);
					// $nodeIMG -> setAttribute('src_miniature',$this -> dirImg.'miniatures/'.$filename);
					$nodeIMG -> setAttribute('alt','');
					$nodeIMG -> setAttribute('title','');
					$nodeDescription = $this -> _dom -> createCDATASection('');
					$nodeIMG -> appendChild($nodeDescription);
					
					$imageArray[$filename] = array('id' => $filename,
										'src' => $this -> dirImg.$filename,
										'src_miniature' => $this -> dirImg.'miniatures/'.$filename,
										'title' => '',
										'alt' => '',
										'description' => ''
										);
				}
			}
		}
		if(!empty($imageArray))		uksort($imageArray,array( __CLASS__, 'wd_unaccent_compare_ci'));
		closedir($dossier);

		if(count($imageArray) > 0){
			// si dans les meta-donnees, l'info image est vide
			// on ajoute la premiere image de la liste.
			$nodeInfoImage = $this -> _dom -> getElementsByTagName('image')->item(0);
			$firstItem = each($imageArray);
			if($nodeInfoImage -> textContent == '#' or $nodeInfoImage -> textContent == ''){
				if($nodeInfoImage->hasChildNodes()) $nodeInfoImage ->removeChild($nodeInfoImage->firstChild);
				$newText = $this -> _dom -> createCDATASection($imageArray[$firstItem[0]]['id']);
				$nodeInfoImage->appendChild($newText);
			}
			$query = '//contenu/principal/article[@id="'.$this -> id_Element.'"]/image';
			$nodeInfoImage = $this -> _dom -> getElementsByTagName('image')->item(0);
			$nodeImageList = $this -> xPathListe -> query($query);
			if($nodeImageList -> length > 0){
				//echo $nodeInfoImage -> textContent;
				$nodeImageList = $nodeImageList -> item(0);

				if( ($nodeImageList ->  textContent == '' or $nodeImageList ->  textContent == '#') && $nodeInfoImage -> textContent != '' && $nodeInfoImage -> textContent!= '#'){
					//echo $nodeImageList -> nodeName;
					if($nodeImageList->hasChildNodes())	$nodeImageList ->removeChild($nodeImageList->firstChild);
					$newText = $this -> domListe -> createCDATASection($nodeInfoImage -> textContent );
					$nodeImageList -> appendChild($newText);

					self::saveXmlFile($this -> domListe, $this -> dirPath.'/00-index.xml');
				}
			}
			
		}else{
			//return FALSE;
		}
		self::saveXmlFile($this -> _dom, $this -> path);
		
		return $imageArray;
		//array_unique(array_merge($array1, $array2));
		
		// FROM THE XML FILE
		/* $query = '//contenu/images/img';
		$images = $this -> _xPath -> query($query);
		if($images -> length > 0){
			$imageArray = array();
	
			foreach($images as $image){
				$key = $image -> getAttribute('id');
				$imageArray[$key] = array('id' => $key,
										'src' => $this -> dirImg.$key,
										'src_miniature' => $this -> dirImg.'miniatures/'.$key,
										'title' =>$image -> getAttribute('title'),
										'alt' => $image -> getAttribute('alt'),
										'description' => $image  -> nodeValue
										); 
			}
			
			return $imageArray;
		}else{

			return false;
		} */
	}
	
	public function getArticle($id){
		$idArticle = basename($this -> path, '.xml');
		//echo $idArticle;
		$query = '//principal/article[@id="'.$idArticle.'"]';
		$articles = $this -> xPathListe -> query($query);
		if($articles -> length > 0){
			return $article = $articles -> item(0);
		}else{
			return false;
		}
	}
	// create an xml file for the infos on the photos
	// plus a folder that will contain the photos
	public function createArticle($idFile, $title, $auteur, $date){
		$xmlChain = '<?xml version="1.0" encoding="UTF-8"?>
					<page>
					  <info>
						<titre><![CDATA['.$title.']]></titre>
						<auteur><![CDATA['.$auteur.']]></auteur>
						<date><![CDATA['.$date.']]></date>
						<description><![CDATA[Description of the article]]></description>
						<motsclefs><![CDATA[keyword]]></motsclefs>
						<droit><![CDATA[-1]]></droit>
						<commentaire><![CDATA[0]]></commentaire>
						<publication><![CDATA[0]]></publication>
						<image><![CDATA[#]]></image>
						<miniature><![CDATA[#]]></miniature>
					  </info>
					  <design theme="defaut" style="monStyleDefaut" squelette="squelette.html" article="gallerie.html" index="gallerie.html"/>
					  <contenu>
						<chapeau><![CDATA[]]></chapeau>
						<principal><![CDATA[]]></principal>
						<secondaire><![CDATA[]]></secondaire>
					  </contenu>
					</page>';
		$dom = new DOMDocument();
		$dom -> loadXML($xmlChain); 
		$filePath = $this -> dirPath.'/'.$idFile;
		$ext = 'xml';
		$fileDest0 = self::findUniqueFileName($filePath,$ext);
		$fileDest = $fileDest0.'.'.$ext;
		$fileDestMiniature = $fileDest0.'/'.'miniatures';
		$fileName =  basename($fileDest,'.'.$ext);
		
			//echo $fileDest;
			//echo $fileDest0;
		
		
		if(self::saveXmlFile($dom, $fileDest) && mkdir($fileDest0) && mkdir($fileDestMiniature)){
			$idPage = $this->idPage.','.$idFile;
			$infos = array(//'id'=>	$idPage,
							//'link'=> ROOT_URL.'/'.$idPage.'.html',
							'title'=> 'title',
							'description'=> 'pas de description / brouillon',
							'droit'=> -1,
						//	'summary'=> ,
							'publication'=> 0 );
			self::addEntrySiteMap($idPage, 'title', $infos);
			$this -> addArticleItem($fileName,$title, $auteur, $date);
			return $fileName;
			echo 'Yesssss!';
		}else{
			return false;
		}
	}
	// XXX
	public function deleteArticle($id){
		$myArticle = $this -> getArticle($id);
		if($myArticle != false){
			$myArticle->parentNode->removeChild($myArticle); 	// supprimer du fichier index
			/* echo 'yesssssssssssssssssssssssssssssssss!!!!!!!!!!!!!!!!!!';
			echo $this -> idPage; */
			self::saveXmlFile($this -> domListe, $this -> dirPath.'/00-index.xml');
			// supprime le fichier
			if(unlink($this -> dirPath.'/'.$id.'.xml')){
				self::removeId($this -> idPage.','.$id);
				return true;
			}else{
				return false;
			}
			//$this -> delete($this -> dirPath.'/'.$id);
		}
	}
	/* public function setPublish($id,$array){
		$this -> setInfo($id,$array, true);
	} */
	public function publish(){
		$id = $this -> idPage;
		if(!empty($this -> id_Element)) $id .= ','.$this -> id_Element;
		$infos = $this -> getInfo();
		if($infos['droit']<0 && $infos['publication'] == 1) {				
			$title= htmlentities($infos['titre'], ENT_QUOTES, "UTF-8");
			$link = ROOT_URL.'/'.$id.'.html';
			$summary = htmlentities($infos['description'], ENT_QUOTES, "UTF-8");

			self::addEntryAtom($id, $title, $link, $summary);
		}
	}
	
	public function unpublish(){
		$id = $this -> idPage;
		if(!empty($this -> id_Element)) $id .= ','.$this -> id_Element;
		$infos = $this -> getInfo();
		if($infos['publication'] == 0) {	
			self::deleteEntryAtom($id);
		}
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
						if(!empty($this -> id_Element)){
							$id = $this -> idPage.','.$this -> id_Element;
						}else{
							$id = $this -> id_Element;
						}	
						self::updateTags($value,$id);
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
		self::addEntrySiteMap($this -> idPage,ROOT_URL.'/'.$this -> idPage.'.html', $array);
		
		/// Si un article a été modifié, alors l'index est modifié
		// en fonction.
		$myArticle = $this -> getArticle($this -> idPage);
		if($myArticle != false){
			foreach($array as $key => $value){
				if($myArticle -> getElementsByTagName($key)->item(0) != null){
					$node = $myArticle -> getElementsByTagName($key)->item(0);
					if($node -> hasChildNodes()){
						$node->removeChild($node->firstChild);
					}
					$newText = $this -> domListe -> createCDATASection($value);
					$node->appendChild($newText);
				}
			}
			self::saveXmlFile($this -> domListe, $this -> dirPath.'/00-index.xml');
		}
		
		
	} 
	
	public function addArticleItem($id, $title='Titre de l\'article',$auteur='Auteur de l\'article',$date =null, $droit='-1'){
		$myNode = $this -> domListe -> createElement('article');
		$domArticles = $this -> domListe -> getElementsByTagName('principal') -> item(0)-> getElementsByTagName('article');
		// Si il existe déjà des noeuds articles,
		// on insère le nouveau noeud au début de la liste
		if($domArticles -> length > 0){
			$firstChild = $domArticles -> item(0);
			$firstChild -> parentNode -> insertBefore($myNode, $firstChild);
		// sinon on insère le noeud (tout simplement)
		}else{
			$domPrincipal = $this -> domListe -> getElementsByTagName('principal') -> item(0);
			$myNode = $domPrincipal -> appendChild($myNode);
		}
		
		
		//$this -> _activeNode -> setAttribute('id','a'.($this -> _dom -> length - 1));
		
		$myNode -> setAttribute('id',$id);
		$myNode -> setAttribute('fichier','xml');
/* 		$myNode -> setAttribute('date',date('d.m.Y'));
		$myNode -> setAttribute('publication','0'); */
		if(!empty($date)) $date = date('j.m.Y');
		$nodeChildren = array('titre'		=> $title,
							  'description'	=> 'Description de l\'article',
							  'motsclefs'	=> 'Mots-clefs de l\'article',
							  'auteur'		=> $auteur,
							  'date'		=> $date,
							  'droit'		=> $droit,
							  'publication' => '0',
							  'image'		=> '',
							  'miniature'	=> '');
		
		foreach($nodeChildren as $key=>$value){
			$childNode = $this -> domListe -> createElement($key);
			$childNode = $myNode -> appendChild($childNode);
			if($value!=''){
				$newText = $this -> domListe -> createCDATASection($value);
				$childNode->appendChild($newText);
			}
		}
		
		self::saveXmlFile($this -> domListe, $this -> path);
	}
	public function getNumberOfArticles(){
		$query = '/page/contenu/principal/article';
		$articles = $this -> xPathListe -> query($query);
		if($articles -> length > 0){
			return $articles -> length;
		}else{
			return false;
		}
	}
	public function setArticlesList(){		
		$query = '/page/contenu/principal/article';
		$articles = $this -> xPathListe -> query($query);
		$articleArray = array();
	
		foreach($articles as $article){
			$key = $article -> getAttribute('id');
			// XXX
			$myDate = explode('.',$article -> getElementsByTagName('date')-> item(0) -> nodeValue);
			if(isset($myDate[1]) && isset($myDate[2])){
				$this -> dateArray['year'][$myDate[2]][$key] = $key;
				$this -> dateArray['month'][$myDate[2]][$myDate[1]][$key] = $key;
			}
			
			$myTags = explode(',',$article -> getElementsByTagName('motsclefs') -> item(0) -> nodeValue);
			foreach($myTags as $tag){
				$tag = trim($tag);
				$this -> tagArray[$tag][$key] = $key;
			}
			
			$this -> authorArray[$article -> getElementsByTagName('auteur') -> item(0) -> nodeValue][$key] = $key;
			$articleArray[$key] = array('id' => $article -> getAttribute('id'),
									'fichier' => $article -> getAttribute('fichier'),
									'publication' => $article -> getElementsByTagName('publication')-> item(0) -> nodeValue,
									'date' => $article -> getElementsByTagName('date')-> item(0) -> nodeValue,
									'year' => $myDate[2],
									'month' => $myDate[1],
									'timestamp' =>  mktime(0, 0, 0, $myDate[1], $myDate[0], $myDate[2]),
									//'auteurid' => $article -> getAttribute('auteurid'),
									'titre' => $article -> getElementsByTagName('titre') -> item(0) -> nodeValue,
									'description' => $article -> getElementsByTagName('description') -> item(0) -> nodeValue,
									'tags' => $article -> getElementsByTagName('motsclefs') -> item(0) -> nodeValue,
									'author' => $article -> getElementsByTagName('auteur') -> item(0) -> nodeValue,
									'droit' => $article -> getElementsByTagName('droit') -> item(0) -> nodeValue,
									'image' => $article -> getElementsByTagName('image') -> item(0) -> nodeValue,
									'miniature' => $article -> getElementsByTagName('miniature') -> item(0) -> nodeValue,
									); 
		}
	//	$articleArray = $this -> sort2DArray$articleArray, 'timestamp', $reverse=true);
		$this -> articlesList = $articleArray;
		//return $articleArray; 
		
		$query = '/page/info/titre';
		$titre = $this -> xPathListe -> query($query);
		if($titre->length>0){
			return $titre->item(0)-> nodeValue;
		}
	}
	
	public function getSelectionArticleList($by='',$where=false,$ord='asc'){
		//$articlesList = $this -> getArticlesList();
		
		if(empty($this -> articlesList)) $this -> setArticlesList();
		
		switch($by){
			case 'author':
				if($where === false){
					uksort($this -> authorArray,array( __CLASS__, 'wd_unaccent_compare_ci'));
					return $this -> authorArray;					
				}elseif(isset($this -> authorArray[$where])){
					return $this -> authorArray[$where];
				}else{
					return false;
				}
				break;
			case 'tag':
				if($where === false){
					uksort($this -> tagArray,array( __CLASS__, 'wd_unaccent_compare_ci'));
					return $this -> tagArray;
				}elseif(isset($this -> tagArray[$where])){
					return $this -> tagArray[$where];
				}else{
					return false;
				}
				break;
			case 'year':
				if(isset($this -> dateArray['year'][$where])){
					return $this -> dateArray['year'][$where];
				}else{
					return false;
				}
				break;
			case 'month':
				$where = explode('.',$where);
				if(is_array($where) && isset($this -> dateArray['month'][$where[0]][$where[1]])){
					return $this -> dateArray['month'][$where[0]][$where[1]];
				}else{
					return false;
				}
				break;
			case 'date':
				krsort($this -> dateArray['year']);
				return $this -> dateArray;
			default:
				return $this -> articlesList;
				break;
		}
		//return $articlesList;
		/* $path = dirname($this -> path).'/index.data';
		self::writeArray($articleArray, $path);
		
		self::sort2DArray($articleArray, 'auteur');
		$path = dirname($this -> path).'/index-auteur.data';
		self::writeArray($articleArray, $path); */
	
	}
	


	
	
	
	

}
?>