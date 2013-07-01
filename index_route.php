<?php

	if(isset($_GET['lang']) && $_GET['lang'] == 'fr') {
		$lang = 'fr';
	} else {
		$lang = 'en';
	}
	require_once("lang/$lang.php");
	require_once('toolbox.php');

	$action = $_GET['action'];
	$lead = LEAD_REGULAR;
	if($action == '') {
		$action = 'home';
	}
	$page = 'action/' . $action . '.php';
	if(! file_exists($page)) {
		$page = 'action/get.php';
		$lead = LEAD_EXPLAIN;
	}

?>
