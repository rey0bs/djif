<?php
	require_once('config/config.php');
	require_once('classes/media.php');
	require_once('classes/djif.php');
	
	$action = $_GET['action'];
	if($action == '') {
		$action = 'home';
		$lead = 'templates/leads/regular.html';
	}
	$page = 'action/' . $action . '.php';
	if(! file_exists($page)) {
		$page = 'action/get.php';
		$lead = 'templates/leads/explain.html';
	}
	if (! $_POST['ajax']) {
		include('templates/includes/header.php');
	}
	include($page);
	if (! $_POST['ajax']) {
		include('templates/includes/footer.php');
	}
?>
