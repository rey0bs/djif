<!DOCTYPE html>
<html>
	<head lang="<?php echo LOCALE;?>">
		<title><?php echo SITE_TITLE;?></title>
		
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		
		<meta name="description" content="<?php echo SITE_DESCRIPTION;?>">
		<meta name="keywords" content="<?php echo SITE_KEYWORDS;?>">
		
		<meta name="rating" content="general">
		<meta name="revisit-after" content="1 day">
		
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
				<div class="small_link">
					<span class="iconic pin"></span> <a href="https://twitter.com/intent/follow?original_referer=https%3A%2F%2Ftwitter.com%2Fsettings%2Fwidgets%2F319952321515757568%2Fedit&partner=undefined&region=follow_link&screen_name=DjifNet&tw_p=followbutton&variant=2.0"><?php echo FOLLOW_US; ?></a>
				</div>
			</div>
			<div id="action">

