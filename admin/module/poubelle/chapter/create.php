<?php

//extends ModuleSquelette
class ModuleChapterCreate extends ModuleAdmin{
	
	public function __construct($url, $query, $urlArray, $conf){
		parent::__construct($url, $query, $urlArray, $conf);		
		require(ROOT_PATH.$this->_config['librairie']['interstitium'].'page.class.php');
		$path = BASE_PATH.$this->_config['path']['data'].$urlArray[1].'/'.$urlArray[2].$this->_config['ext']['data'];
		self::$myPage = new Xml_Page($path);
	}
	
	


	
	public function setData(){
		$this -> _templateNameModule 	= 'page';
		
		if(isset($this -> _urlQuery['title']) && !empty($this -> _urlQuery['title']) 
			&& isset($this -> _urlQuery['lg']) && !empty($this -> _urlQuery['lg']) ){
			
			// Copier le fichier xml modèle
			// et renommer le fichiers selon le nom du document
			$origine = BASE_PATH.'/datamodel/'.$this->_module.'/';
			$destination = ROOT_PATH.$this->_config['path']['data'].$this->_module.'/';
			/* if(is_dir($origine) && is_dir($destination)){
				if(is_file($origine.'new.xml')){ */
					
					// Copy & Rename
					$fileName = self::removeAccents(urldecode($this -> _urlQuery['title']), $charset='utf-8',$del=false);
					$fileName = strtolower($fileName);
					$fileName = self::removeShortWords($fileName);
					/* $idFile = self::copyFile($origine.'new.xml', $destination.$fileName.'.xml');
					$path_parts = pathinfo($idFile);
					$idFile = $path_parts['filename']; */
					
					// ajouter les infos dans le menu
					$path = ROOT_PATH.$this->_config['path']['arborescence'];
					$id = 	null;
					$lg = 	'fr';
					$menuSite = new Xml_Menu($path, $id, $lg);
					
					$lg = $this -> _urlQuery['lg'];
					$id = $lg.','.$this->_module.','.$fileName;
					$array = array('nom' => urldecode($this -> _urlQuery['title']),
								   'module' => $this->_module,
								   'soeur' => '',
								   'menu' => '1',
								   'publication' => '1',
								   'droits' => '-1'
									);
					$menuSite -> addMenuItem($lg, $array, $id, 'chapter');
					
					$host  = $_SERVER['SERVER_NAME'].rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
					
					// echo $host;
					//$linkRedirect = $this->urlAddQuery(array('title'=>$data['titre'], 'lg' => $data['langue']),true,'http://'.$host.'/fr,'.$data['module'].',create.html');
					//$linkRedirect = 'http://'.$_SERVER['SERVER_NAME'].$linkRedirect;
					header('location: http://'.$host); 
					exit(); 
				/* }
			} */

			
			
		}	
			echo 'Y a eu un probleme 2222222222!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!';
	}
	
	public static function copyFile($fileSource,$fileDest,$safe=true){
		$path_parts = pathinfo($fileDest);
		if(!is_file($fileSource) or !is_dir($path_parts['dirname'])){
			echo 'fauy!!!';
			return false;
		}
		if($safe){	
			$fileName = $path_parts['dirname'].'/'.$path_parts['filename'];
			$ext = $path_parts['extension'];
			$fileDest = $fileName;
			
			$fileDest = self::findUniqueFileName($fileName,$ext);
		}
		if(copy($fileSource, $fileDest)){
			return $fileDest;
		}else{
			return false;
		}
	}
	
	// cherche un nom de fichier unique pour un fichier donné
	// et retourne le nom sans extension
	// (pour par exemple sauvegarder un fichier qui existe déjà 
	// sous un autre nom "monfichier-1.ext")
	public static function findUniqueFileName($fileName,$ext){
		$fileDest = $fileName;
		$i=0;
		while(is_file($fileDest.'.'.$ext)){
			$fileDest = $fileName.'-'.$i;
			$i++;
		}
		return $fileDest;
	}
	
	public static function removeShortWords($str,$nb=2){
		$str = preg_replace('#-([a-z]{1,'.$nb.'})-#', '-', '-'.$str.'-');
		$str = preg_replace('#-([a-z]{1,'.$nb.'})-#', '-', $str);
		$str = trim($str,'-');	// Supprimer les tirets en début et fin
		//$str = preg_replace('#-[a-z]{1,'.$nb.'}-#', '-', $str);
		return $str;
	}
	
	public static function removeAccents($str, $charset='utf-8',$del=true){
		$str = htmlentities($str, ENT_NOQUOTES, $charset);
		
		$str = preg_replace('#\&([A-za-z])(?:acute|cedil|circ|grave|ring|tilde|uml)\;#', '\1', $str);
		$str = preg_replace('#\&([A-za-z]{2})(?:lig)\;#', '\1', $str); // pour les ligatures e.g. '&oelig;'
		if($del){
			$str = preg_replace('#\&[^;]+\;#', '', $str); // supprime les autres caractères
		}else{
			$str = preg_replace('/([^.a-z0-9]+)/i', '-', $str);
			$str = trim($str,'-');	// Supprimer les tirets en début et fin
		}
		
		return $str;
	}
	
	
	
	//-------------------------
	//  EDITING
	//-------------------------
	
	public function setGlobalContent($action,$path,$id){
		
		self::$arrayToParse['LINK_EDITCONTENT'] =	$this->urlAddQuery(array('id'=>$id),true);
		self::$arrayToParse['LINK_EDITMENU'] 	=	$this->urlAddQuery(array('id'=>$id, 'action' => 'editmenu'),true);
		self::$arrayToParse['LINK_EDITINFO'] 	=	$this->urlAddQuery(array('id'=>$id, 'action' => 'editinfo'),true);
		self::$arrayToParse['LINK_EDITDESIGN'] 	=	$this->urlAddQuery(array('id'=>$id, 'action' => 'editdesign'),true);
		
		$this -> formTarget($_SERVER['REQUEST_URI'], 'FICHIER_CIBLE');
		
		$action = filter_var($action, FILTER_SANITIZE_STRING);
		switch($action){
			case 'editinfo':
				$this->_templateNameModule = 'editinfo';
				$this -> editInfo($path,$id);
				break;
			case 'editmenu':
				$this->_templateNameModule = 'editmenu';
				$this -> editMenu($path,$id);
				break;
			case 'editcontent':
				$this->_templateNameModule = 'editcontent';
				$this -> editContent($path,$id);
				break;
			default:
				echo 'Pas d action définie!!!! Erreur!!!';
				$this->_templateNameModule = 'editcontent';
				$this -> editContent($path,$id);
				break;
		}
	}
	
	public function editInfo($path,$id){
		$pageObject = new Xml_Page($path);
		$infos = $pageObject -> getInfo();
		// TAG FILE
		$idArray = explode(',',$id);
		$pathTag = ROOT_PATH.$this->_config['path']['data'].'tags-'.$idArray[0].'.data';
		require(ROOT_PATH.$this->_config['librairie']['interstitium'].'tags.class.php');
		$tagObject = new Tags($pathTag);
		// MENU FILE
		$path = ROOT_PATH.$this->_config['path']['arborescence'];
		$menuSite = new Xml_Menu($path, null, '');
		if(isset($_POST) and !empty($_POST)){
			$infoForm = $_POST['info'];
			// TAG UPDATE
			$tagObject-> updateTags($infos['motsclefs'],$infoForm['motsclefs'],$id);
			$infoForm['motsclefs'] = $tagObject-> buildStringTag($infoForm['motsclefs']);
			// MENU UPDATE
			$menuSite -> setMenuItemAttribute($id,array('droit' => $infoForm['droit']));
			// DATA UPDATE
			$pageObject -> setInfo($infoForm);
			// date of modification (warning : modification are saved!)
			self::$multiArrayToParse[]=array('info'=>array( 'DATE'	=> date('l j  F Y H:i:s'))); 
		}
		// Link JS
		$linkJS = array('wymeditor/jquery/jquery.js',
						'misc/javamisc.js',
						'jqueryui/jquery-ui-1.7.3.custom.min.js');
		foreach($linkJS as $link){
			self::$multiArrayToParse[]=array('script'=>array('LANGAGE' 	=> 'javascript',
													   'TYPE'		=> 'text/javascript',
													   'SRC'		=> ROOT_URL.$this->_config['path']['lib'].$link)); 
		}
		// TAGS
		$tags = array_keys($tagObject-> getTags());
		//$tags = array_keys($tags);
		foreach($tags as $tag){
			self::$multiArrayToParse[]=array('tags'=>array('TAGNAME' 	=> $tag)); 
		}
		$infos = $pageObject -> getInfo();
		$prefix = 'form_';
		foreach($infos as $key => $info){
			if($key == 'droit'){
				($info<0) ? self::$arrayToParse['HAS_RIGHT'] = true :  self::$arrayToParse['HAS_RIGHT'] = false;
				$pathGroups = BASE_PATH.$this->_config['path']['data'].'usermanager/groups.xml';
				//$pathTag = ROOT_PATH.$this->_config['path']['data'].'tags-'.$idArray[0].'.data';
				require(ROOT_PATH.$this->_config['librairie']['interstitium'].'groups.class.php');
				$groupObject = new Xml_Group($pathGroups);
				$rights = $groupObject -> rightsList();
				foreach($rights as $right){
					(intval($info) == intval($right['right'])) ? $selected = true : $selected = false;
					self::$multiArrayToParse[]=array('rights'=>array( 'VALUE'		=> $right['right'],
																	  'NAME'		=> $right['name'],
																	  'DESCRIPTION'	=> $right['description'],
																	  'SELECTED'	=> $selected)); 
				}
			}elseif($key == 'publication'){
				($info==0) ? self::$arrayToParse['IS_PUBLICATED'] = false :  self::$arrayToParse['IS_PUBLICATED'] = true;
			}elseif($key == 'commentaire'){
				($info==0) ? self::$arrayToParse['HAS_COMMENT'] = false :  self::$arrayToParse['HAS_COMMENT'] = true;
			}else{
				self::$arrayToParse[strtoupper($prefix.$key)] = $info;
			}
		
		}
	}
	
	public function editContent($path,$id){
		$pageObject = new Xml_Page($path);
		if(isset($_POST) and !empty($_POST)){
			$dataForm = $_POST['contenu'];
			// DATA UPDATE
			$pageObject -> setContent($dataForm);
			// date of modification (warning : modification are saved!)
			self::$multiArrayToParse[]=array('info'=>array( 'DATE'	=> date('l j  F Y H:i:s'))); 
		}
		//----------------------------------
		// WYMEDITOR
		$linkJS = array('wymeditor/jquery/jquery.js',
						'wymeditor/wymeditor/jquery.wymeditor.js',
						'wymeditor/wymeditor/plugins/hovertools/jquery.wymeditor.hovertools.js', 
						'wymeditor/wymeditor/plugins/resizable/jquery.wymeditor.resizable.js',
						//'wymeditor/wymeditor/plugins/semantic/wymeditor.semantic.js',
						'wymeditor/simple.js',
						'jqueryui/jquery-ui-1.7.3.custom.min.js');
		foreach($linkJS as $link){
			self::$multiArrayToParse[]=array('script'=>array('LANGAGE' 	=> 'javascript',
													   'TYPE'		=> 'text/javascript',
													   'SRC'		=> ROOT_URL.$this->_config['path']['lib'].$link)); 
		}
		//------------------------------------------
		$content = $pageObject -> getContent();
		$this -> parseArray($content);
		$infos = $pageObject -> getInfo();
		$this -> parseArray($infos,'form_');
	}
	
	public function editMenu($path,$id){
		// MENU FILE
		$pathMenu = ROOT_PATH.$this->_config['path']['arborescence'];
		$menuSite = new Xml_Menu($pathMenu, null, '');
		if(isset($_POST) and !empty($_POST)){
			$dataForm = $_POST['rubrique'];
			$menuSite -> setMenuItemAttribute($id,$dataForm);
			// date of modification (warning : modification are saved!)
			self::$multiArrayToParse[]=array('info'=>array( 'DATE'	=> date('l j  F Y H:i:s'))); 
		}
		$menuContent = $menuSite -> getMenuItem($id);
		self::$arrayToParse['NOM-PAGE'] = 	$menuContent['id'];
		self::$arrayToParse['ID'] = 	$menuContent['id'];
		self::$arrayToParse['NOM'] = 	$menuContent['nom'];
		($menuContent['menu']==1) ? self::$arrayToParse['SELECTED_1'] = 	'selected="selected"' : self::$arrayToParse['SELECTED_0'] = 	'selected="selected"';
		$pageObject = new Xml_Page($path);
		$infos = $pageObject -> getInfo();
		$this -> parseArray($infos,'form_');
	}

}			
			




?>