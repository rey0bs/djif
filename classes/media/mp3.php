<?php

require_once( 'classes/media.php' );

class Mp3 extends Media {

	function __construct($url) {
		parent::__construct($url);
		$this->valid = true;
	}

	public function getTitle() {
		$file_name = preg_replace("#^https?://.*/([^?=]*)\.mp3(\?[^=]+=[^%]*(&[^=]+=[^%]*)*)?$#", "$1", $this->url);
		return urldecode($file_name);
	}

	public function getFormat() {
		return 'mpeg';
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
