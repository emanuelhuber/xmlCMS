<?php




//extends ModuleSquelette
class ModuleUploadGestion extends ModuleAdmin{
	
	public function __construct($url, $query, $urlArray, $conf){
		parent::__construct($url, $query, $urlArray, $conf);		
		require(ROOT_PATH.$this->_config['librairie']['interstitium'].'page.class.php');
		require(ROOT_PATH.$this->_config['librairie']['interstitium'].'upload.class.php');
		$path = BASE_PATH.$this->_config['path']['data'].$urlArray[1].'/'.$urlArray[2].$this->_config['ext']['data'];
		self::$myPage = new Xml_Page($path);
	}

	public function setData(){
		$this->_templateNameModule = 'page';
		
		$domPath = ROOT_PATH.$this->_config['path']['upload'].'index.xml';
		self::$_page  = new Xml_Upload($domPath);
		
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
				if($myCat == 'image'){
					$src = ROOT_URL.$this->_config['path']['upload'].$myCat.'/miniatures/'.$key.'.jpg';
				}else{
					$src = BASE_URL.$this->_config['path']['design'].$this -> _templateDesign.'/icones/'.$file['ext'].'.png';
				}
			
				self::$multiArrayToParse[] = array('liste' => array('TITLE' => $file['title'],
																	'URL' => $fileUrl,
																	'EXT' => $file['ext'],
																	'SRC' => $src,
																	'LINK_DELETE' => $this->urlAddQuery(array('delete'=>$myCat.'&id='.$key.'&ext='.$file['ext']), true),
																	'LINK_EDIT' => $this->urlAddQuery(array('edit'=>$myCat.'&id='.$key.'&ext='.$file['ext']), true),
																	'COPYRIGHT' => $file['copyright'],
																	'DESCRIPTION' =>  $file['description']));
			}
		}
		
		

		
	}
}





?>
