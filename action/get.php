<?php
	require_once('config/config.php');
	require_once('classes/media.php');
	require_once('classes/djif.php');
	$djif = Djif::fromHash( $action );
	if ($djif->isValid()) {
		echo $djif->render(array('[[ajax]]' => ($ajax?1:0)));
		if ($ajax) {

		} else {
			include('templates/buttons/make.html');
		}
	} else {
		fail($djif->db);
	}
?>

