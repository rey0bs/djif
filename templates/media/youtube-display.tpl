<script>
	audio_load['[[hash]]'] = function() {
		insert_youtube ('[[hash]]', '[[yt_hash]]', '[[width]]', 0);
	}
	audio_play['[[hash]]'] = function() {
		/*if( $('#_[[hash]]_djif').attr('data-hasplayed') == 'true') {
			players['hash'].playVideo();
		} else {
			$('#_[[hash]]_djif').attr('data-hasplayed', 'true');
		}
		players['hash'].seekTo('[[start]]');*/
		console.log("Start audio");
	}
	audio_stop['[[hash]]'] = function() {
		//players['hash'].stopVideo();
		console.log("Stop audio");
	}
</script>