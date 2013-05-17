/*	var _[[hash]]_player = document.createElement('audio');
	_[[hash]]_player.setAttribute('id', '_[[hash]]_speaker');
	_[[hash]]_player.setAttribute('controls', true);
	_[[hash]]_player.setAttribute('src', '[[url]]');
	_[[hash]]_player.setAttribute('type', 'audio/[[format]]');
	//alert(document.getElementById('_[[hash]]_speaker').parentNode.innerHTML);*/
	document.getElementById('_[[hash]]_speaker').parentNode.innerHTML = '<audio controls loop id="_[[hash]]_player"><source src="[[url]]" type="audio/[[format]]"/></audio>';

	function _[[hash]]_speaker_play() {
		_[[hash]]_player.play();
	}

	function _[[hash]]_speaker_stop() {
		_[[hash]]_player.pause();
		_[[hash]]_player.currentTime = 0;
	}
