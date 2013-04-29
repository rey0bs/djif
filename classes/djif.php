<?php
class Djif {
	
	var $url;
	
	function __construct($url) {
		$this->url = $url;
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