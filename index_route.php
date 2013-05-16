<?php
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
	$error = false;

?>
