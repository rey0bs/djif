<?php
	require_once( 'classes/youtube.php' );
	$gif_url = $_POST['gif_url'];
	$audio_url = $_POST['audio_url'];
	$reader = new Youtube($audio_url);
	echo $reader->render();
?>
<div id="screen">
	<img src="<?php echo($gif_url); ?>"/>
</div>
<div id="speaker">
<?php
	//$reader->render();
?>
</div>

