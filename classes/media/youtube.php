<?php

require_once( 'classes/media.php' );

class Youtube extends Media {

	function __construct($url) {
		parent::__construct($url);
		$this->valid = true;
	}

	public static function isMine( $url ) {
		return preg_match("#^https?://(.*\.)?youtu\.?be(\.|/)#i", $url);
	}

	public function getHash( ) {
		return preg_replace( '#.*(v=|youtu.be/)([^&\?\#]+)&?.*#', '$2', $this->url );
	}
	
	public function getTitle() {
		$hash = $this->getHash();
		$json = json_decode(file_get_contents("http://gdata.youtube.com/feeds/api/videos/$hash?alt=json"), true);
		return $json["entry"]["title"]["\$t"];
	}

	public function getPlaceholders() {
		return array(
			'[[ythash]]' => $this->getHash(),
			'[[start]]' => $this->getStart(),
			'[[width]]' => 300
		);
	}
	
	public function getStart() {
		$time = $this->getTime();
		if ($time) {
			return $time;
		} else {
			return '0';
		}
		
	}
	public function getTime() {
		
		$url = str_replace('&amp;', '&', $this->url);
		$time = preg_replace( '/.*(&|\?|#)t=([0-9m]*)s?.*/', '$2', $url );
	
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
