<!DOCTYPE html>
<html>
	<head>
	<title><?php echo SITE_TITLE;?></title>
		
		<meta charset='utf-8'>
		
		<link rel="stylesheet" type="text/css" href="/typo/iconic_stroke/iconic_stroke.css">
		<link rel="stylesheet" type="text/css" href="/css/normalize.css">
		<link rel="stylesheet" type="text/css" href="/js/diaspora-share-button/eraser.css">
		<link rel="stylesheet" type="text/css" href="/css/montage.css">
		<link rel="stylesheet" type="text/css" href="/css/style.css">
		<script src="/js/jquery-1.9.1.min.js"></script>
		<script src="/js/jquery.easing.min.js"></script>
		<script src="/js/jquery.montage.min.js"></script>
		<script src="https://www.youtube.com/player_api" type="text/javascript"></script>
		<link rel="Shortcut icon" href="/images/favicon.ico" type="image/x-icon" />
		<link rel="icon" href="/images/favicon.ico" type="image/x-icon">
	</head>
	<body>
	<?php if ($action != 'ie') {?>
		<!--[if lt IE 10 ]>
		<script type="text/javascript"> 
			document.location = "/ie";
		</script>
		<![endif]-->
	<?php } ?>
	<script>
	var players = [];
	var audio_load = [];
	var audio_play = [];
	var audio_stop = [];
	var gif_load = [];
	//var gif_stop = [];
	</script>
		<div id="page">
			<h1 id="logo"><a href="/">DJif</a></h1>
			<?php interpret('templates/lead.html', $lead);?>
			<div id="menu">
				<a class="button rond<?php echo ($action == 'top')?' active':''; ?>" href="/top" title="<?php echo HEADER_TITLE_TOP;?>"><span class="iconic heart_stroke"></span></a>
				<a class="button rond<?php echo ($action == 'wtf')?' active':''; ?>" href="/wtf" title="<?php echo HEADER_TITLE_WTF;?>"><span class="iconic reload"></span></a>
				<a class="button rond<?php echo ($action == 'latest')?' active':''; ?>" href="/latest" title="<?php echo HEADER_TITLE_LATEST;?>"><span class="iconic clock"></span></a>
			</div>
			<div id="action">

