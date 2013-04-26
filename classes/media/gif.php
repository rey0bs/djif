<?php

require_once( 'classes/media.php' );

class Gif extends Media {

	public static function isMine($url) {
		return preg_match("#\.gif$#", $url);
	}

	public function getPlaceHolders() {
		return array(
			'keys' => array('[[ url ]]'),
			'values' => array($this->url)
		);
	}
}
?>

