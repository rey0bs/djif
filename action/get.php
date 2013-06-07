<?php
	require_once('config/config.php');
	require_once('classes/media.php');
	require_once('classes/djif.php');
	$djif = Djif::fromHash( $action );
	if ($djif->isValid()) {
		echo $djif->render();
		if ($ajax) {
?>
	<style type="text/css">
	.djif {
		width: 500px;
		margin: 0 auto;
	}

	#screen {
		width : 100%;
		margin: 0 auto 10px;
		/*border : 2px solid black;*/
	}

	#screen img {
		width : 100%;
	}

	#speaker > *, .input_group.sound_group .preview > * {
			bottom: 0;
			position: absolute;
			left: 0;
			width: 100%;
	}
	</style>
<?php
		} else {
			include('templates/buttons/make.tpl');
		}
	} else {
		fail($djif->db);
	}
?>

