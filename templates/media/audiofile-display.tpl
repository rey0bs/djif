<script>
	audio_load['[[hash]]'] = function() {
		var _[[hash]]_speaker = document.createElement('audio');
		_[[hash]]_speaker.id = "_[[hash]]_speaker";
		_[[hash]]_speaker.controls = true;
		_[[hash]]_speaker.loop = true;
		_[[hash]]_speaker.src = "[[url]]";
		_[[hash]]_speaker.onclick = function() { document.getElementById('_[[hash]]_djif').setAttribute('data-actif','ignore'); }
		_[[hash]]_speaker.onpause = function() { disableDjif('[[hash]]'); }
		_[[hash]]_speaker.onplay = function() { enableDjif('[[hash]]'); }
	
		document.querySelector('#_[[hash]]_djif .speaker').replaceChild(_[[hash]]_speaker, document.getElementById('_[[hash]]_speaker'));
	}
	
	audio_play['[[hash]]'] = function() {
		_[[hash]]_speaker.currentTime = 0;
		_[[hash]]_speaker.play();
	}
	
	audio_stop['[[hash]]'] = function() {
		_[[hash]]_speaker.pause();
	}
</script>