<?php
	include('readers/youtube.php');

	$gif_url = $_POST['gif_url'];
	$audio_url = $_POST['audio_url'];
	if (substr($audio_url,0,16) == 'http://youtu.be/') {
		$reader = new Youtube($audio_url);
	}

?>
<div id="screen">
	<img src="<?php echo($gif_url); ?>"/>
</div>
<div id="speaker">
<?php
	$reader->render();
?>
</div>

