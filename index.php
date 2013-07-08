<?php
	include('index_route.php');
	include('templates/includes/header.php');
	$ajax = false;
	include('templates/piwik.html');
	include($page);
	include('templates/includes/footer.php');
?>
