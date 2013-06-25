<?php
	require_once('config/config.php');
	require_once('classes/media.php');
	require_once('classes/djif.php');
	require_once('classes/sequence.php');

	$djif = Djif::random();
	echo $djif->render(array('[[ajax]]' => ($ajax?1:0)));
	include('templates/buttons/make.html');
	$seq = new Sequence();
	$seq->render('wtf');

?>
