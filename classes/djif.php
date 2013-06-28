<?php

require_once 'twitteroauth/twitteroauth/twitteroauth.php'; // inclure la librairie (qui elle-même appelera OAuth.php)

class Djif {
	
	var $gif;
	var $audio;
	var $preview;
	var $hash;
	var $url;
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

	public function fromAssoc($row) {
		$instance = new self();
		$instance->hash = $row["hash"];
		$instance->url = 'http://' . $_SERVER['SERVER_NAME'] . '/' . $instance->hash;
		$gif = new Media( $row["gif"], $row["gifType"] );
		$audio = new Media( $row["audio"], $row["audioType"]);
		$size = array($row["width"], $row["height"]);
		$instance->gif = $gif->getMedia('gif', $size);
		$instance->audio = $audio->getMedia('audio');
		$instance->validate();
		return $instance;
	}

	public function fromUrls($gif_url, $audio_url) {
		$instance = new self();
		$gif = new Media( $gif_url );
		$audio = new Media( $audio_url );
		$instance->hash = createHash();
		$instance->url = 'http://' . $_SERVER['SERVER_NAME'] . '/' . $instance->hash;
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
			$height = $this->gif->size[1]+31;
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
			'[[size]]' => 'style="' . ($width?' width: '.$width.'px;':'') . ($height?' height: '.$height.'px;':'') . '"',
			'[[width]]' => ($width?' width="'.$width.'"':''),
			'[[height]]' => ($height?' height="'.$height.'"':''),
			'[[url]]' => $this->url,
			'[[encoded_url]]' => rawurlencode($this->url),
			'[[sharetitle]]' => rawurlencode('Hey ! Check this out '),
			'[[sharetext]]' => rawurlencode('This djif mixes an animated gif and an audio from youtube or audio file.'),
			'[[shareimg]]' => rawurlencode($this->url.'.jpg'),
			'[[ajax]]' => 0,
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

	public function render( $placeholders=array() ) {
		$placeholders = array_merge( (array)$this->getPlaceholders(), (array)$placeholders );
		return replacePlaceHolders($this->getTemplate(), $placeholders);
	}

	public function store($dao) {
		
		$twConnect = new TwitterOAuth(
				CONSUMER_KEY,
				CONSUMER_SECRET,
				ACCESS_TOKEN,
				ACCESS_TOKEN_SECRET
		);

		$twConnect->host = "https://api.twitter.com/1.1/";
		$twConnect->get('account/verify_credentials');
		$twConnect->post('statuses/update', array(
				'status' => 'A new djif was created ! '.$this->url
		));
		
		
		$gif_id = $this->gif->store($dao);
		$audio_id = $this->audio->store($dao);
		$dao->storeDjif($this->hash, $gif_id, $audio_id, $this->preview);
		$placeholders = array('[[url]]' => $this->url);
		return replacePlaceHolders(file_get_contents('templates/link.html'), $placeholders);
	}

}
?>
