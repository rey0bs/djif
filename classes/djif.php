<?php

class Djif {
	
	var $gif;
	var $audio;
	var $db;
	var $valid = false;

	function __construct($param1, $param2=NULL ) {
		$this->db =  new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
		if ($this->db->connect_errno) {
			die ("Could not connect db " . DB_NAME . "\n" . $link->connect_error);
		}
		if (! $param2 ) {
		// from hash
			$hash = $this->db->real_escape_string(substr($param1,0,5));
			$result = $this->db->query("SELECT gif, audio FROM urls WHERE hash = '$hash'");
			$row = $result->fetch_assoc();
			if( empty($row) ) {
				return null;
			} else {
				$result->free();
				$gif = new Media( $row["gif"] );
				$audio = new Media( $row["audio"] );
			}
		} else {
		// from two urls
			$gif = new Media( $param1 );
			$audio = new Media( $param2 );
		}
		$this->gif = $gif->getMedia();
		$this->audio = $audio->getMedia();
		if ($this->gif && $this->audio) {
			$this->valid = $this->gif->isValid() && $this->sound->isValid();
		}
	}


	public function isValid() {
		return $this->valid;
	}

	public function getPlaceholders() {
		
		if ( count($this->gif->size) ) {
			$width = $this->gif->size[0];
		}
		return array(
			'[[gif]]' => $this->gif->render(),
			'[[audio]]' => $this->audio->render( array( '[[width]]' => ($width?$width:'500') ) ),
			'[[size]]' => ($width?' style="width: '.$width.';"':'')
		);
	}
	
	
	public function getTemplate() {
		$fileName = 'templates/djif.html';
		if( file_exists( $fileName ) ) {
			return file_get_contents( $fileName );
		} else {
			return false;
		}
	}

	public function render() {
		
		$placeholders = $this->getPlaceholders();
		$output = $this->getTemplate();
		foreach ($placeholders as $key => $value) {
			$output = str_replace($key , $value , $output );
		}
		return $output;
	}

	public function store() {
		$charset = array_merge(range(0,9), range('a','z'), range('A', 'Z'));
		$hash = '';
		for ($i=0; $i < 5; $i++) {
			$hash .= $charset[array_rand($charset)];
		}
		$insert = "INSERT INTO urls(hash, gif, audio, ip) VALUES ('$hash', '";
		$insert .= $this->db->real_escape_string($this->gif->getUrl()) . "', '";
		$insert .= $this->db->real_escape_string($this->audio->getUrl()) . "', '";
		$insert .= ip2long ($this->db->real_escape_string($_SERVER['REMOTE_ADDR'])) . "')";
		if(! $this->db) {
			die('Lost connection to database !');
		}
		$result = $this->db->query($insert);
		$url = 'http://' . $_SERVER['SERVER_NAME'] . '/' . $hash;
		return str_replace( array('[[url]]'), array($url), file_get_contents ('templates/link.html') );
	}

}
?>
