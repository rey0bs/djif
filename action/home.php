<?php
	require_once('config/config.php');
	require_once('classes/media.php');
	require_once('classes/djif.php');

	$form = file_get_contents('templates/form.html');
	echo render($form, array('[[gifUrl]]' => '', '[[audioUrl]]' => ''));

	$db = accessDB();
	$select = "
		SELECT
		hash,
		gif.url AS gif,
		gif.type AS gifType,
		audio.url AS audio,
		audio.type AS audioType,
		gif.width, gif.height
		FROM djifs, media AS gif, media AS audio
		WHERE djifs.gif = gif.id AND djifs.audio = audio.id
		ORDER BY date DESC LIMIT 10";
	$result = $db->query($select);
	echo '<div class="latest" id="mozaique">';
	while ($row = $result->fetch_assoc()) {
		$djif = Djif::fromAssoc($row);
		echo $djif->render();
	}
	echo '</div>';

?>

