<?php

class Djif {
	
	var $gif;
	var $audio;
	var $preview;
	var $hash;
	var $db;
	var $directload = 'true';
	var $valid = false;

	public function createHash() {
		$charset = array_merge(range(0,9), range('a','z'), range('A', 'Z'));
		$hash = '';
		for ($i=0; $i < 5; $i++) {
			$hash .= $charset[array_rand($charset)];
		}
		return $hash;
	}

	public function initDB() {
		$this->db =  new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
		if ($this->db->connect_errno) {
			die ("Could not connect db " . DB_NAME . "\n" . $link->connect_error);
		}
	}

	private function createPreview() {
		$img = imagecreatefromgif($this->gif->getUrl());
		ob_start();
		imagejpeg($img);
		$this->preview = ob_get_contents();
		ob_end_clean();
	}

	private function validate() {
		if ($this->gif && $this->audio) {
			$this->valid = $this->gif->isValid() && $this->audio->isValid();
		}
	}

	private function fromHash() {
		initDB();
		$hash = $this->db->real_escape_string(substr($param1,0,5));
		$select = "
			SELECT
			gif.url AS gif,
			gif.type AS gifType,
			audio.url AS audio,
			audio.type AS audioType,
			gif.width, gif.height
			FROM djifs, media AS gif, media AS audio
			WHERE hash = '$hash' AND djifs.gif = gif.id AND djifs.audio = audio.id";
		$result = $this->db->query($select);
		$row = $result->fetch_assoc();
		if( empty($row) ) {
			return null;
		} else {
			$this->db->query("UPDATE djifs SET visits = visits + 1 WHERE hash = '$hash'");
			$this->hash = $hash;
		}
		$gif = new Media( $row["gif"], $row["gifType"] );
		$audio = new Media( $row["audio"], $row["audioType"]);
		$size = array($row["width"], $row["height"]);
		$this->gif = $gif->getMedia('gif', $size);
		$this->audio = $audio->getMedia('audio');
		validate();
	}

	private function fromAssoc($row) {
		$this->hash = $row["hash"];
		$this->directload = 'false'; // loading from an array means we're displaying several djifs so we don't want them to load immediately
		$gif = new Media( $row["gif"], $row["gifType"] );
		$audio = new Media( $row["audio"], $row["audioType"]);
		$size = array($row["width"], $row["height"]);
		$this->gif = $gif->getMedia('gif', $size);
		$this->audio = $audio->getMedia('audio');
		validate();
	}

	private function fromUrls($gif_url, $audio_url) {
		initDB();
		$gif = new Media( $gif_url );
		$audio = new Media( $audio_url );
		$this->hash = createHash();
		$this->gif = $gif->getMedia('gif', $size);
		$this->audio = $audio->getMedia('audio');
		validate();
		if ($this->valid) { // if we're gonna spend some time computing a preview, at least we don't do it before we're sure the djif is valid
			$this->preview = createPreview();
		}
	}

	function __construct($param1, $param2=NULL ) {
		$size = null;
		if (! $param2 ) {
		// One argument : either a simple hash to retrieve the djif in DB or a full assoc freshly extracted from said DB
			var $row;
			if (is_array($param1)) {
				$row = fromAssoc($param1);
			} else {
				$row = fromHash();
			}
		} else {
			fromUrls($param1, $param2);
		}
	}

	public function isValid() {
		return $this->valid;
	}

	public function getPlaceholders() {
		
		if ( count($this->gif->size) ) {
			$width = $this->gif->size[0];
		}
		$parameters = array(
		 	'[[width]]' => ($width?$width:'300'),
		 	'[[hash]]' => $this->hash,
			'[[directload]]' => $this->directload
		);
		return array(
			'[[hash]]' => $this->hash,
			'[[directload]]' => $this->directload,
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
		$gif_id = $this->gif->store($this->db);
		$audio_id = $this->audio->store($this->db);
		$insert = "INSERT INTO djifs(hash, gif, audio, ip, preview) VALUES ('$this->hash', '";
		$insert .= $gif_id . "', '";
		$insert .= $audio_id . "', '";
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
