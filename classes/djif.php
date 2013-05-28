<?php

class Djif {
	
	var $gif;
	var $audio;
	var $preview;
	var $hash;
	var $db;
	var $valid = false;

	function __construct($param1, $param2=NULL ) {
		if (! $param2 ) {
		// One argument : either a simple hash to retrieve the djif in DB or a full assoc freshly extracted from said DB
			if (is_array($param1)) {
			// from assoc array
				$row = $param1;
				$this->hash = $row["hash"];
			} else {
			// from hash
				$this->db =  new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
				if ($this->db->connect_errno) {
					die ("Could not connect db " . DB_NAME . "\n" . $link->connect_error);
				}
				$hash = $this->db->real_escape_string(substr($param1,0,5));
				$result = $this->db->query("SELECT gif, audio, preview FROM urls WHERE hash = '$hash'");
				$row = $result->fetch_assoc();
				if( empty($row) ) {
					return null;
				} else {
					$this->db->query("UPDATE urls SET visits = visits + 1 WHERE hash = '$hash'");
					$this->hash = $hash;
				}
			}
			$gif = new Media( $row["gif"] );
			$audio = new Media( $row["audio"] );
			$this->preview = $row["preview"];
		} else {
		// from two urls
			$this->db =  new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
			if ($this->db->connect_errno) {
				die ("Could not connect db " . DB_NAME . "\n" . $link->connect_error);
			}
			$gif = new Media( $param1 );
			$audio = new Media( $param2 );
			$charset = array_merge(range(0,9), range('a','z'), range('A', 'Z'));
			$hash = '';
			for ($i=0; $i < 5; $i++) {
				$hash .= $charset[array_rand($charset)];
			}
			$this->hash = $hash;
		}
		$this->gif = $gif->getMedia('gif');
		$this->audio = $audio->getMedia('audio');
		if ($this->gif && $this->audio) {
			$this->valid = $this->gif->isValid() && $this->audio->isValid();
			if ($this->valid) { // if we're gonna spend some time computing a preview, at least we don't do it before we're sure the djif is valid
				if(! $this->preview) {
					$img = imagecreatefromgif($this->gif->getUrl());
					ob_start();
					imagejpeg($img);
					$this->preview = ob_get_contents();
					ob_end_clean();
				}
			}
		}
	}


	public function isValid() {
		return $this->valid;
	}

	public function getPlaceholders() {
		
		if ( count($this->gif->size) ) {
			$width = $this->gif->size[0];
		}
		$parameters = array( '[[width]]' => ($width?$width:'500'), '[[hash]]' => $this->hash );
		return array(
			'[[hash]]' => $this->hash,
			'[[gif]]' => $this->gif->render('display', $parameters),
			'[[audio]]' => $this->audio->render('display', $parameters),
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
		$insert = "INSERT INTO urls(hash, gif, audio, ip, preview) VALUES ('$this->hash', '";
		$insert .= $this->db->real_escape_string($this->gif->getUrl()) . "', '";
		$insert .= $this->db->real_escape_string($this->audio->getUrl()) . "', '";
		$insert .= ip2long ($this->db->real_escape_string($_SERVER['REMOTE_ADDR'])) . "', '";
		$insert .= $this->db->real_escape_string($this->preview) . "')";
		if(! $this->db) {
			die('Lost connection to database !');
		}
		$result = $this->db->query($insert);
		$url = 'http://' . $_SERVER['SERVER_NAME'] . '/' . $this->hash;
		return str_replace( array('[[url]]'), array($url), file_get_contents ('templates/link.html') );
	}

}
?>
