<?php
	include('index_route.php');
	$ajax = true;
	include($page);
	if($error) {
		throw new Exception('Ta yeule');
	}
?>
