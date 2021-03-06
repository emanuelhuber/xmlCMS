<?php

error_reporting( E_ALL | E_STRICT);
date_default_timezone_set('Europe/Paris');
$time_start = microtime(true);


/*	if (phpversion()<'5') {   // Il faut php 5, msg 0.8.3b8
	exit('<h1> Interstitium a besoin de PHP5 pour fonctionner</h1>);
}
*/


// rapport d'erreur
// magic-quotes => à désactiver!

define('INTERSTITIUM_CONF', 'conf/config.ini') ;
if(dirname($_SERVER["SCRIPT_NAME"]) == '/'){
	define('BASE_URL','');
}else{
  // for client side inclusions (scripts, css files, images etc.)
	define('BASE_URL', dirname($_SERVER["SCRIPT_NAME"]));	
}
define('BASE_PATH',realpath('.'));						
// for server side inclusions.
define('ROOT_PATH',BASE_PATH);
define('ROOT_URL',BASE_URL);


if(!file_exists(INTERSTITIUM_CONF)){
	echo '<trong>Interstitium </strong><br />';
	echo 'Le fichier de configuration n\'a pas été trouvé...';
	exit;
}


$control = new FrontController(INTERSTITIUM_CONF);

$truc = $control -> launchAction();



class FrontController {
 

	// url example: www.monsite.com/fraises/interstitium/infdsf.html?teru=dfsfs
	private $_url;		// url + Query = infdsf.html
	private $_urlPath	= '';		// url sans Query = infdsf.html
	private $_urlQuery	= '';		// Query de l'url = teru=dfsfs
	private $_config	= array();	// données du fichier de configuration (array)
	private $_headers	= array();
	
	
	public function __construct($confPath){
		session_start(); 	// on démarre la session  avant toutes choses!
		ob_start();
		// url rewriting free - gestion des $_POST
		if(empty($_POST) && isset($_SESSION['post']) && !empty($_SESSION['post'])){	
			$_POST = $_SESSION['post'];
			unset($_SESSION['post']);
		}
		// location du script
		$this -> _config = parse_ini_file($confPath, true);			// config data
		// split url as   [sitename]/[folder]/[url]?[query]#[fragment]
		$this -> _urlPath  =  parse_url($_SERVER['REQUEST_URI'],PHP_URL_PATH);	
		if(dirname($_SERVER["SCRIPT_NAME"]) == '/'){
			$this -> _urlPath = substr($this -> _urlPath ,1);
		}else{
			$baseFile = rtrim(dirname($_SERVER['SCRIPT_NAME'])).'/';
			$this -> _urlPath = substr($this -> _urlPath , strlen($baseFile));				// url
		}
		// marche pas avec free
		//$this -> _urlPath  =  parse_url(filter_var($_SERVER['REQUEST_URI'], 
		//	FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES),PHP_URL_PATH);
		$this -> _urlQuery = $this->parse_query($_SERVER['REQUEST_URI']);		// query
		//echo parse_url($_SERVER['REQUEST_URI'], PHP_URL_FRAGMENT );
		//echo $_SERVER['QUERY_STRING'];
		$this -> _url = $this -> _urlPath.'?'.parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY);
		//echo $this -> _urlPath;
		
	}
	
	public static function errorMessage($message){
		$_SESSION['error']=array();
		$_SESSION['error']['message']=$message;
		$_SESSION['error']['request']=$_SERVER['REQUEST_URI'];
		if(isset($_SERVER['HTTP_REFERER'])){
			$_SESSION['error']['referer']=$_SERVER['HTTP_REFERER'];
		}else{
			$_SESSION['error']['referer']= null;
		}
	}
	
	public function launchAction(){
		self::getLanguage($this->_config['langue']);
		// si on tape www.monsite.com => redirection vers www.monsite.com/accueil.html
		if(empty($this -> _urlPath)){
		// XXXX
		// XXXX
		// XXXX
			$path = BASE_PATH.$this->_config['path']['arborescence'];
			// on charge le fichier "arborescence.xml"
			// et prend le premier noeud comme page de redirection.
			if(is_file($path)) {
				$dom = new DomDocument();
				$dom -> formatOutput = true;
				$dom -> preserveWhiteSpace = true; 
				if($dom -> load($path)){
					$xPath =  new DOMXPath($dom);
					$query = '/menu//page';
					$reponse = $xPath -> query($query);	// DomNodeList
					if($reponse->length>0){	// si il y a au moins 1 noeud dans le menu
						$reponse = $reponse -> item(0);
						$this -> _urlPath = $reponse -> getAttribute('id').$this->_config['ext']['web'];
						self::redirect($this -> _urlPath);
					}
				}
			}
		}
		$this -> urlAnalyse();
	}
	
	private function urlAnalyse(){
		
		$urlPath = explode('.',$this -> _urlPath);

		$i = count($urlPath)-1;
		if($i>=1){		// si l'url est du genre: module,et,compagnie[.]html
			// insensible à la casse de l'extention (strtolower !)
			switch(strtolower($urlPath[$i])){
				case substr($this->_config['ext']['web'], 1):	// '.html' to 'html'
					$this -> _urlPath = substr($this -> _urlPath, 0, -5);  // supprime '.html' de l'url
					$this->htmlManager();
					break;
				case 'csszip':
					$cssPath = str_replace($urlPath[$i],'css',$this -> _urlPath);
					View::printOutCss($cssPath,$expires = 60*60*24*465);
				case 'jszip':
					$cssPath = str_replace($urlPath[$i],'js',$this -> _urlPath);
					View::printOutCss($cssPath,$expires = 60*60*24*465);
				//	View::printOutCss($this -> _urlPath,$expires = $this->_config['cache']['expireCss']);
					break;
				/* case 'php':
					// si le fichier cible a été choisi
					if($this->_config['urlRewriting']['type']==1 && $urlPath[$i].'.php'==$this->_config['urlRewriting']['cible']){
						include($this -> _config['path']['module'].$this->_config['urlRewriting']['cible']);
					}else{
						self::errorMessage('<strong>Problème = extension ".php"</strong> Fichier php non accessible!!');
						self::redirect($_SESSION['langue'].',erreur,404.html');
					}
					break; */
				case 'jpegc': $this->imageManager('jpeg'); break;
				case 'jpgc': View::printOutImage(substr($this -> _urlPath, 0, -1),$this->_config['cache']['expireImage'],'jpg'); break;
				case 'pngc': View::printOutImage(substr($this -> _urlPath, 0, -1),$this->_config['cache']['expireImage'],'png'); break;
				case 'gifc': View::printOutImage(substr($this -> _urlPath, 0, -1),$this->_config['cache']['expireImage'],'gif'); break;
				case 'bmpc': View::printOutImage(substr($this -> _urlPath, 0, -1),$this->_config['cache']['expireImage'],'bmp'); break;
				case 'icoc': View::printOutImage(substr($this -> _urlPath, 0, -1),$this->_config['cache']['expireImage'],'x-icon'); break;
				//font
				case 'eotc': View::printOutFont(substr($this -> _urlPath, 0, -1),$this->_config['cache']['expireFont'],'application/vnd.ms-fontobject'); break;
				case 'otfc': View::printOutFont(substr($this -> _urlPath, 0, -1),$this->_config['cache']['expireFont'],'application/octet-stream'); break;
				case 'ttfc': View::printOutFont(substr($this -> _urlPath, 0, -1),$this->_config['cache']['expireFont'],'application/octet-stream'); break;
				case 'svgc': View::printOutFont(substr($this -> _urlPath, 0, -1),$this->_config['cache']['expireFont'],'text/html'); break;
				
				// POUR URL-REWRITING DIFFERENT DE FREE
				// CREER UNE FONCTION SPECIALE QUI LIT UN FICHIER CONTENANT
				// LES MIME-TYPES AUTORISES

				default:
					echo 'pas trouvé!!!!!!';
					//echo $this -> _urlPath;
					//exit();
			}
		}else{
			self::errorMessage('INDEX_000 | Problème = pas d\'extension [.]qc dans l\'url !');
			self::redirect($_SESSION['langue'].',erreur,400.html'); 
		}
	}

	
	private function htmlManager(){
		// si il n'y a pas de fichier en cache
		if(!$this->cacheManager()){		
			// teste si il y a bien une [,] dans l'url
			$urlPathArray = explode(',',$this -> _urlPath);	
			// si un parametre a été choisi (et donc un module) (lg,module,parameter)
			if(isset($urlPathArray[2]) && is_string($urlPathArray[1])){	
				$forbiddenCharacters = array(" ", ".", "/", "\\", "*", "\0", "&", "<", ">");
				// on nettoie le nom du fichier de tous caractères qui pourraient nuire à la sécurité
				// est-ce nécessaire vu que l'url a déjà été filtré ?
				$filePath = str_replace($forbiddenCharacters, "", $urlPathArray[1]);
				$urlPathArray[2] = str_replace($forbiddenCharacters, "", $urlPathArray[2]);
				$classPath = BASE_PATH.$this -> _config['path']['module'].$filePath.$this -> _config['ext']['class'];
				
				// si un fichier portant ce nom existe
				if(is_file($classPath) && is_file(BASE_PATH.'/module/squelette.php')){
					// alors on inclut le fichier squelette.php (classe abstraite)
					require(BASE_PATH.'/module/squelette'.'.php');	
					// on inclut le module
					require($classPath);
					// si le nom du fichier/module est du genre nom-du-module (avec [-])
					if(strpos($urlPathArray[1],'-')!==false){
						// alors on remplace les tirets par des espaces
						$className = str_replace("-", " ", $urlPathArray[1]);
					//	$forbiddenCharacters = array(" ", ".", "/", "\\", "*", "A", "E", "I", "O", "U");
						$forbiddenCharacters = array(" ", ".", "/", "\\", "*");
						// la première lettre de chaque mot est passée en majuscule et on concatène les mots
						$className = str_replace($forbiddenCharacters, "", ucwords($className));
						// on ajoute le préfixe "Module"
						$className = 'Module'.$className;
					}else{
						// on ajoute le préfixe "Module"
						$className = 'Module'.ucfirst($urlPathArray[1]);
					}
					// si la classe squelette et la classe du modules existent
					if(class_exists('ModuleSquelette') && class_exists($className)){
						// instance du module
						$module = new $className($this -> _urlPath,$this -> _urlQuery,$urlPathArray, $this -> _config);
						$module -> launchAction();	// et on lance l'action
					}else{
						self::errorMessage('INDEX_001 | Problème = la classe "'.$className.'" ou "squelette" n\'existe pas!!!');
						self::redirect($_SESSION['langue'].',erreur,000.html');		// sinon, erreur! 
					}					
				}else {
					self::errorMessage('INDEX_002 | Problème = le fichier contenant la classe "'.$className.'" ou "squelette" n\'existe pas !!! Lien '.$classPath);
					self::redirect($_SESSION['langue'].',erreur,000.html');		// sinon, erreur! 
				} 
			}else{
				// pas de module mais on pourrait tenter une redirection
				self::errorMessage('INDEX_003 | Problème = Pas de module ni d\'action défini !');
				self::redirect($_SESSION['langue'].',erreur,400.html');	// sinon, erreur!
			}
		}	
	}
	
	private function cacheManager(){
		// si le cache et le fichier de temps/droits existent
		if(is_file($filePath=BASE_PATH.$this->_config['path']['cache'].md5($this -> _url).$this->_config['ext']['cache']) 
			&& is_file($tfilePath=BASE_PATH.$this->_config['path']['cache'].md5($this -> _url).$this->_config['ext']['tcache'])
		//	&& is_file($rfilePath=$this->_config['path']['cache'].md5($this -> _urlPath).$this->_config['ext']['rcache'])
			){
			/* // lecture des droits de la page
			$fh = fopen($rfilePath, 'r');
			$droitPage = intval(fread($fh, filesize($rfilePath)));
			fclose($fh);  */
			// si le cache est encore valide
			if(filemtime($filePath) > (time()-file_get_contents($tfilePath))){
				//if($droitPage < 0){
					readfile($filePath);
					$content = ob_get_contents();			// recuperation du contenu bufferisé
					ob_end_clean();	
					View::printOutHtml($content,$this->_config['cache']['expireHtml'],filemtime($filePath));			//($expires,filemtime($filePath),'text/html');
					exit();
					return true;					
			}else{		// sinon on supprime le cache
				unlink($filePath);
				unlink($tfilePath);
				return false;
			}
			
		}else{			// pas de cache
			return false;
		}
	}
	
	
	
	private static function getLanguage($languesDisponibles){	// implémenter les pondérations pour les diverses langues
		if(!isset($_SESSION['langue']) or empty($_SESSION['langue'])){
			$langue = explode(',',$_SERVER['HTTP_ACCEPT_LANGUAGE']);
			if(count($langue)>1){
				$langue = strtolower(substr(chop($langue[0]),0,2));
				$truc = explode('-',$langue);
			}else{
				$truc[0]= $langue;
			}
			// si la langue du navigateur est disponible sur le site, on la prend
			if(in_array($truc[0],$languesDisponibles)){
				$_SESSION['langue'] = $truc[0];
			}else{	// sinon on donne par défaut la première langue disponible
				$_SESSION['langue'] = $languesDisponibles[1];
			}
		}
	}
	
/* 	public static function error($type, $permanent = false){
        if ($permanent){
           // $this->_headers['Status'] = '301 Moved Permanently';
		   // $this->_headers['HTTP/1.1'] = '301 Moved Permanently, true, 301';
			$status ='TRUE,301';
        }else{
           // $this->_headers['Status'] = '302 Found';
			$status ='TRUE,302';
        }
		$host  = $_SERVER['SERVER_NAME'].rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
		header('location: http://'.$host.'/'.$url, $status); 
		exit();
    } */
	
	public static function redirect($url, $permanent = false){
        if ($permanent){
           // $this->_headers['Status'] = '301 Moved Permanently';
		   // $this->_headers['HTTP/1.1'] = '301 Moved Permanently, true, 301';
			$status ='TRUE,301';
        }else{
           // $this->_headers['Status'] = '302 Found';
			$status ='TRUE,302';
        }
		$host  = $_SERVER['SERVER_NAME'].rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
		header('location: http://'.$host.'/'.$url, $status); 
		exit();
    }


/* 	public static function redirectCMS($url, $permanent = false){
        if ($permanent){
            $this->_headers['Status'] = '301 Moved Permanently';
            $this->_headers['HTTP/1.1'] = '301 Moved Permanently, true, 301';
        }else{
            $this->_headers['Status'] = '302 Found';
        }
        $this->_headers['location'] = $url;
    }
	
	public static function printOutCMS()
    {
        foreach ($this->_headers as $key => $value) {
            header($key. ':' . $value);
        }
        //echo $this->_body;
    } */
	

		/**
		*  Use this function to parse out the query array element from
		*  the output of parse_url().
		*/
	private function parse_query($var){
		$var  = parse_url($var, PHP_URL_QUERY);
		if( $var!== null){
			  $var  = html_entity_decode($var, ENT_NOQUOTES, 'utf-8');
			  $var  = explode('&', $var);
			  $arr  = array();

			  foreach($var as $val)
			   {
				$x          = explode('=', $val);
				$arr[($x[0])] = ($x[1]);
			   }
			  unset($val, $x, $var);
			  return $arr;
		}else{
			return null;
		}
	}
	
/* 	// Cette fonction lit un fichier de type csv (choix du séparateur)
	// retourne un array vide si le fichier est vide
	public static function read_csv($filename, $separateur,$longueur='1024'){
		if(is_file($filename)){	
			if($file=fopen($filename,"r")){
				$table=array();
				while($ligne=fgetcsv($file,$longueur,$separateur)){
					if(!empty($ligne[0])){
						$table[]=$ligne;
					}
				}
				fclose($file);
				//supprime la dernière ligne vide
				return $table;
			}else{
				return false;
			}
		}else{
			return false;
		}
	} */
}


class View{
	/**
	 * Compress contents of a HTML file
	 *
	 * @param string $buffer Contents of a html file
	 * @return string
	 */ 
	public static function minifyHtml($buffer){		// ATTENTION - UTF-8 (be careful with preg_replace)
		$buffer=preg_replace('/<!--(?:.|\s)*?-->/', '', $buffer); 	// remove HTML comment (single and multi line comment)
		//	XXX conflict with <pre> content -> $buffer=preg_replace('/(?:\n|\t)*?/', '', $buffer); 			// remove new line and tab
		/* remove tabs, spaces, newlines, etc. */
		//	XXX conflict with <pre> content -> $buffer = str_replace(array("\r\n", "\r", "\n", "\t"), "", $buffer);
		//	XXX conflict with <pre> content -> $buffer = str_replace(array("  ", "    ", "    "), " ", $buffer);
   
		 //$buffer=preg_replace('{[ \t]+}', ' ' , $buffer); 					// remove space larger than 2 (+)
		return $buffer;
	}

	public static function httpCache($expires,$ageFile,$type)	{
		// Get the page's date in HTTP date format : Thu, 05 Dec 2002 20:13:47 GMT
		$last_modified = gmdate('D, d M Y H:i:s',$ageFile).' GMT';
		$date_last_modified = strtotime($last_modified);
		// Read the headers sent by the browser

		if(function_exists('apache_getenv')){
			$if_modified_since = apache_getenv('HTTP_IF_MODIFIED_SINCE'); // Seems to work on every Php installation [to be confirmed]
																		// but not with free.fr
			
			// Purify the $if_modified_since so that it can be well compared with the page's last modification
			// (The browser usually give this type of string "Thu, 05 Dec 2002 20:13:47 GMT", but some, like Netscape 4.7
			//   give other strings such as ""Fri, 05 Sep 1997 01:03:46 GMT; length=2291") -- Thanks to Eric Segui.
			$if_modified_since = preg_replace ("/^(.*)(Mon|Tue|Wed|Thu|Fri|Sat|Sun)(.*)(GMT)(.*)/", "$2$3 GMT", $if_modified_since);
			// Transform strings into dates
			$date_if_modified_since = strtotime($if_modified_since);
			//$if_modified_since = apache_getenv('HTTP_IF_MODIFIED_SINCE'); // Seems to work on every Php installation [to be confirmed]
		}elseif(isset($_SERVER['HTTP_IF_MODIFIED_SINCE'])){
			$if_modified_since = $_SERVER['HTTP_IF_MODIFIED_SINCE'];
			// Purify the $if_modified_since so that it can be well compared with the page's last modification
			// (The browser usually give this type of string "Thu, 05 Dec 2002 20:13:47 GMT", but some, like Netscape 4.7
			//   give other strings such as ""Fri, 05 Sep 1997 01:03:46 GMT; length=2291") -- Thanks to Eric Segui.
			$if_modified_since = preg_replace ("/^(.*)(Mon|Tue|Wed|Thu|Fri|Sat|Sun)(.*)(GMT)(.*)/", "$2$3 GMT", $if_modified_since);
			// Transform strings into dates
			$date_if_modified_since = strtotime($if_modified_since);
		}
		
	
		if($expires == 0){
			header('Status: 200 OK', false, 200);
			header('HTTP/1.1 200 OK');
			// no-store => pas de mise en cache durable ou volatile !! Important sinon 
			// avec la navigation du navigateur, on retrouve les pages privées...
			// header('Cache-Control: no-cache, no-store, must-revalidate'); // HTTP/1.1
			header('Cache-Control: no-cache, no-store'); // HTTP/1.1
			header('Expires: Sat, 26 Jul 1997 05:00:00 GMT'); // Date dans le passé
			//header('Connection: close');		// on ferme la connection
			//header('Last-Modified: '.gmdate('D, d M Y H:i:s',$_SERVER['REQUEST_TIME']) . ' GMT');
		}elseif(isset($date_if_modified_since) && $date_if_modified_since === $date_last_modified) {  
		// If the server's page hasn't been modified since last visit
		
		//}elseif (isset($date_if_modified_since) && $date_if_modified_since === $date_last_modified){		
			// Tells the browser page hasn't been modified ; the browser will then look for the page in his cache/
			header("HTTP/1.1 304 Not Modified");
			//$etag = md5_file($ageFile);
			$etag = md5($ageFile);
			header('Etag: '.$etag); 
			header('Last-Modified: '.$last_modified);
			header('Cache-Control: max-age='.$expires); // Tells HTTP 1.1 clients to cache
			header('Cache-Control: public', false); 	// Tells HTTP 1.1 clients to cache
			header('Pragma:'); 							// Tells HTTP 1.0 clients to cache
			header('Expires: ' . gmdate('D, d M Y H:i:s', time()+$expires) . ' GMT');
			header('Content-type: '.$type);	
			exit();
		}else{		// else If the server's page has been modified since last visit
			header('Status: 200 OK', false, 200);
			header('HTTP/1.1 200 OK');
			header('Last-Modified: '.$last_modified);
			header('Cache-Control: max-age='.$expires); 	// Tells HTTP 1.1 clients to cache
			header('Cache-Control: public', false); 		// Tells HTTP 1.1 clients to cache
			header('Pragma:'); 								// Tells HTTP 1.0 clients to cache
			header('Expires: ' . gmdate('D, d M Y H:i:s', time()+$expires) . ' GMT');
			header('Content-type: '.$type);
		}
		
		/*
		*/
/* 		
		A quick way to make redirects permanent or temporary is to make use of the $http_response_code parameter in header().

<?php
// 301 Moved Permanently
header("Location: /foo.php",TRUE,301);

// 302 Found
header("Location: /foo.php",TRUE,302);
header("Location: /foo.php");

// 303 See Other
header("Location: /foo.php",TRUE,303);

// 307 Temporary Redirect
header("Location: /foo.php",TRUE,307);
?> */
	}
	
	
	
	public static function printOutFont($filePath,$expires,$ext){
		if(is_file($filePath )){
			//$expires = 60*60*24*369;
			self::httpCache($expires,filemtime($filePath),$ext);			//substr($urlPath[$i], 0, -1)
			readfile($filePath);
			exit();
		}else{
			header('Status: 404 OK');
			header('HTTP/1.1 404 OK');
			exit();
		}
	}
	
	public static function printOutImage($filePath,$expires,$ext){
		if(is_file($filePath )){
			//$expires = 60*60*24*369;
			self::httpCache($expires,filemtime($filePath),'image/'.$ext);			//substr($urlPath[$i], 0, -1)
			readfile($filePath);
			exit();
		}else{
			header('Status: 404 OK');
			header('HTTP/1.1 404 OK');
			exit();
		}
	}
	
	public static function printOutCss($filePath,$expires,$ext='text/css; charset=UTF-8'){
		if(is_file($filePath)){
			//compression gzip
			if(isset($_SERVER['HTTP_ACCEPT_ENCODING'])){
				if(substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')){
					ob_start('ob_gzhandler');
				}else{
					ob_start();
				}
			}else{
				ob_start();
			}
			//$expires = 60*60*24*465;
			self::httpCache($expires,filemtime($filePath),$ext);
			readfile($filePath);
			ob_end_flush();
			exit();
		}else{
			header('Status: 404 OK');
			header('HTTP/1.1 404 OK');
			echo $filePath;
			echo $ext;
			readfile($filePath);
			exit();
		}
	}
	public static function printOutHtml($content,$expires,$recentAgeFile){
		if(isset($_SERVER['HTTP_ACCEPT_ENCODING'])){
			if(substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')){
				ob_start('ob_gzhandler');
			}else{
				ob_start();
			}
		}else{
			ob_start();
		}
		self::httpCache($expires,$recentAgeFile,'text/html');
		$content=self::minifyHtml($content);
		echo $content;
		ob_end_flush();
	}
	
	public static function printOutPdf($content,$name,$expires,$recentAgeFile,$attachment=1){
		header('Status: 200 OK', false, 200);
		header('HTTP/1.1 200 OK');
		require(BASE_PATH.'/lib/dompdf/dompdf_config.inc.php');
		$dompdf = new DOMPDF();
		$dompdf->load_html(utf8_decode($content));
		//$dompdf->set_paper('4a0', 'portrait');
		$dompdf->render();
		 $dompdf->stream($name.".pdf");
		//$dompdf->stream($name, array('Attachment' => intval($attachment)));
		ob_end_flush();
	
	}

	/*
	public static function printOutCMS()
    {
        foreach ($this->_headers as $key => $value) {
            header($key. ':' . $value);
        }
        //echo $this->_body;
    } 
	*/

}

$time_end = microtime(true);
$time = $time_end - $time_start;

/*

echo '<br/>';
echo '<br/>';
echo 'PATH_INFO:'.$_SERVER['PATH_INFO'];
echo '<br/>';
echo 'SERVER_NAME:'.$_SERVER['SERVER_NAME'];
echo '<br/>';
echo 'DOCUMENT_ROOT:'.$_SERVER['DOCUMENT_ROOT'];
echo '<br/>';
echo 'QUERY_STRING:'.$_SERVER['QUERY_STRING'];
echo '<br/>';
echo 'REQUEST_URI:'.$_SERVER['REQUEST_URI'];
echo '<br/>';
echo 'SCRIPT_NAME:'.$_SERVER['SCRIPT_NAME']; */


?>