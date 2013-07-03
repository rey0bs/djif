<?php
	require_once('config/config.php');
	require_once('classes/dao.php');

	$dao = new Dao();
	$placeHolder = $dao->getUrlsFromHash($_GET['hash']);
	if($placeHolder) {
		$pholders = array_merge ((array) $placeHolder, array(
			'[[make_form_gif]]' => MAKE_FORM_GIF,
			'[[make_form_gif_details]]' => MAKE_FORM_GIF_DETAILS,
			'[[make_form_audio]]' => MAKE_FORM_AUDIO,
			'[[make_form_audio_details]]' => MAKE_FORM_AUDIO_DETAILS,
			'[[make_form_mix_button]]' => MAKE_FORM_MIX_BUTTON,
			'[[make_form_tooltip]]' => MAKE_FORM_TOOLTIP,
		));
		interpret('templates/form.html', $pholders);
	} else {
		fail();
	}

?>
