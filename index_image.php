<?php
	
	require_once('config/config.php');

	$hash = $_GET['hash'];
	$db =  new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);

	if ($db->connect_errno) {
		die ("Could not connect db " . DB_NAME . "\n" . $link->connect_error);
	}
	$result = $db->query("SELECT preview FROM urls WHERE hash = '$hash';");
	$row = $result->fetch_assoc();
	if( empty($row) ) {
		header("HTTP/1.0 404 Not Found");
		echo 'Image not found';
	} else {
		header('Content-type: image/jpg');
		echo $row['preview'];
	}

?>
