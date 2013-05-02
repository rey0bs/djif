<?php

require_once( 'classes/media.php' );

class Youtube extends Media {

	public static function isMine( $url ) {
		return preg_match("#(\.|/)youtu\.?be(\.|/)#i", $url);
	}
	
	public function getHash( ) {
		return preg_replace( '#.*(v=|youtu.be/)([^&\?]+)&?.*#', '$2', $this->url );
	}
	
	public function getPlaceholders() {
		return array(
				'keys' => array(
						'[[hash]]',
						'[[start]]'
				),
				'values' => array(
						$this->getHash(),
						$this->getStart()
				)
		);
	}
	
	public function getStart() {
		$time = $this->getTime();
		if ($time) {
			return '&start='.$time;
		} else {
			return '';
		}
		
	}
	public function getTime() {
	
		$time = preg_replace( '/.*(&|\?|#)t=([0-9m]*)s?.*/', '$2', $this->url );
	
		$time = explode('m', $time);
		if (count($time)>1) {
			$time = $time[0]*60+$time[1];
		} else {
			$time = $time[0];
		}
		return $time;
	}
}
?>
