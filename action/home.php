<?php
	require_once('config/config.php');
	require_once('classes/media.php');
	require_once('classes/djif.php');
	if (isset($_POST['from']) && $_POST['from'] == 'contact') {
		echo '<p class="quote">If you\'re the best, make your own djif ! ^^</p>';
	}
	$form = file_get_contents('templates/form.html');
	echo replacePlaceHolders($form, array('[[gifUrl]]' => '', '[[audioUrl]]' => ''));

?>

