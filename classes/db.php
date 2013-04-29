<?php

class Db {
	var $link;
 
	function __construct() {
		$this->link	= new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
		if ($this->link->connect_errno) {
			die ("Could not connect db " . DB_NAME . "\n" . $link->connect_error);
		}
	}

	function get( $hash ) {
		if(! $this->link ) {
			die('link is not defined');
		}
		$this->link->real_escape_string(substr($hash,0,5));
		$result = $this->link->query("SELECT gif, audio FROM urls WHERE hash = '$hash'");
		$row = $result->fetch_assoc();
		$result->free();
		return $row;
	}

	function set ( $hash, $gif, $audio ) {
		echo('not implemented yet');

	}

}
?>
