<?php

	function createHash() {
		$charset = array_merge(range(0,9), range('a','z'), range('A', 'Z'));
		$hash = '';
		for ($i=0; $i < 5; $i++) {
			$hash .= $charset[array_rand($charset)];
		}
		return $hash;
	}

	function replacePlaceHolders($contents, $placeHolders) {
		$output = $contents;
		foreach ($placeHolders as $key => $value) {
			$output = str_replace($key , $value , $output );
		}
		return $output;
	}
	
	function fail() {
		if(isset($ajax)) {
			throw new Exception('Ta yeule');
		} else {
			$i = rand (0, count(glob('templates/errors/msg*.html')) - 1);
			include("templates/errors/msg$i.html");
			include("templates/buttons/another.html");
		}
	}
?>
