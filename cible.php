<?php
session_start();
if(empty($_SESSION['cible']) or !isset($_SESSION['cible'])){
     header('Location: '.$_SERVER['HTTP_HOST'].rtrim(dirname($_SERVER['PHP_SELF']), '/\\').'/');
}else{
	if(get_magic_quotes_gpc()) {
        $_POST = array_map('stripslashes', $_POST);
        $_GET = array_map('stripslashes', $_GET);
        $_COOKIE = array_map('stripslashes', $_COOKIE);
	}

	$_SESSION['post'] = $_POST;
	header('Location: '.$_SESSION['cible']);
}
?>
