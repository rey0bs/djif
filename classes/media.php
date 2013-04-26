<?php
class Media {
	
	var $url;

	function __construct($url) {
		$this->url = $url;
	}
	
	public function getTemplateDir() {
		return 'templates/media/';
	}
	
	public function getTemplate() {
		$fileName = $this->getTemplateDir() . strtolower( get_class($this) ) . '.php';
		if( file_exists($fileName) ) {
			return file_get_contents( $fileName );
		} else {
			return false;
		}
	}
	
	public function getHash() {
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

	public function render( ) {
		$placeholders = $this->getPlaceholders();
		return str_replace($placeholders['keys'] , $placeholders['values'] , $this->getTemplate() );
	}
}
?>