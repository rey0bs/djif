<?php
	$gif_url = $_POST['gif_url'];
	$audio_url = $_POST['audio_url'];
	
	$imgDjif = new Djif( $gif_url );
	$img = $imgDjif->getMedia();
	
	$audioDjif = new Djif( $audio_url );
	$audio = $audioDjif->getMedia();
?>
<div id="screen">
<?php
	echo $img->render();
?>
</div>
<div id="speaker">
<?php
	echo $audio->render();
?>
</div>
