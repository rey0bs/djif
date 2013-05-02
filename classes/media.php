<?php
class Media {
	
	var $url;

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

	public function getPlaceholders() {
		return array(
				'keys' => array(
						'[[hash]]'
				),
				'values' => array(
						$this->getHash()
				)
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

	public function render( ) {
		$placeholders = $this->getPlaceholders();
		return str_replace($placeholders['keys'] , $placeholders['values'] , $this->getTemplate() );
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
	
		return false;
	}
}
?>
