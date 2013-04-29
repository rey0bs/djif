<?php
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

