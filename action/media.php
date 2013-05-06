<?php
	$url = $_POST['url'];

	$media = new Media( $url );
	$media = $media->getMedia();
	
	if($media->isValid()) {
		echo $media->render(array('[[width]]' => '', '[[height]]' => ''));
	} else {
		include('templates/errors/invalidresource.html');
	}
?>
