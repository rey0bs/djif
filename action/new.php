<?php
	require_once('config/config.php');
	require_once('classes/media.php');
	require_once('classes/djif.php');
	$gif_url = htmlentities($_POST['gif_url']);
	$audio_url = htmlentities($_POST['audio_url']);
	$djif = Djif::fromUrls( $gif_url, $audio_url );
	if($djif->isValid()) {
		echo $djif->store();
		echo $djif->render(array('[[ajax]]' => ($ajax?1:0)));
	} else {
		fail();
	}

?>
