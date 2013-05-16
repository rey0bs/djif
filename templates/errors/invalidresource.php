<?php
	$id = rand(5, 1000);
?>
<img id="<?php echo $id; ?>" src="/images/dead.png" alt="no resource found at that location" />
<script>
$('.preview > img#<?php echo $id; ?>').animate(
	    {  borderSpacing: -90 }, 
	    {
	        step: function(now,fx) {
	            $(this).css('-webkit-transform','rotate('+now+'deg)');
	            $(this).css('-moz-transform','rotate('+now+'deg)'); 
	            $(this).css('-ms-transform','rotate('+now+'deg)');
	            $(this).css('-o-transform','rotate('+now+'deg)');
	            $(this).css('transform','rotate('+now+'deg)');  
	        },
	    duration:1200,
	    easing: 'easeOutBounce'
	    }
	);
</script>
