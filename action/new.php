<?php
	$gif_url = $_POST['gif_url'];
	$audio_url = $_POST['audio_url'];
	
	$djif = new Djif( $gif_url, $audio_url );
	echo $djif->render();
?>
