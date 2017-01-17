<?php
class Xml_ListeDeMariage extends Xml_Model{
// CONSTANTE
	// 		- MODULE NAME = [page]
	
	public function __construct($urlArray, $root='base',$create = FALSE){
		parent::__construct($urlArray, $root, $create);
	}
	
	public function getPages(){
	
	}
	
	public function setInfo($array){
		parent::setInfo($array);
		self::addEntrySiteMap($this -> idPage,ROOT_URL.'/'.$this -> idPage.'.html', $array);
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
					   <design theme="defaut" style="css-defaut" squelette="squelette.html" page="page.html"/>
					  <contenu>
						<principal><![CDATA[                     <h1>Titre</h1>
					<p> Votre paragraphe blablabla... </p>]]></principal>
						<secondaire><![CDATA[ <h1>Titre du contenu secondaire</h1>
					<p> Petit paragraphe... </p>	]]></secondaire>

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
	public static function createPageOld($lg, $id, $module='page'){
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
					   <design nom="defaut" style="css-defaut" squelette="squelette.html" page="page.html">
						<css rel="stylesheet" media="all" type="text/css" href="style.css"/>
					  </design>
					  <contenu>
						<principal><![CDATA[                     <h1>Titre</h1>
					<p> Votre paragraphe blablabla... </p>]]></principal>
						<secondaire><![CDATA[ <h1>Titre du contenu secondaire</h1>
					<p> Petit paragraphe... </p>	]]></secondaire>

					  </contenu>
					</page>';
					
		$dom = new DOMDocument();
		$dom -> loadXML($xmlChain); 
		
		$filePath = ROOT_PATH.'/data/'.$module.'/'.$id;
		$ext = 'xml';
		$fileDest = self::findUniqueFileName($filePath,$ext);
		$fileDest = $fileDest.'.'.$ext;
		
		$fileName =  basename($fileDest,'.'.$ext);
		
		if(self::saveXmlFile($dom, $fileDest)){
			$idPage = $lg.','.$module.','.$id;
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
	public function getLeCadeau($id){
		$query = '/page/contenu/principal/cadeau[@id="'.$id.'"]';
		$cadeaux = $this -> _xPath -> query($query);
		if($cadeaux->length >0){
			return $cadeaux-> item(0);
		}
	}
	
	public function upDateCadeau($id, $arrayAttr, $acheteur){
		$cadeau = $this -> getLeCadeau($id);
		//echo 'OKKKKK'.$id.'  -----';
		foreach($arrayAttr as $key=>$value){
			if($key == 'paye'){
				$alreadyPayed = $cadeau -> getAttribute('paye');
				$payer = $value;
				$cadeau -> setAttribute($key, $value + $alreadyPayed);
			}elseif($key == 'nb'){
				$nb = $value;
				$cadeau -> setAttribute($key, $value);
			}
		}
		if(isset($acheteur['nom']) && isset($acheteur['email'])){
			$acheteurdNode = $this -> _dom -> createElement('acheteur');
			$acheteurdNode = $cadeau -> appendChild($acheteurdNode);
				
			$nom 	 = $this -> _dom -> createElement('nom');
			$nom = $acheteurdNode -> appendChild($nom);
			$nom -> setAttribute('paye', $payer);
			$nom -> setAttribute('nb', $nb);
			$nom -> setAttribute('type', $arrayAttr['type']);
			$nomText = $this -> _dom -> createCDATASection($acheteur['nom']);
			$nom->appendChild($nomText);
			
			$email 	 = $this -> _dom -> createElement('email');
			$email = $acheteurdNode -> appendChild($email);
			$emailText = $this -> _dom -> createCDATASection($acheteur['email']);
			$email->appendChild($emailText);
			
			$email 	 = $this -> _dom -> createElement('email');
			$email = $acheteurdNode -> appendChild($email);
			$emailText = $this -> _dom -> createCDATASection($acheteur['email']);
			$email->appendChild($emailText);
		}
		self::saveXmlFile($this -> _dom, $this -> path);
	}
	
	public function getCadeaux(){		
		$query = '/page/contenu/principal/cadeau';
		$cadeaux = $this -> _xPath -> query($query);
		$cadeauArray = array();
	
		foreach($cadeaux as $cadeau){
			$key = $cadeau -> getAttribute('id');
			
			$cadeauArray[$key] = array('id' => 		$cadeau -> getAttribute('id'),
									'offrir' => 	$cadeau -> getAttribute('offrir'),
									'acheter' => 	$cadeau -> getAttribute('acheter'),
									'paye' => 		$cadeau -> getAttribute('paye'),
									'nb' => 		$cadeau -> getAttribute('nb'),
									'titre' => 		$cadeau -> getElementsByTagName('titre') 		-> item(0) -> nodeValue,
									'prix' => 		$cadeau -> getElementsByTagName('prix')			-> item(0) -> nodeValue,
									'description' => $cadeau -> getElementsByTagName('description') -> item(0) -> nodeValue
									
									/* 'publication' => $cadeau -> getElementsByTagName('publication')-> item(0) -> nodeValue,
									'date' => $cadeau -> getElementsByTagName('date')-> item(0) -> nodeValue,
									'year' => $myDate[2],
									'month' => $myDate[1],
									'timestamp' =>  mktime(0, 0, 0, $myDate[1], $myDate[0], $myDate[2]),
									//'auteurid' => $cadeau -> getAttribute('auteurid'),
									'tags' => $cadeau -> getElementsByTagName('motsclefs') -> item(0) -> nodeValue,
									'author' => $cadeau -> getElementsByTagName('auteur') -> item(0) -> nodeValue,
									'droit' => $cadeau -> getElementsByTagName('droit') -> item(0) -> nodeValue,
									'image' => $cadeau -> getElementsByTagName('image') -> item(0) -> nodeValue,
									'miniature' => $cadeau -> getElementsByTagName('miniature') -> item(0) -> nodeValue, */
									); 
		}
	//	$cadeauArray = $this -> sort2DArray$cadeauArray, 'timestamp', $reverse=true);
		return $cadeauArray;
		//return $cadeauArray; 
		
/* 		$query = '/page/info/titre';
		$titre = $this -> _xPath -> query($query);
		if($titre->length>0){
			return $titre->item(0)-> nodeValue;
		} */
	}
	
	
	

}
?>