<?php




//extends ModuleSquelette
class ModuleAdminUpload extends ModuleAdmin{


	public function __construct($url, $query, $urlArray, $conf){
		parent::__construct($url, $query, $urlArray, $conf);		
		require(ROOT_PATH.$this->_config['librairie']['interstitium'].'upload.class.php');
		require(ROOT_PATH.$this->_config['librairie']['interstitium'].'page.class.php');
		// $path = BASE_PATH.$this->_config['path']['data'].$urlArray[1].'/'.$urlArray[2].$this->_config['ext']['data'];
		self::$myPage = new Xml_Page($urlArray);
	}

	public function setData(){
		self::$arrayToParse['CURRENT_CRUMB'] = self::$arrayToParse['INFO_TITRE'];
		
		//$domPath = ROOT_PATH.$this->_config['path']['upload'].'index.xml';
		self::$_page  = new Xml_Upload();
		
		
		
		switch($this -> _action){
			case 'fichier':
				$this -> upload();
			break;
			
			case 'gestion':
				$this -> gestion();
			break;
			
			case 'check':
				$this -> check();
			break;
		}
	}		

	public function check(){
		$this->_templateNameModule = 'page';
		// folder for upload
		$pathImage = ROOT_PATH.$this->_config['path']['uploadImage'];
		
		$dossierImage = opendir($pathImage);
		while ($image = readdir($dossierImage)) {
			// on parcourt les thèmes = dossier "/design/monTheme/"
			if(is_dir($pathImage."/".$image) && $image != "." && $image != "..") {
				
				
				
				// dossier contenant les fichiers css
				$dossier = opendir($folder);
				while ($style = readdir($dossier)) {
					$pathCss = $folder.$style;
					if($style != "." && $style != ".." && !is_dir($pathCss)) { 
						$styleName =  substr($style,0,strlen($style)-4);
						if($styleName != 'base' && substr($styleName,-3,3)!='min'){
							$selected = false;
							if($style == $designStyle.'.css'){
								$selected = true;
							}
							$th = strpos($style, 'css' );
							if($th!==false){
							self::$multiArrayToParse[]=array('theme.style'=>array('NAME' 	=> $styleName,
																				'SELECTED'	=> $selected,
																					'LINK'		=> $this->urlAddQuery(array('theme'=>$theme, 'style' => $styleName),false))); 
							}
						}
					}
				}
				closedir($dossier);
			}
		}
		closedir($dossierTheme);
		
	}
	
	public function gestion(){
		$this->_templateNameModule = 'page';

		// EDITER UN DOCUMENT
		if(isset($this -> _urlQuery['edit']) && !empty($this -> _urlQuery['edit'])){
			$this->_templateNameModule = 'edit';
			$cat = $this -> _urlQuery['edit']; 
			$id = $this -> _urlQuery['id']; 
			
			$path = ROOT_PATH.$this->_config['path']['upload'].$this -> _urlQuery['edit'].'/'.$this -> _urlQuery['id'].'.'.$this -> _urlQuery['ext'];
			
			if(isset($_POST) and !empty($_POST)){
				$postInfo = $_POST['info'];
				$data = array('title' => $postInfo['title'], 'copyright' => $postInfo['copyright']);
				$description = $postInfo['description'];
				$my = self::$_page -> editFile($cat, $id, $data, $description);
			}
			
			$infoFile = self::$_page -> getFile($cat, $id);
			$this -> parseArray($infoFile,'form_');
			$this -> formTarget($_SERVER['REQUEST_URI'], 'FICHIER_CIBLE');
			self::$arrayToParse['CURRENT_CRUMB'] = 'Edition';

			$this->setBreadCrumbs($this->urlAddQuery(array('id'=>$id),true), self::$arrayToParse['INFO_TITRE'], self::$arrayToParse['INFO_TITRE'], true);
			
		}else{
			self::$arrayToParse['CURRENT_CRUMB'] = self::$arrayToParse['INFO_TITRE'];
		}

		
		
		
		$categories = self::$_page -> fileCategorie();
		
		if(isset($this -> _urlQuery['cat']) && !empty($this -> _urlQuery['cat'])){
			$myCat = $this -> _urlQuery['cat'];
		}else{
			$myCat = $categories[0];
		}
		
		//$this -> echo_r($categories);
		$files = self::$_page -> getFiles($myCat);
		
		
		
		foreach($categories as $cat){
			$sel = '';
			if($myCat == $cat){
				$sel = 'selected';
			}
			
			$l =  BASE_URL.$this->_config['path']['design'].$this -> _templateDesign.'/images/upload'.$cat.'.png';
			self::$multiArrayToParse[] = array('folders' => array('SELECTED' => $sel,
																'LINK' => $this->urlAddQuery(array('cat'=>$cat)),
																'SRC' => $l ,
																'NAME' =>$cat));
		}
		
		
		
		if(isset($this -> _urlQuery['delete']) && !empty($this -> _urlQuery['delete'])){
			$path = ROOT_PATH.$this->_config['path']['upload'].$this -> _urlQuery['delete'].'/'.$this -> _urlQuery['id'].'.'.$this -> _urlQuery['ext'];
			if(is_file($path)){
				$r = @unlink($path);
				if($r){
					self::$_page -> removeFile($this -> _urlQuery['delete'],$this -> _urlQuery['id']);

				}
			}
		}
		
		
		
		foreach($files as $key => $file){
			$src ='';
			
			$filePath = ROOT_PATH.$this->_config['path']['upload'].$myCat.'/'.$key.'.'.$file['ext'];
			$fileUrl = ROOT_URL.$this->_config['path']['upload'].$myCat.'/'.$key.'.'.$file['ext'];
			if(is_file($filePath)){
				$isImage = false;
				if($myCat == 'image'){
					$isImage = true;
					$src = ROOT_URL.$this->_config['path']['upload'].$myCat.'/miniatures/'.$key.'.jpg';
				}else{
					$src = BASE_URL.$this->_config['path']['design'].$this -> _templateDesign.'/icones/'.$file['ext'].'.png';
				}
			
				self::$multiArrayToParse[] = array('liste' => array('TITLE' => $file['title'],
																	'URL' => $fileUrl,
																	'EXT' => $file['ext'],
																	'SRC' => $src,
																	'IS_IMAGE' => $isImage,
																	'LINK_DELETE' => $this->urlAddQuery(array('delete'=>$myCat.'&id='.$key.'&ext='.$file['ext']), true),
																	'LINK_EDIT' => $this->urlAddQuery(array('edit'=>$myCat.'&id='.$key.'&ext='.$file['ext']), true),
																	'COPYRIGHT' => $file['copyright'],
																	'DESCRIPTION' =>  $file['description']));
			}
		}
	
	
	}
	public function upload(){		
		$mimePath = BASE_PATH.$this->_config['path']['mimeupload'];
		$mimeTypes = parse_ini_file($mimePath, true);			// config data
		$tailleMax = $this->_config['conf']['uploadMaxSize']; // = 1Mo
		//-------------------------------------
		// TRAITEMENT DU FORMULAIRE
		if(isset($_FILES['file']) && isset($_POST['title']) && !empty($_POST['title']) ){
			
			unset($_SESSION['upload']);
			$this->_templateNameModule = 'apercu';
			
			// Passe en boucle tous les fichiers à uploader
			foreach($_FILES['file']['name'] as $file => $photo){
				unset($message);

				// On vérifie si l'extension du fichier se trouve parmis celles autorisées
				$extensionUpload = strtolower(substr(strrchr($_FILES['file']['name'][$file], '.'), 1));
				$extensionUpload = str_replace(array('jpg','jpeg','jpe'),'jpg',$extensionUpload);
				$ok=false;
				foreach($mimeTypes as $clef => $mimeType){
					if(array_key_exists($extensionUpload, $mimeType)){
						$ok=true;
						/* echo $clef; */
						$categorie = $clef;
						break;
					}
				}
				if($ok==false)	$message = 'Veuillez sélectionner un fichier avec la bonne extension !  ';

				if(file_exists($_FILES['file']['tmp_name'][$file]) and filesize($_FILES['file']['tmp_name'][$file]) > $tailleMax){
					$message = 'Taille de votre fichier trop grosse !';
				}
				
				// copie du fichier
				if(!isset($message)){
					$filename = basename(strtolower($_POST['title'][$file]));
					
					// id-formating
					if(empty($_POST['fileId'][$file])){
						$filename = self::removeAccents(urldecode($filename), $charset='utf-8',$del=false);
					}else{
						$filename = self::removeAccents(urldecode(strtolower($_POST['fileId'][$file])), $charset='utf-8',$del=false);
					}
					/* $idFile = strtolower($idFile);
					
					// FORMATAGE NOM FICHIER
					// 1. enlever les accents
					$filename = strtr($filename, 'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ',
												'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
					// 2. remplacer les caracteres autres que lettres, chiffres et point par -
					$filename = preg_replace('/([^.a-z0-9]+)/i', '-', $filename);
					 */
					
		
					
					$dossierDestination = ROOT_PATH.'/'.$this->_config['path']['upload'].$categorie.'/';
					// Si le dossier de destination n'existe pas
					if(!is_dir($dossierDestination)){
						$message = 'Dossier introuvable! Contacter le webmaster! <br/>'.$dossierDestination;
					}else{
						$filePath = $dossierDestination.$filename.'.'.$extensionUpload ;
						$miniaturePath = $dossierDestination.'miniatures/'.$filename.'.jpg';
						// SI LE FICHIER EXISTE DEJA => NOUVEAU NOM
						$j=0;
						if(is_file($filePath)){
							while(is_file($filePath)){
								// on incrémente le nom jusqu'à ce qu'il ne corresponde à aucun fichier existant
								$j++; 
								$filePath = $dossierDestination.$filename.'-'.$j.'.'.$extensionUpload;
								$miniaturePath = $dossierDestination.'miniatures/'.$filename.'-'.$j.'.jpg';
							}
							$filename .= '-'.$j;
						}
						//$filename .= '.'.$extensionUpload;
						
						// copie du fichier
						if(!move_uploaded_file($_FILES['file']['tmp_name'][$file],$filePath)){
							$message = 'echec de l upload!!! '.$filePath.'  --<br/> message error '.$_FILES['file']['error'][$file] ;
							$uploadSuccess = false;
							
						}else{
							if(is_file($filePath)){
								$message = 'upload réussi!!! '.$filePath. '<br/>';
								$uploadSuccess = true;
							}else{
								$message = 'echec de l upload!!! '.$filePath.'  --<br/> message error '.$_FILES['file']['error'][$file] ;
								$uploadSuccess = false;
							}
							// CREATION DE MINIATURES SI IMAGE
							if($categorie == 'image'){
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
				#               
				#                else { 
				#                   $im = imagecreatetruecolor($ratio, round(($ratio/$tableau[0])*$tableau[1])); 
				#                   imagecopyresampled($im, $src, 0, 0, 0, 0, $ratio, round($tableau[1]*($ratio/$tableau[0])), $tableau[0], $tableau[1]); 
				#                } 
								
								
								switch(strtolower($extensionUpload)){
									case 'jpg':
									case 'jpeg': //pour le cas où l'extension est "jpeg"
									case 'jpe': //pour le cas où l'extension est "jpeg"
										$src_im = imagecreatefromjpeg ($filePath);
										break;
									case 'gif':
										$src_im = imagecreatefromgif($filePath);
										break;
									case 'png':
										$src_im = imagecreatefrompng($filePath);
										break;
									default:
										echo 'L\'image n\'est pas dans un format reconnu. Extensions autorisées : jpg/jpeg, gif, png';
										break;
								} 
								$im = imagecreatetruecolor($newX, $newY); 
								imagecopyresampled($im, $src_im, 0, 0, 0, 0, $newX, $newY, $imageSizes[0], $imageSizes[1]); 
								imagepng($im, $miniaturePath);    //  save new image
								
								 
								
							}
						}
					}
				}
				
				// Si il y a un message d'erreur
				if ($_FILES['file']['error'][$file] > 0) $message .= '<br/>Erreur lors du transfert (erreur n°'.$_FILES['file']['error'][$file].').';
				
				if($uploadSuccess){
					// XXX free $title = htmlspecialchars(filter_var($_POST['title'][$file], FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES), ENT_QUOTES, 'UTF-8');
					$title = htmlspecialchars($_POST['title'][$file], ENT_QUOTES, 'UTF-8');
					// XXX free $copyright = htmlspecialchars(filter_var($_POST['copyright'][$file], FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES), ENT_QUOTES, 'UTF-8');
					$copyright = htmlspecialchars($_POST['copyright'][$file], ENT_QUOTES, 'UTF-8');
					// XXX free $description = htmlspecialchars(filter_var($_POST['description'][$file], FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES), ENT_QUOTES, 'UTF-8');
					$description = htmlspecialchars($_POST['description'][$file], ENT_QUOTES, 'UTF-8');
					$dateUpload = date('d.m.y');
					
					/* // REMPLIR LE FICHIER INDEX.XML
					$domPath = ROOT_PATH.$this->_config['path']['upload'].'index.xml';
					$dataDom = self::openDomXml($domPath);
					if(!$dataDom) $message .= '<br/>Arrive pas à ouvrir le fichier index.xml ('.$domPath.').';
					 */
				//	echo $categorie;
					$data = array('id' => $filename,
							  'categorie' => $categorie,
							  'ext' => $extensionUpload,
							  'title' => $title,
							  'copyright' => $copyright,
							  'date' => $dateUpload);
					
					
					self::$_page  -> addFile($categorie, $data, $description);
					
					
					/* $item = $dataDom -> createElement('item');
					$item = $dataDom -> documentElement  -> getElementsByTagName($categorie) -> item(0) -> appendChild($item);
					$item -> setAttribute('id' , $filename);
					$item -> setAttribute('categorie' , $categorie);
					$item -> setAttribute('ext' , $extensionUpload);
					$item -> setAttribute('title' , $title);
					$item -> setAttribute('copyright' , $copyright);
					$item -> setAttribute('date' , $dateUpload);
					$texte = $dataDom->createCDATASection($description);
					$item -> appendChild($texte); */
					
					/* 
					*/
					// save the xml nodes
					//self::saveMyXML($dataDom,$domPath);
				}
				
				
				
				
				
				$_SESSION['upload'][] = array('url' => $filePath,
												'categorie' => $categorie,
												'filename' => $filename,
												'title' => $title,
												'copyright' => $copyright,
												'description' => $description,
												'message' => $message);

			}
			
			unset($_FILES);
			FrontController::redirect($this -> _url.$this->_config['ext']['web'].'?id=result');
			
		}
		
		//-------------------------------------
		// AFFICHAGE DU RESULTAT DE L'UPLOAD AVEC MESSAGE D'ERREUR	
		if(isset($this -> _urlQuery['id']) && !empty($this -> _urlQuery['id']) && isset($_SESSION['upload']) && !empty($_SESSION['upload'])){
			$this->_templateNameModule = 'apercu';
			
			foreach($_SESSION['upload'] as $uploadedFile){
				self::$multiArrayToParse[] = array('liste' => array('MESSAGE' => $uploadedFile['message'],
																	'TITLE' => $uploadedFile['title'],
																	'COPYRIGHT' => $uploadedFile['copyright'],
																	'DESCRIPTION' => $uploadedFile['description'],
																	'URL_DELETE' => $this -> _url.$this->_config['ext']['web'].'?id=result&delete='.$uploadedFile['url']));
			}
			self::$arrayToParse['MESSAGE'] = $_SESSION['upload'][0]['message'];
			self::$arrayToParse['URL_UPLOAD'] = $this -> _url.$this->_config['ext']['web'];
			
	
		
		//-------------------------------------
		// AFFICHAGE DU FORMULAIRE
		}else{
			$this->_templateNameModule = 'page';
			
			// XXX free $this -> formTarget('upload.php?cible='.parse_url(filter_var($_SERVER['REQUEST_URI'], 
			$this -> formTarget(BASE_URL.'/upload.php?cible='.parse_url($_SERVER['REQUEST_URI'],PHP_URL_PATH), 'FICHIER_CIBLE',false);
			
			
			self::$arrayToParse['TAILLE_MAX_KO']	=	$tailleMax/1000;
			self::$arrayToParse['TAILLE_MAX']	=	$tailleMax;
			
			foreach($mimeTypes as $clef => $mimeType){
				self::$multiArrayToParse[] = array('liste' => array('NAME' => $clef));
				foreach($mimeType as $cle => $mime){
					self::$multiArrayToParse[] = array('liste.categorie' => array('EXT' => $cle, 'TYPE' => $mime));
				}
			}
		}

	}
}
// Source :
// PHP FRANCE
// http://www.phpfrance.com/tutoriaux/index.php/2005/04/26/30-lupload-de-fichiers




?>
