<?php
	require_once('config/config.php');
	require_once('classes/dao.php');
	require_once('classes/media.php');
	require_once('classes/djif.php');

	$gif_url = htmlentities($_POST['gif_url']);
	$audio_url = htmlentities($_POST['audio_url']);
	$dao = new Dao();
	$djif = Djif::fromUrls( $dao, $gif_url, $audio_url );
	if($djif->isValid()) {
		$djif->store($dao); // print the share button with a link
		echo $djif->render(array('[[ajax]]' => ($ajax?1:0)));
	} else {
		fail();
	}

?>
