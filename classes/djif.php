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
			
			$gif = new Media( $row["gif"] );
			$this->gif = $gif->getMedia();
				
			$audio = new Media( $row["audio"] );
			$this->audio = $audio->getMedia();
			
		} else { // from two urls
			
			$gif = new Media( $param1 );
			$this->gif = $gif->getMedia();
			
			$audio = new Media( $param2 );
			$this->audio = $audio->getMedia();
		}
	}


	public function getPlaceholders() {
		if ($ajax) {
			$visible = ' style="display : none"';
		} else {
			$visible = '';
		}
		return array(
				'keys' => array(
						'[[gif]]',
						'[[audio]]',
						'[[visible]]'
				),
				'values' => array(
						$this->gif->render(),
						$this->audio->render(),
						$visible
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
