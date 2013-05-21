<?php

require_once( 'classes/media.php' );

class Audiofile extends Media {

	function __construct($url) {
		parent::__construct($url);
		$this->valid = true;
	}

	public static function isMine($url) {
		return preg_match("#^https?://.*\.(mp3|ogg|wav)(\?[^=]+=[^%]*(&[^=]+=[^%]*)*)?$#", $url);
	}

	public function getFormat() {
		preg_match("#\.([^.]+)$#", $this->url, $format);
		$extension = substr($format[0], 1);
		if ($extension == 'mp3') {
			return "mpeg";
		}
		return $extension;
	}

	public function getPlaceHolders() {
		return array(
			'[[url]]' => $this->url,
			'[[format]]' => $this->getFormat(),
			'[[width]]' => 500
		);
	}
}
?>
