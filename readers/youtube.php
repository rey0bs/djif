<?php
class Youtube {
	var $hash;

	function __construct($url) {
		$this->hash = substr($url,16);
	}

	public function render() {
	}
}
?>
