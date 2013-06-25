<?php
	require_once('config/config.php');
	require_once('classes/media.php');
	require_once('classes/djif.php');
	require_once('classes/sequence.php');

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
		ORDER BY visits DESC";
	$seq = new Sequence();
	$select .= $seq->getLimitStatement();
	$result = $db->query($select);
	while ($row = $result->fetch_assoc()) {
		$djif = Djif::fromAssoc($row);
		echo $djif->render();
	}
	include('templates/buttons/make.html');
	$seq->render('top');

?>


