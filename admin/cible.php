<?php
session_start();

	 function stripslashes_r($var){
		if(is_array($var)){
			return array_map('stripslashes_r', $var);
		} else{
			return stripslashes($var);
		}
	}

if(empty($_SESSION['cible']) or !isset($_SESSION['cible'])){
     header('Location: '.$_SERVER['HTTP_HOST'].rtrim(dirname($_SERVER['PHP_SELF']), '/\\').'/');
}else{
	//$anchor = parse_url($url, PPHP_URL_FRAGMENT );
	//if(isset($anchor)) $anchor = '#'.$anchor;
	$anchor = '';
 	if(get_magic_quotes_gpc()) {
        $_POST = stripslashes_r($_POST);
        $_GET = stripslashes_r($_GET);
        $_COOKIE = stripslashes_r($_COOKIE);
		
	}
	


	
	$_SESSION['post'] = $_POST;
	$_SESSION['files'] = $_FILES;
	header('Location: '.$_SESSION['cible'].$anchor);
}
?>
