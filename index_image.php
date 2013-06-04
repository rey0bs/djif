<?php
	
	require_once('config/config.php');
	require_once('toolbox.php');

	$hash = $_GET['hash'];
	$db =  accessDB();

	$result = $db->query("SELECT preview FROM djifs WHERE hash = '$hash';");
	$row = $result->fetch_assoc();
	if( empty($row) ) {
		header("HTTP/1.0 404 Not Found");
		echo 'Image not found';
	} else {
		header('Content-type: image/jpg');
		echo $row['preview'];
	}

?>
