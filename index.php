<?php
	require_once('config/config.php');
	require_once('classes/media.php');
	require_once('classes/djif.php');
	
	if (! $_POST['ajax']) {
		include('templates/includes/header.php');
		
	}
	$action = $_GET['action'];
	if($action == '') {
		$action = 'home';
	}
	$page = 'action/' . $action . '.php';
	if(! file_exists($page)) {
		$page = 'action/get.php';
	}
	include($page);
	if (! $_POST['ajax']) {
		include('templates/form.html');
		include('templates/includes/footer.php');
	}
?>
