<iframe id="_[[hash]]_speaker" width="[[width]]" height="300" src="http://www.youtube.com/embed/[[ythash]]?autohide=0&loop=1&playlist=[[hash]][[start]]&wmode=opaque"></iframe>

<script>
	/*audio_load['[[hash]]'] = function() {
		insert_youtube ('[[hash]]', '[[ythash]]', '[[width]]', 0);
	}
	audio_play['[[hash]]'] = function() {
		if( $('#_[[hash]]_djif').attr('data-hasplayed') == 'true') {
			players['[[hash]]'].playVideo();
		} else {
			$('#_[[hash]]_djif').attr('data-hasplayed', 'true');
		}
		players['[[hash]]'].seekTo('[[start]]');
	}
	audio_stop['[[hash]]'] = function() {
		players['[[hash]]'].stopVideo();
	}*/
	audio_load['[[hash]]'] = function() {
		/*players['[[hash]]'] = new YT.Player('_[[hash]]_speaker', {
		    events: {
		      'onReady': function(event) {  },
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
		  });*/
	}
	audio_play['[[hash]]'] = function() {
		if( $('#_[[hash]]_djif').attr('data-hasplayed') == 'true') {
			players['[[hash]]'].playVideo();
		} else {
			$('#_[[hash]]_djif').attr('data-hasplayed', 'true');
		}
		players['[[hash]]'].seekTo('[[start]]');
	}
	audio_stop['[[hash]]'] = function() {
		players['[[hash]]'].stopVideo();
	}
</script>
