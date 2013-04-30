function showAudio() {
	$('div#speaker').css('height', '0').css('visibility', 'visible').animate({height: '200px'});
	$('a#show_audio').hide();
	$('a#hide_audio').show();
}

function hideAudio() {
	$('div#speaker').animate({height: '0'}).css('visibility', 'hidden');
	$('a#hide_audio').hide();
	$('a#show_audio').show();
}

$(function(){
	
	$('form#new_djif').submit(function() {
		$('#screen').remove();
		$('#speaker').remove();
		$.ajax({
			type: "POST",
			url: "/new",
			data: { gif_url: $('#gifSource').val(),
					audio_url: $('#soundSource').val(),
					ajax : true	}
		}).done(function( output ) {
			$('#action').append( output );
			$('form#new_djif').fadeOut(200, function() {
			$('#tinyurl').fadeIn(200);
			$('#screen').fadeIn(200);
			$('#speaker').fadeIn(200);
			$("#tinyurl input").select();
			});
		});
		return false;
	});
	
	/*$('form#new_djif input').change(function(){
		alert('toto'+$(this).attr('value'));
	});*/
	
});
