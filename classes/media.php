<?php
include 'config/types.php';

class Media {
	
	var $id;
	var $url;
	var $type;
	var $valid = false;

	function __construct($url, $type=null) {
		$this->url = $url;
		if($type) {
			$this->type = $type;
		} else {
			$this->type = strtolower (get_class($this));
		}
		$this->id = crc32($url);
	}
	
	public static function isMine( $url ) {
		return false;
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

	public function store($db) {
		$insert = "INSERT INTO media(id, type, url, width, height) VALUES ('$this->id', ";
		$insert .= $types[$this->type] . ", '";
		$insert .= $db->real_escape_string($this->getUrl()) . "', '";
		$insert .= $this->size[0] . "', '" . $this->size[1] . "')";
		$result = $db->query($insert);
	}

	public function render( $mode, $placeholders=array() ) {
		$placeholders = array_merge( (array)$this->getPlaceholders(), (array)$placeholders );
		$output = $this->getTemplate($mode);
		foreach ($placeholders as $key => $value) {
			$output = str_replace($key , htmlspecialchars($value) , $output );
		}
		return $output;
	}
	
	public function getMedia( $type, $size=NULL ) {
		// load classes
		foreach (glob("classes/$type/*.php") as $path) {

			require_once $path;
			$filename = explode("/", $path);
			$filename = $filename[count($filename)-1];

			$t = explode(".", $filename);
			$class = ucfirst($t[count($t)-2]);

			if ($class::isMine($this->url)) {
				return new $class($this->url, $size);
			}
		}
		return $this;
	}
}
?>
