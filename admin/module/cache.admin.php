<?php

//extends ModuleSquelette
class ModuleAdminCache extends ModuleAdmin{
	
	public function __construct($url, $query, $urlArray, $conf){
		parent::__construct($url, $query, $urlArray, $conf);		
		require(ROOT_PATH.$this->_config['librairie']['interstitium'].'page.class.php');
		self::$myPage = new Xml_Page($urlArray);
	}
	
	public function setData(){
		$this->_templateNameModule = 'page';
		$this -> formTarget($_SERVER['REQUEST_URI'], 'FICHIER_CIBLE');
		self::$arrayToParse['CURRENT_CRUMB'] = self::$arrayToParse['INFO_TITRE'];
		require(ROOT_PATH.$this->_config['librairie']['interstitium'].'module.class.php');
		
		
		
		if(isset($_POST) && !empty($_POST)){
			if(!empty($_POST['nom'])){

				// Fichier de configuration à la racine du site
				$confRoot = parse_ini_file(ROOT_PATH.'/'.INTERSTITIUM_CONF, true);
				$cacheDirPath = ROOT_PATH.$confRoot['path']['cache'];
			
				$ok = $this -> killDirContent($cacheDirPath);
				if($ok) $this -> saveConfirmation();
				
			}

		}
		
		
	}
	
	private function killDirContent($dir) {
		$mydir = opendir($dir);
		while(false !== ($file = readdir($mydir))) {
			if($file != "." && $file != "..") {
				chmod($dir.$file, 0777);
				if(is_dir($dir.$file)) {
					chdir('.');
					destroy($dir.$file.'/');
					rmdir($dir.$file) or DIE("couldn't delete $dir$file<br />");
				}
				else
					unlink($dir.$file) or DIE("couldn't delete $dir$file<br />");
			}
		}
		closedir($mydir);
		return true;
	}


	

}
?>