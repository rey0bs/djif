<?php

require_once( 'classes/media.php' );

class Ogg extends Media {

	function __construct($url) {
		parent::__construct($url);
		$this->valid = true;
	}

	public function getTitle() {
		$file_name = preg_replace("#^https?://.*/([^?=]*)\.ogg(\?[^=]+=[^%]*(&[^=]+=[^%]*)*)?$#", "$1", $this->url);
		return urldecode($file_name);
	}

	public function getFormat() {
		return 'ogg';
	}

	public function getPlaceHolders() {
		return array(
			'[[url]]' => $this->url,
			'[[format]]' => $this->getFormat(),
			'[[width]]' => 300
		);
	}

}
?>
