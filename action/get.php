<?php
	$djif = new Djif( $action );
	if ($djif->isValid()) {
		echo $djif->render();
	} else {
		$i = rand (0, count(glob('templates/errors/msg*.html')) - 1);
		include("templates/errors/msg$i.html");
	}
	include('templates/intro.html');
?>

