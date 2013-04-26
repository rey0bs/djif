<?php
class Youtube {
	var $hash;

	function __construct($url) {
		$this->hash = substr($url,16);
	}

	public function render() {
?>
	<iframe width="1" height="1" src="http://www.youtube.com/embed/<?php echo($this->hash); ?>?autoplay=1" frameborder="0" allowfullscreen></iframe>
<?php
	}
}
?>
