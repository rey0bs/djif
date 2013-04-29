<?php
	$link = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);

	if ($link->connect_errno) {
		die ("Could not connect db " . DB_NAME . "\n" . $link->connect_error);
	}
?>
