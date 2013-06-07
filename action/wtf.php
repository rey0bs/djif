<?php
	require_once('config/config.php');
	require_once('classes/media.php');
	require_once('classes/djif.php');

	$djif = Djif::random();
	echo $djif->render();
	include('templates/buttons/make.html');

?>
