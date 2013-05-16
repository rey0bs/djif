</script>
	<script src="https://www.youtube.com/player_api" type="text/javascript"></script>
	<script>
		var _[[hash]]_player;

		function onYouTubeIframeAPIReady() {
			_[[hash]]_player = new YT.Player('_[[hash]]_speaker', {
				width: '[[width]]',
				height: '349',
				events: {
					'onReady': function () {
						_[[hash]]_player.cueVideoById('[[ythash]]');
					}
				}
			});
		} 

		function _[[hash]]_speaker_play() {
			_[[hash]]_player.playVideo();
		}

		function _[[hash]]_speaker_stop() {
			_[[hash]]_player.stopVideo();
		}
