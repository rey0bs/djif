<?php
	include('index_route.php');
	include('templates/includes/header.php');
	$ajax = false;
	include($page);
	include('templates/includes/footer.php');
?>
