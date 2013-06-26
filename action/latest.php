<?php
	require_once('config/config.php');
	require_once('classes/dao.php');
	require_once('classes/media.php');
	require_once('classes/djif.php');
	require_once('classes/sequence.php');

	$dao = new Dao();
	$seq = new Sequence($dao);
	$djif = $dao->getNthDjifBy($seq->getN(), 'date');
	echo $djif->render(array('[[ajax]]' => ($ajax?1:0)));
	include('templates/buttons/make.html');
	$seq->render('latest');

?>

