<html>
	<head>
		<meta charset='utf-8'>
		<link rel="stylesheet" type="text/css" href="css/normalize.css">
		<link rel="stylesheet" type="text/css" href="css/style.css">
		<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
	</head>
	<body>
		<script>
			function render() {
				$.ajax({
					type: "POST",
					url: "/new",
					data: { gif_url: $('#gifSource').val(),
									audio_url: $('#soundSource').val() }
				}).done(function( output ) {
					$('#screen').html( output );
				});
			};
		</script>

		<div id="page">
			<h1>DJif</h1>
			<p class="lead">Remix the hell out of your gifs</p>
			<div id="action">
				<form>
					<center>
						Gif : <input id="gifSource" type="text"><br>
						<p>+</p>
						sound : <input id="soundSource" type="text"><br>
						<p>=</p>
						<button type="Button" onclick="render();">Remix !</button>
					</center>
				</form>
				<div id="screen"></div>
				<div id="speaker"></div>
			</div>
		</div>
	</body>
</html>
