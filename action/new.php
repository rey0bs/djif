<?php
	$gif_url = $_POST['gif_url'];
	$audio_url = $_POST['audio_url'];
	
	$charset = array_merge(range(0,9), range('a','z'), range('A', 'Z'));
	$hash = '';
	for ($i=0; $i < 5; $i++) {
		$hash .= $charset[array_rand($charset)];
	}

	echo("will get tag $hash");
	include('action/view.php');
?>
