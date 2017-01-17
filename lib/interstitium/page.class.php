<?php
class Xml_Page extends Xml_Model{
	
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
					   <design theme="defaut" style="monStyleDefaut" squelette="squelette.html" page="page.html"/>
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
	
	
	

}
?>