<?php
	require_once('config/config.php');
	$db = accessDB();
	$hash = $db->real_escape_string(substr($_GET['hash'],0,5));
	$select = "
		SELECT
			gif.url as gifUrl,
			audio.url as audioUrl
		FROM
			djifs,
			media as gif,
			media as audio
		WHERE
		hash = '$hash'
		AND djifs.gif = gif.id
	 	AND djifs.audio = audio.id;";
	$result = $db->query($select);
	if ($row = $result->fetch_assoc()) {
		$form = file_get_contents('templates/form.html');
		$placeHolder = array('[[gifUrl]]' => $row["gifUrl"], '[[audioUrl]]' => $row["audioUrl"]);
		echo replacePlaceHolders($form, $placeHolder);
	} else {
		fail($db);
	}
?>
