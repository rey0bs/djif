<?php

	require_once('toolbox.php');

	$action = $_GET['action'];
	$lead = 'templates/leads/regular.html';
	if($action == '') {
		$action = 'home';
	}
	$page = 'action/' . $action . '.php';
	if(! file_exists($page)) {
		$page = 'action/get.php';
		$lead = 'templates/leads/explain.html';
	}
	$error = false;

?>
