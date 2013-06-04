<?php
class Media {
	
	var $id;
	var $url;
	var $type;
	var $valid = false;
	var $size;

	function __construct($url, $type=null) {
		$this->url = $url;
		if($type) {
			$this->type = $type;
		} else {
			$this->type = strtolower (get_class($this));
		}
		$this->id = crc32($url);
		$this->size = array(300,300);
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
		$type_query = "SELECT id FROM types WHERE name='$this->type'";
		$type_result = $db->query($type_query);
		$type_row = $type_result->fetch_assoc();
		
		$insert = "INSERT INTO media(id, type, url, width, height) VALUES ('$this->id', ";
		$insert .= $type_row['id'] . ", '";
		$insert .= $db->real_escape_string($this->getUrl()) . "', '";
		$insert .= $this->size[0] . "', '" . $this->size[1] . "')";
		$result = $db->query($insert);
		
		return $this->id;
	}

	public function render( $mode, $placeholders=array() ) {
		$placeholders = array_merge( (array)$this->getPlaceholders(), (array)$placeholders );
		$securePH = array();
		foreach($placeholders as $key => $value) {
			$securePH["$key"] = htmlspecialchars($value);
		}
		return render($this->getTemplate($mode), $securePH);
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
