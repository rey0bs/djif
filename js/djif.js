/*function showAudio() {
	$('div#speaker').css('height', '0').css('visibility', 'visible').animate({height: '200px'});
	$('a#show_audio').hide();
	$('a#hide_audio').show();
}

function hideAudio() {
	$('div#speaker').animate({height: '0'}).css('visibility', 'hidden');
	$('a#hide_audio').hide();
	$('a#show_audio').show();
}*/

var triggered = 0;
function initTrigger() {
	triggered = 0;
}
function setTrigger() {
	triggered++;
}
function getTrigger() {
	return triggered;
}

function setPreview(input, html) {

	if (input.parent().find('.preview').length) {
		input.parent().find('.preview').html(html);
	} else {
		/*if (input.parent().hasClass('sound_group')) {
			input.parent().append( '<div class="preview">'+html+'</div>' );
		} else {
			input.animate({width: "-=60px"}, 0, 'linear', function(){
				input.parent().append( '<div class="preview">'+html+'</div>' );
			});
		}*/
		input.animate({width: "-=60px"}, 0, 'linear', function(){
			input.parent().append( '<div class="preview">'+html+'</div>' );
		});
	}
}

$(function(){
	
	$('form#new_djif').submit(function() {
		var gif = $('#gifSource').val();
		var sound = $('#soundSource').val();
		if (gif == '' || sound == '') {
			$('#tooltip').fadeIn(100);
			return false;
		} else {
			$('#screen').remove();
			$('#speaker').remove();
			$.ajax({
				type: "POST",
				url: "/ajax/new",
				data: { gif_url: $('#gifSource').val(),
						audio_url: $('#soundSource').val(),
						ajax : true	}
			}).done(function( output ) {
				$('#action').append( output );
				$('#tinyurl').hide(0);
				$('#screen').hide(0);
				$('#speaker').hide(0);
				$('.preview').remove();
				$('form#new_djif').fadeOut(200, function() {
				$('form#new_djif').remove();
				$('#tinyurl').fadeIn(200);
				$('#screen').fadeIn(200);
				$('#speaker').fadeIn(200);
				$("#tinyurl input").select();
				});
			});
			return false;
		}
	});
	
	$('form#new_djif input').each(function(i,elt) {

		var element = $(elt);
		element.data('val',  element.val() ); // save value
		element.change(function() { // works when input will be blured and the value was changed
	        if( element.val() != element.data('val') ){ // check if value changed
	        	element.data('val',  element.val() ); // save new value
	        	preview(element);
	        }
	    });
		element.keyup(function() { // works immediately when user press button inside of the input
	        if( element.val() != element.data('val') ){ // check if value changed
	        	element.data('val',  element.val() ); // save new value
	        	preview(element);
	        }
	    });
	});
	
	function preview(input) {
		if (input.val()) {
			if (!getTrigger()) {
				setTrigger();
				if (input.parent().hasClass('sound_group')) {
					var loader = '<img src="/images/loader_blue.gif" />';
					var component = 'audio';
				} else {
					var loader = '<img src="/images/loader_orange.gif" />';
					var component = 'gif';
				}
				setPreview( input, loader);
				$.ajax({
					type: "POST",
					url: "/ajax/media",
					data: { url: input.val(),
							component: component,
							width: 50,
							height: 50,
							ajax : true	}
				}).done(function( output ) {
					setPreview( input, output);
				});
			}
			initTrigger();
		} else {
			input.removeAttr('style');
			input.parent().find('.preview').remove();
		}
	}
	
});

$('#remix').mouseleave(function() {
	$('#tooltip').fadeOut(200);
});
