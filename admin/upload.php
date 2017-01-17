<?php
/* session_start();
if(empty($_SESSION['cible']) or !isset($_SESSION['cible'])){
     header('Location: '.$_SERVER['HTTP_HOST'].rtrim(dirname($_SERVER['PHP_SELF']), '/\\').'/');
}else{
	$_SESSION['post'] = $_POST;
	$_SESSION['files'] = $_FILES; */
	
	/* define('ADMIN_PATH',realpath('.'));						// for server side inclusions (wamp/www/interstitium/admin).
	define('BASE_PATH',dirname(ADMIN_PATH));				// for server side inclusions (wamp/www/interstitium).
	define('ADMIN_URL', dirname($_SERVER['SCRIPT_NAME']));	// for client side inclusions (scripts, css files, images etc.)
	define('BASE_URL', dirname(ADMIN_URL));	// for client side inclusions (scripts, css files, images etc.)
	
	// location du script
	$mimePath = 'conf/upload-files.ini';
	$mimeTypes = parse_ini_file($mimePath, true);			// config data
	
	$i = 1;
	$dossierDestination = BASE_PATH.'/data/documents/images/';
	$dest_fichier = basename($_FILES['photo']['name'][$i]);
	// formatage nom fichier
				// enlever les accents
				$dest_fichier = strtr($dest_fichier,
				'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ',
				'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');

				// remplacer les caracteres autres que lettres, chiffres et point par -
				$dest_fichier = preg_replace('/([^.a-z0-9]+)/i', '-', $dest_fichier);
				
	if (! is_dir($dossierDestination)){
			echo 'Dossier introuvable! Contacter le webmaster! <br/>'.$dossierDestination;
			echo '<br/>';
		}
	if(file_exists($_FILES['photo']['tmp_name'][$i])){
					echo 'le fichier existe!!!';
				}else{
					echo 'le fichier n existe pas!!!';
					
				}
	
	echo '<br/>';
	echo '<br/>';
	echo $_FILES['photo']['tmp_name'][$i];
	echo '<br/>';
	echo $dossierDestination.$dest_fichier;
	if(!move_uploaded_file($_FILES['photo']['tmp_name'][$i], $dossierDestination.$dest_fichier)){
	
		echo 'echec de l upload!!!';
	}
	 */
	 $requestUri = $_GET['cible'] ; // $_SESSION['cible'];
	include('index.php');
	//header('Location: '.$_SESSION['cible']);
/* } */
?>
