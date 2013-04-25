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
								audio_url: $('#soundSource').val(),
								ajax : true	}
			}).done(function( output ) {
				$('#action').append( output );
			});
			return false;
		});
	</script>
</form>
