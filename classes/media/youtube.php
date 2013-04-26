<?php

require_once( 'classes/media.php' );

class Youtube extends Media {

	public static function isMine( $url ) {
		return preg_match("#(\.|/)youtu\.?be(\.|/)#i", $url);
	}

	public function getHash( ) {
		return preg_replace( '#.*(v=|youtu.be/)([^&\?]+)&?.*#', '$2', $this->url );
	}
}
?>
