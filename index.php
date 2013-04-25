<?php
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
?>
