<?php
	require_once('config/config.php');
	require_once('classes/dao.php');
	require_once('classes/media.php');
	require_once('classes/djif.php');

	$dao = new Dao();
	//$djif = Djif::fromHash($db, $action );
	$djif = $dao->getDjifByHash($action);
	if ($djif && $djif->isValid()) {
		echo $djif->render(array('[[ajax]]' => ($ajax?1:0)));
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
			include('templates/buttons/make.html');
		}
	} else {
		fail();
	}
?>

