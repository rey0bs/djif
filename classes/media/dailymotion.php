<?php

require_once( 'classes/media.php' );

class Dailymotion extends Media {
	
	function __construct($url) {
		parent::__construct($url);
		$this->valid = true;
	}

	public static function isMine( $url ) {
		return preg_match("#^https?://(.*\.)?dailymotion(\.|/)#i", $url);
	}
	public function getHash( ) {
		//return preg_replace( '#.*(v=|youtu.be/)([^&\?]+)&?.*#', '$2', $this->url );
	}
}
?>
