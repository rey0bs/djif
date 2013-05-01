<form action="/new" method="post" id="new_djif">

	<div class="input_group gif_group">
		<span class="iconic camera"></span>
		<label for="gif_url">Gif<span class="small">URL of your gif</span></label>
		<input id="gifSource" type="text" name="gif_url" onclick="select()" />
		<div id="plus">+</div>
	</div>

	<div class="input_group sound_group">
		<span class="iconic play_alt"></span>
		<label for="audio_url">Sound<span class="small">Youtube, MP3, Dailymotion...</span></label>
		<input id="soundSource" type="text" name="audio_url" onclick="select()" />
	</div>

	<input id="remix" type="submit" value="="/><p id="tooltip">Choose a gif and a sound to mix together</p>
	
</form>
