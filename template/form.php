<form action="/new" method="post" id="new_djif">

	<div class="input_group gif_group">
		<span class="iconic camera"></span>
		<label for="gif_url">Gif</label>
		<input id="gifSource" type="text" name="gif_url" onclick="select()" />
	</div>

	<span class="iconic plus_alt"></span>

	<div class="input_group sound_group">
		<span class="iconic play_alt"></span>
		<label for="audio_url">Sound</label>
		<input id="soundSource" type="text" name="audio_url" onclick="select()" />
	</div>

	<input id="remix" type="submit" value="Remix !"/>

</form>
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

