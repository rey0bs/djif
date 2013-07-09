<?php
class Media {
	
	var $id;
	var $url;
	var $type;
	var $valid = false;
	var $size;

	function __construct($url=null, $size=null) {
		$this->url = $url;
		$this->id = md5($url);
		$this->type = lcfirst(get_class($this));
		if($size) {
			$this->size = $size;
		} else {
			$this->size = array(300,300);
		}
	}
	
	public static function get($url, $type=null, $size=null) {
		if(! $type) {
			if(preg_match("#^https?://.*\.(mp3|ogg|wav|gif)(\?[^=]+=[^%]*(&[^=]+=[^%]*)*)?$#", $url)) {
		    $type = preg_replace("#^https?://.*/(.*)\.(mp3|ogg|wav|gif)(\?[^=]+=[^%]*(&[^=]+=[^%]*)*)?$#", "$2", $url);
			} else if (preg_match("#^https?://([^/]*\.)?youtu\.?be(\.|/)#i", $url)) {
				$type = 'youtube';
			} else {
				return new Media();
			}
		}
		$path = "classes/media/$type.php";
		if(file_exists($path)) {
			require_once $path;
			$filename = explode("/", $path);
			$filename = $filename[count($filename)-1];

			$t = explode(".", $filename);
			$class = ucfirst($t[count($t)-2]);

			return new $class($url, $size);
		} else {
			die("Missing class file $path");
		}

	}

	public function getHash() {
	}

	public function getUrl() {
		return $this->url;
	}

	public function getId() {
		return $this->id;
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
	
	public function getTemplate($mode) {
		$fileName = $this->getTemplateDir() . strtolower( get_class($this) ) . '-' . $mode . '.tpl';
		if( file_exists($fileName) ) {
			return file_get_contents( $fileName );
		} else {
			return false;
		}
	}

	public function store($dao) {
		$type = $dao->getMediaType($this->type);
		$dao->storeMedia($this->id, $type, $this->url, $this->size[0], $this->size[1]);
		return $this->id;
	}

	public function render( $mode, $placeholders=array() ) {
		$placeholders = array_merge( (array)$this->getPlaceholders(), (array)$placeholders );
		$securePH = array();
		foreach($placeholders as $key => $value) {
			$securePH["$key"] = htmlspecialchars($value);
		}
		return replacePlaceHolders($this->getTemplate($mode), $securePH);
	}
	
}
?>
