<?php
	require_once('config/config.php');
	require_once('classes/media.php');
	require_once('classes/djif.php');

	include('templates/form.html');

	$db =  new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);

	if ($db->connect_errno) {
		die ("Could not connect db " . DB_NAME . "\n" . $link->connect_error);
	}
	$result = $db->query("SELECT hash,gif,audio,preview FROM urls ORDER BY date DESC LIMIT 3;");
	while ($row = $result->fetch_assoc()) {
		$djif = new Djif($row);
		echo $djif->render();
	}
	

?>

