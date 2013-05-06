<?php
class Media {
	
	var $url;
	var $valid = false;

	function __construct($url) {
		$this->url = $url;
	}
	
	public static function isMine( $url ) {
		return false;
	}
	public function getHash() {
	}
	
	public function getUrl() {
		return $this->url;
	}

	public function isValid() {
		return $this->valid;
	}

	public function getPlaceholders() {
		return array(
			'[[hash]]' => $this->getHash()
		);
	}
	
	public function getTemplateDir() {
		return 'templates/media/';
	}
	
	public function getTemplate() {
		$fileName = $this->getTemplateDir() . strtolower( get_class($this) ) . '.html';
		if( file_exists($fileName) ) {
			return file_get_contents( $fileName );
		} else {
			return false;
		}
	}

	public function render( $placeholders=array() ) {
		$placeholders = array_merge( (array)$this->getPlaceholders(), (array)$placeholders );
		$output = $this->getTemplate();
		foreach ($placeholders as $key => $value) {
			$output = str_replace($key , htmlspecialchars($value) , $output );
		}
		return $output;
	}
	
	public function getMedia() {
		// load classes
		foreach (glob("classes/media/*.php") as $path) {

			require_once $path;
			$filename = explode("/", $path);
			$filename = $filename[count($filename)-1];

			$t = explode(".", $filename);
			$class = ucfirst($t[count($t)-2]);

			if ($class::isMine($this->url)) {
				return new $class($this->url);
			}
		}
		return $this;
	}
}
?>
