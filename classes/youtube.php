<?php

require_once( 'media.php' );

class Youtube extends Media {

	public function getHash( ) {
		return preg_replace( '#.*(v=|youtu.be/)([^&\?]+)&?.*#', '$2', $this->url );
	}
}
?>
