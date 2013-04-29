<?php

class Db {
	var $link;
	var $toto;
 
	function __construct() {
		$toto = 'burp';
		$link	= new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
		if ($link->connect_errno) {
			die ("Could not connect db " . DB_NAME . "\n" . $link->connect_error);
		}
	}

	function get( $hash ) {
		$llink = $this->link;
		echo("toto is $this->toto");
		if(! $llink ) {
			die('link is not defined');
		}
		$llink->real_escape_string(substr($hash,0,5));
		$result = $this->link->query("SELECT gif, audio FROM urls WHERE hash = '$hash'");
		return $result->fetch_assoc();
	}

	function set ( $hash, $gif, $audio ) {
		echo('not implemented yet');

	}

}
?>
