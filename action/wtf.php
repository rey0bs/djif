<?php
	require_once('config/config.php');
	require_once('classes/dao.php');
	require_once('classes/media.php');
	require_once('classes/djif.php');
	require_once('classes/sequence.php');

	$dao = new Dao();
	$seq = new Sequence($dao, 'wtf', true);
	$djif = $dao->getRandomDjif();
	echo $djif->render(array('[[ajax]]' => ($ajax?1:0)));
	interpret('templates/buttons/make.html', MAKE_BUTTON);
	echo $seq->command('random');

?>
