<?php
	require_once('config/config.php');
	require_once('classes/media.php');
	require_once('classes/djif.php');
	if (isset($_POST['from']) && $_POST['from'] == 'contact') {
		echo '<p class="quote">'.HOME_BOAST_ANSWER.' ^^</p>';
	}
	$pholders = array(
		'[[gifUrl]]' => '',
		'[[audioUrl]]' => '',
		'[[make_form_gif]]' => MAKE_FORM_GIF,
		'[[make_form_gif_details]]' => MAKE_FORM_GIF_DETAILS,
		'[[make_form_audio]]' => MAKE_FORM_AUDIO,
		'[[make_form_audio_details]]' => MAKE_FORM_AUDIO_DETAILS,
		'[[make_form_mix_button]]' => MAKE_FORM_MIX_BUTTON,
		'[[make_form_tooltip]]' => MAKE_FORM_TOOLTIP,
	);
	interpret('templates/form.html', $pholders);

?>

