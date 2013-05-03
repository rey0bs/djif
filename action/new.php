<?php
	$gif_url = htmlentities($_POST['gif_url']);
	$audio_url = htmlentities($_POST['audio_url']);
	
	$djif = new Djif( $gif_url, $audio_url );
	if($djif->isValid()) {
		echo $djif->store();
		echo $djif->render();
	} else {
		if($_POST['ajax']) {
			throw new Exception('Ta yeule');
		} else {
			$i = rand (0, count(glob('templates/errors/msg*.html')) - 1);
			include("templates/errors/msg$i.html");
		}
	}

?>
