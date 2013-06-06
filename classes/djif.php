<?php

class Djif {
	
	var $gif;
	var $audio;
	var $preview;
	var $hash;
	var $db;
	var $directload = 'true';
	var $valid = false;

	private function buildPreview() {
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

	public function fromAssoc($row, $instance=null) {
		if (! $instance) {
			$instance = new self();
		}
		if($row["hash"]) {
			$instance->hash = $row["hash"];
		} else {
			$instance->directload = 'false'; // If we don't know the hash, we're building a djif from the entire row, so there are many djifs on the page and we need to delay loading
		}
		$gif = new Media( $row["gif"], $row["gifType"] );
		$audio = new Media( $row["audio"], $row["audioType"]);
		$size = array($row["width"], $row["height"]);
		$instance->gif = $gif->getMedia('gif', $size);
		$instance->audio = $audio->getMedia('audio');
		$instance->validate();
		return $instance;
	}

	public function fromHash($requiredHash) {
		$instance = new self();
		$instance->db = accessDB();
		$hash = $instance->db->real_escape_string(substr($requiredHash,0,5));
		$select = "
			SELECT
			gif.url AS gif,
			gif.type AS gifType,
			audio.url AS audio,
			audio.type AS audioType,
			gif.width, gif.height
			FROM djifs, media AS gif, media AS audio
			WHERE hash = '$hash' AND djifs.gif = gif.id AND djifs.audio = audio.id";
		$result = $instance->db->query($select);
		$row = $result->fetch_assoc();
		if( empty($row) ) {
			return $instance;
		} else {
			$instance->db->query("UPDATE djifs SET visits = visits + 1 WHERE hash = '$hash'");
			$instance->hash = $hash;
			return self::fromAssoc($row, $instance);
		}
	}

	public function fromUrls($gif_url, $audio_url) {
		$instance = new self();
		$instance->db = accessDB();
		$gif = new Media( $gif_url );
		$audio = new Media( $audio_url );
		$instance->hash = createHash();
		$instance->gif = $gif->getMedia('gif');
		$instance->audio = $audio->getMedia('audio');
		$instance->validate();
		if ($instance->valid) { // if we're gonna spend some time computing a preview, at least we don't do it before we're sure the djif is valid
			$instance->buildPreview();
		}
		return $instance;
	}

	public function isValid() {
		return $this->valid;
	}

	public function getPlaceholders() {
		
		if ( count($this->gif->size) ) {
			$width = $this->gif->size[0];
			$height = $this->gif->size[1]+36;
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
			'[[size]]' => ($width?' style="width: '.$width.';"':''),
			'[[width]]' => ($width?' width="'.$width.'"':''),
			'[[height]]' => ($height?' height="'.$height.'"':''),
			'[[url]]' => rawurlencode('http://djif.net/'.$this->hash),
			'[[sharetitle]]' => rawurlencode('Hey ! Check this out '),
			'[[sharetext]]' => rawurlencode('This djif mixes an animated gif and an audio from youtube or audio file.'),
			'[[shareimg]]' => rawurlencode('http://djif.net/'.$this->hash.'.jpg'),
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
		return render($this->getTemplate(), $this->getPlaceholders());
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
