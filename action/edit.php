<?php
	require_once('config/config.php');
	require_once('classes/dao.php');

	$dao = new Dao();
	$placeHolder = $dao->getUrlsFromHash($_GET['hash']);
	if($placeHolder) {
		$form = file_get_contents('templates/form.html');
		echo replacePlaceHolders($form, $placeHolder);
	} else {
		fail();
	}

?>
