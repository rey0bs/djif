<?php
	
	require_once('config/config.php');
	require_once('classes/dao.php');
	require_once('toolbox.php');

	$hash = $_GET['hash'];
	$dao =  new Dao();

	$preview = $dao->preview($hash);
	if($preview) {
		header('Content-type: image/jpg');
		echo $preview;
	} else {
		header("HTTP/1.0 404 Not Found");
		echo 'Image not found';
	}

?>
