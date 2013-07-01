<?php
	require_once('config/config.php');
	require_once('classes/dao.php');
	require_once('classes/media.php');
	require_once('classes/djif.php');

	$dao = new Dao();
	//$djif = Djif::fromHash($db, $action );
	$djif = $dao->getDjifByHash($action);
	if ($djif && $djif->isValid()) {
		echo $djif->render(array('[[ajax]]' => ($ajax?1:0)));
		if ($ajax) {

		} else {
			interpret('templates/buttons/make.html', MAKE_BUTTON);
		}
	} else {
		fail();
	}
?>

