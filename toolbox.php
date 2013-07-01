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

	function interpret($file, $contents) {
		if(is_array($contents)) {
			$pholders = $contents;
		} else {
			$pholders = array('[[default]]' => $contents);
		}
		echo replacePlaceHolders(file_get_contents($file), $pholders);
	}
	
	function fail() {
		if(isset($ajax)) {
			throw new Exception('Ta yeule');
		} else {
			//$i = rand (0, count(glob('templates/errors/msg*.html')) - 1);
			switch(rand (0, 8)) {
			case 0:
				$msg = ERROR_MSG_0;
				break;
			case 1:
				$msg = ERROR_MSG_1;
				break;
			case 2:
				$msg = ERROR_MSG_2;
				break;
			case 3:
				$msg = ERROR_MSG_3;
				break;
			case 4:
				$msg = ERROR_MSG_4;
				break;
			case 5:
				$msg = ERROR_MSG_5;
				break;
			case 6:
				$msg = ERROR_MSG_6;
				break;
			case 7:
				$msg = ERROR_MSG_7;
				break;
			default:
				$msg = ERROR_MSG_8;
				break;
			}
			$pholders = array('[[error_title]]' => ERROR_TITLE, '[[error_button]]' => ERROR_BUTTON);
			interpret('templates/errors/missingHash.html', $msg);
			interpret('templates/buttons/another.html', $pholders);
		}
	}
?>
