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
	
	public function resolve($url) {
		$headers = @get_headers($url);
		if(preg_match("#^HTTP/[0-9]\.[0-9] *([0-9]+).*$#i", $headers[0], $code)) {
			switch ($code[1]) {
				case 200: // OK
					return $url;
				case 404: // NOT FOUND
					return false;
				case 302: // Moved
				case 303:
					foreach($headers as $line) {
						if(preg_match("#^Location *: *(http.*)$#i", $line, $location)) {
							$new_url = $location[1];
							break;
						}
					}
					if ($new_url) {
						return $this->resolve($new_url);
					} else {
						return false;
					}
				default:
					error_log("New HTTP return code to handle : $code[1] encountered at '$url'");
					return false;
			}
		} else {
			return false;
		}
	}

	public function getMedia() {
	
		$url = $this->resolve($this->url);
		if ($url) {
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
		}
		return false;
	}
}
?>
