<?php
class Djif {
	
	var $gif;
	var $audio;
	
	function __construct( $gif_url, $audio_url ) {
		$this->gif = $this->getMedia( $gif_url );
		$this->audio = $this->getMedia( $audio_url );
	}
	
	public static function getMedia( $url ) {

		// load classes
		foreach (glob("classes/media/*.php") as $path) {
			
			require_once $path;
			$filename = explode("/", $path);
			$filename = $filename[count($filename)-1];
			
			$t = explode(".", $filename);
			$class = ucfirst($t[count($t)-2]);
			
			if ($class::isMine($url)) {
				return new $class($url);
			}
		}
		
		return false;
	}

	public function getPlaceholders() {
		return array(
				'keys' => array(
						'[[gif]]',
						'[[audio]]'
				),
				'values' => array(
						$this->gif->render(),
						$this->audio->render(),
				)
		);
	}
	
	
	public function getTemplate() {
		$fileName = 'templates/view.php';
		if( file_exists( $fileName ) ) {
			return file_get_contents( $fileName );
		} else {
			return false;
		}
	}
	
	public function render() {
		$placeholders = $this->getPlaceholders();
		return str_replace( $placeholders['keys'] , $placeholders['values'] , $this->getTemplate() );
	}
}
?>