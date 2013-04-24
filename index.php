<?php
	$action = $_GET['action'];
	if($action == '') {
		$action = 'home';
	}
	include('action/' . $action . '.php');
?>
