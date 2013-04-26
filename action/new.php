<?php
	$gif_url = $_POST['gif_url'];
	$audio_url = $_POST['audio_url'];
	
	$imgDjif = new Djif( $gif_url );
	$img = $imgDjif->getReader();
	
	$audioDjif = new Djif( $audio_url );
	$audio = $audioDjif->getReader();

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