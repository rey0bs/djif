<?php

class Djif {
	
	var $gif;
	var $audio;
	var $db;

	function __construct($param1, $param2=NULL ) {
		if (! $param2 && strlen($param1) == 5) { // from hash
			$this->db =  new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
			if ($this->db->connect_errno) {
				die ("Could not connect db " . DB_NAME . "\n" . $link->connect_error);
			}
			$hash = $this->db->real_escape_string(substr($param1,0,5));
			$result = $this->db->query("SELECT gif, audio FROM urls WHERE hash = '$hash'");
			$row = $result->fetch_assoc();
			$result->free();
			$this->gif = $this->getMedia( $row["gif"]);
			$this->audio = $this->getMedia( $row["audio"]);
		} else { // from two urls
			$this->gif = $this->getMedia( $param1 );
			$this->audio = $this->getMedia( $param2 );
		}
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

	public function store() {
		$charset = array_merge(range(0,9), range('a','z'), range('A', 'Z'));
		$hash = '';
		for ($i=0; $i < 5; $i++) {
			$hash .= $charset[array_rand($charset)];
		}
		$url = 'http://' . $_SERVER['SERVER_NAME'] . '/' . $hash;
		return str_replace( array('[[url]]'), array($url), file_get_contents ('templates/link.php') );
	}

}
?>
