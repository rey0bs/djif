<?php
	$gif_url = htmlentities($_POST['gif_url']);
	$audio_url = htmlentities($_POST['audio_url']);
	
	$djif = new Djif( $gif_url, $audio_url );
	echo $djif->store();
	echo $djif->render();

?>
