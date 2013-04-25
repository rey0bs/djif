<html>
	<head>
		<meta charset='utf-8'>
		<link rel="stylesheet" type="text/css" href="css/normalize.css">
		<link rel="stylesheet" type="text/css" href="css/style.css">
		<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
	</head>
	<body>
		<div id="page">
			<h1>DJif</h1>
			<p class="lead">Remix the hell out of your gifs</p>
			<div id="action">
				<form action="/new" method="post">
					<center>
						Gif : <input id="gifSource" type="text" name="gif_url"><br>
						<p>+</p>
						sound : <input id="soundSource" type="text" name="audio_url"><br>
						<p>=</p>
						<input id="submit" type="submit" value="Remix !"/>
					</center>
					<script>
						$('form').submit(function() {
							$.ajax({
								type: "POST",
								url: "/new",
								data: { gif_url: $('#gifSource').val(),
												audio_url: $('#soundSource').val() }
							}).done(function( output ) {
								$('#screen').html( output );
							});
							return false;
						});
					</script>
				</form>
				<div id="screen"></div>
				<div id="speaker"></div>
			</div>
		</div>
	</body>
</html>
