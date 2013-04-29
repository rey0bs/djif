<?php

require_once( 'classes/media.php' );

class Audiofile extends Media {

	public static function isMine($url) {
		return preg_match("#\.(mp3|ogg)$#", $url);
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
			'keys' => array('[[url]]', '[[format]]'),
			'values' => array($this->url, $this->getFormat())
		);
	}
}
?>
