<?php

require_once( 'classes/media.php' );

class Gif extends Media {
	var $size;

	function __construct($url, $size=null) {
		parent::__construct($url);
		if ($size) {
			$this->size = $size;
		} else {
			$this->size = getimagesize($url);
		}
		if($this->size > 0) {
			$this->valid = true;
		}
	}

	public function getPlaceHolders() {
		return array(
			'[[url]]' => $this->url,
			'[[width]]' => $this->size[0],
			'[[height]]' => $this->size[1]
		);
	}

}
?>

