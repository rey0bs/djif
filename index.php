<?php
	include('index_route.php');
	include('templates/includes/header.php');
	$ajax = false;
	include($page);
	if($error) {
		$i = rand (0, count(glob('templates/errors/msg*.html')) - 1);
		include("templates/errors/msg$i.html");
	}
	include('templates/includes/footer.php');
?>
