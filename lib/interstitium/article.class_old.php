<?php
class Xml_Article extends Xml_Model{
	
/* 	private $path = null;
	private $_dom = null;
	private $_xPath = null; 
	public $filetime = 0; */
	public $authorArray = array();
	public $dateArray = array();
	public $tagArray = array();
	public $articlesList = array();
	public $dirPath = null;
	public $domListe = null;
	public $xPathListe = null;

	
	public function __construct($urlArray, $root='base'){
		$this -> _getPath($urlArray,$root);
		parent::__construct($urlArray, $root);
		
		
		if(isset($urlArray[3])){	// si un article est demandé
			$this -> path = BASE_PATH.'/data/'.$urlArray[1].'/'.$urlArray[2].'/'.$urlArray[3].'.xml';
			// $this -> _templateNameModule 	= 'article';
			// $this -> _id = $urlArray[3];	// id de l'article
		}else{
			/* $this -> _templateNameModule 	= 'index'; */
			$this -> path = BASE_PATH.'/data/'.$urlArray[1].'/'.$urlArray[2].'/00-index'.'.xml';
		}
		
		//$this -> path = $path;
		$this -> dirPath = BASE_PATH.'/data/'.$urlArray[1].'/'.$urlArray[2];
		if($this -> _dom = self::openXmlFile($this -> path)){
			$this -> _xPath =  new DOMXPath($this -> _dom);
			$this -> filetime = self::getFileTime($this -> path);
		}else{
			echo 'Problem!!! '.$this -> path.'<br/>';
		}
		if($this -> domListe = self::openXmlFile($this -> dirPath.'/00-index.xml')){
			$this -> xPathListe =  new DOMXPath($this -> domListe);
			//$this -> filetime = self::getFileTime($this -> path);
		}else{
			$this -> xPathListe = null;
			$this -> domListe = null;
			echo 'Problem!!! '.$this -> path.'<br/>';
			$this -> error = TRUE;
		}
	}
	
	protected function _getPath($urlArray,$root){
		$this -> idPage = $urlArray[0].','.$urlArray[1].','.$urlArray[2];
		self::$_tagPath  = ROOT_PATH.'/data/'.$urlArray[1].'/tags-'.$urlArray[0].'.data';
		if(isset($urlArray[3])){	// si un article est demandé
			$fileName = $urlArray[3];
/* 			$this -> path = BASE_PATH.'/data/'.$urlArray[1].'/'.$urlArray[2].'/'.$urlArray[3].'.xml';
 */
		}else{
			$fileName = '/00-index';
		}
		if($root == 'base'){ 
			$this -> path = BASE_PATH.'/data/'.$urlArray[1].'/'.$urlArray[2].'/'.$fileName.'.xml';
		}else{
			$this -> path = ROOT_PATH.'/data/'.$urlArray[1].'/'.$urlArray[2].'/'.$fileName.'.xml';
		}
	}
	
	public function delete(){
		if(is_file($this -> path)){
			unlink($this -> path);
		}else{
			return false;
		}
		self::clearDir($this -> dirPath.'/');
	}
	
	
	public function getDesign(){
	
		$design = $this -> domListe -> getElementsByTagName('design');
		
		$design = $design	-> item(0);
		
		return array('theme' => $design -> getAttribute('nom'),
						'style' => $design -> getAttribute('style'),
						'squelette' => $design -> getAttribute('squelette'));
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
	
	public function deleteArticle($path,$id){
		$myArticle = $this -> getArticle($id);
		if($myArticle != false){
			$myArticle->parentNode->removeChild($myArticle); 	// supprimer du fichier index
			echo 'yesssssssssssssssssssssssssssssssss!!!!!!!!!!!!!!!!!!';
			self::saveXmlFile($this -> domListe, $this -> dirPath.'/00-index.xml');
			// supprime le fichier
			$this -> delete($path);
		}
	}
	/* public function setPublish($id,$array){
		$this -> setInfo($id,$array, true);
	} */
	
	 public function setInfo($array){
		parent::setInfo($array);
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
	
	public function addArticleItem($id, $title='Titre de l\'article',$droit='-1',$auteur='Auteur de l\'article'){
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
		
		$nodeChildren = array('titre'		=> $title,
							  'description'	=> 'Description de l\'article',
							  'motsclefs'	=> 'Mots-clefs de l\'article',
							  'auteur'		=> $auteur,
							  'date'		=> date('d.m.Y'),
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
	
		// http://www.weirdog.com/blog/php/supprimer-les-accents-des-caracteres-accentues-en-php.html
	public static function wd_remove_accents($str, $charset='utf-8'){
		$str = htmlentities($str, ENT_NOQUOTES, $charset);
		
		$str = preg_replace('#\&([A-za-z])(?:acute|cedil|circ|grave|ring|tilde|uml)\;#', '\1', $str);
		$str = preg_replace('#\&([A-za-z]{2})(?:lig)\;#', '\1', $str); // pour les ligatures e.g. '&oelig;'
		$str = preg_replace('#\&[^;]+\;#', '', $str); // supprime les autres caractères
		
		return $str;
	}
	// source : http://www.weirdog.com/blog/php/trier-les-cles-accentuees-dun-tableau-associatif.html
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

	
	
	
	

}
?>