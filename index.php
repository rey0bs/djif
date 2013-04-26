<?php
	require_once('classes/djif.php');
	
	if (! $_POST['ajax']) {
		include('templates/header.php');
		include('templates/form.php');
	}
	include('config/config.php');
	$action = $_GET['action'];
	if($action == '') {
		$action = 'home';
	}
	$page = 'action/' . $action . '.php';
	if(! file_exists($page)) {
		$page = 'action/view.php';
	}
	include($page);
	if (! $_POST['ajax']) {
		include('templates/footer.php');
	}
?>
