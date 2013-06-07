<?php

	function createHash() {
		$charset = array_merge(range(0,9), range('a','z'), range('A', 'Z'));
		$hash = '';
		for ($i=0; $i < 5; $i++) {
			$hash .= $charset[array_rand($charset)];
		}
		return $hash;
	}

	function accessDB() {
		$db =  new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
		if ($db->connect_errno) {
			die ("Could not connect db " . DB_NAME . "\n" . $db->connect_error);
		}
		return $db;
	}

	function render($contents, $placeHolders) {
		$output = $contents;
		foreach ($placeHolders as $key => $value) {
			$output = str_replace($key , $value , $output );
		}
		return $output;
	}
	
	function fail($db=null) {
		if(isset($ajax)) {
			throw new Exception('Ta yeule');
		} else {
			$i = rand (0, count(glob('templates/errors/msg*.html')) - 1);
			include("templates/errors/msg$i.html");
			include("templates/buttons/another.html");
		}
	}

?>
