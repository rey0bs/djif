</script>
	<script src="https://www.youtube.com/player_api" type="text/javascript"></script>
	<script>
		var _[[hash]]_player;

		function load_[[hash]]_audio(activate) {
			if (activate) {
				_[[hash]]_player = new YT.Player('_[[hash]]_speaker', {
					width: '[[width]]',
					height: '349',
					playerVars: {
									wmode: "opaque"
							},
					events: {
						'onReady': function () {
							_[[hash]]_player.cueVideoById('[[ythash]]');
						},
						'onStateChange': function (event) {
							switch (event.data) {
								case 0:
								case 2:
								case 5:
									disableDjif('[[hash]]');
								break;
								case 1:
									enableDjif('[[hash]]');
								break;
							}
						}
					}
			});
			}
		} 
		
		function onYouTubeIframeAPIReady() {load_[[hash]]_audio([[directload]])};
	
		function _[[hash]]_speaker_play() {
			if( $('#_[[hash]]_djif').attr('data-hasplayed') == 'true') {
				_[[hash]]_player.playVideo();
			} else {
				$('#_[[hash]]_djif').attr('data-hasplayed', 'true');
			}
			_[[hash]]_player.seekTo('[[start]]');
		}

		function _[[hash]]_speaker_stop() {
			_[[hash]]_player.stopVideo();
		}
