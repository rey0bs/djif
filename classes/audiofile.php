<?php

require_once( 'media.php' );

class Audiofile extends Media {

	public function getFormat() {
		$extension = substr(strchr($this->url, '.'),1);
		if ($extension = 'mp3') {
			return "mpeg";
		}
		return $extension;
	}

	public function getPlaceHolders() {
		return array(
			'keys' => array('[[ url ]]', '[[ format ]]'),
			'values' => array($this->url, $this->getFormat())
		);
	}
}
?>
