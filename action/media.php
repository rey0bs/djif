<?php
	$url = $_POST['url'];

	$media = new Media( $url );
	$media = $media->getMedia();
	
	echo $media->render(array('[[width]]' => '', '[[height]]' => ''));
?>