<?php
session_start();
if(empty($_SESSION['cible']) or !isset($_SESSION['cible'])){
     header('Location: '.$_SERVER['HTTP_HOST'].rtrim(dirname($_SERVER['PHP_SELF']), '/\\').'/');
}else{
	$_SESSION['post'] = $_POST;
	header('Location: '.$_SESSION['cible']);
}
?>
