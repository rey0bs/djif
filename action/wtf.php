<?php
	require_once('config/config.php');
	require_once('classes/media.php');
	require_once('classes/djif.php');

	$djif = Djif::random();
	echo $djif->render(array('[[ajax]]' => ($ajax?1:0)));
	include('templates/buttons/make.html');
	$n = 0;
	$text = 'Another !';
	if(isset($_POST['n'])) {
		$n = $_POST['n'];
		switch ($n) {
			case 1:
				$text = 'Another one !';
				break;
			case 2:
				$text = 'Yet another !';
				break;
			case 3:
				$text = 'Again !';
				break;
			case 4:
			case 5:
				$text = 'And again !';
				break;
			case 6:
				$text = 'Please another one';
				break;
			case 7:
				$text = 'Just one more !';
				break;
			case 8:
				$text = 'Or two ?';
				break;
			case 9:
				$text = 'Ok last one';
				break;
			case 10:
				$text = 'Shouldn\' I be working ?';
				break;
			case 11:
				$text = 'Last one this time';
				break;
			case 12:
				$text = 'But this time I mean it';
				break;
			case 13:
				$text = 'I promise';
				break;
			case 14:
				$text = 'I can quit anytime';
				break;
			case 15:
				$text = 'I kan haz lil moa ?';
				break;
			default:
				$text = 'Ok I\'ll stop last year';
				break;
		}
	}
	$n += 1;
	$pholders = array(
		'[[text]]' => $text,
		'[[n]]' => $n
	);
	echo replacePlaceHolders(file_get_contents('templates/buttons/yanother.tpl'), $pholders);

?>
