<?php
	require_once('classes/db.php');

	$hash = $link->real_escape_string($action);
	$result = $link->query("SELECT gif, audio FROM urls WHERE hash = '$hash'");
	$row = $result->fetch_assoc();

	$gif_url = $row["gif"];
	$audio_url = $row["audio"];

	$result->free();
	
	$djif = new Djif( $gif_url, $audio_url );
	echo $djif->render();
?>

