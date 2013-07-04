<?php

class Sequence {

	var $n;
	var $type;
	var $limit;
	var $text;
	var $dao;

	function __construct($type, $infinite=null) {
		$this->dao = new Dao();
		if(isset($_POST['n']) && is_numeric($_POST['n'])) {
			$this->n = $_POST['n'];
		} else {
			$this->n = 0;
		}
		$this->type = $type;
		if($type == 'wtf' ) {
			$this->limit = -1;
			switch ($this->n) {
				case 0:
					$this->text = ANOTHER_TXT_0;
					break;
				case 1:
					$this->text = ANOTHER_TXT_1;
					break;
				case 2:
					$this->text = ANOTHER_TXT_2;
					break;
				case 3:
					$this->text = ANOTHER_TXT_3;
					break;
				case 4:
				case 5:
					$this->text = ANOTHER_TXT_4_5;
					break;
				case 6:
					$this->text = ANOTHER_TXT_6;
					break;
				case 7:
					$this->text = ANOTHER_TXT_7;
					break;
				case 8:
					$this->text = ANOTHER_TXT_8;
					break;
				case 9:
					$this->text = ANOTHER_TXT_9;
					break;
				case 10:
					$this->text = ANOTHER_TXT_10;
					break;
				case 11:
					$this->text = ANOTHER_TXT_11;
					break;
				case 12:
					$this->text = ANOTHER_TXT_12;
					break;
				case 13:
					$this->text = ANOTHER_TXT_13;
					break;
				case 14:
					$this->text = ANOTHER_TXT_14;
					break;
				case 15:
					$this->text = ANOTHER_TXT_15;
					break;
				case 16:
					$this->text = ANOTHER_TXT_16;
					break;
				case 17:
					$this->text = ANOTHER_TXT_17;
					break;
				default:
					$this->text = ANOTHER_TXT_18;
					break;
			}
			if($this->n == $this->limit-1) {
				$this->text = ANOTHER_ONE_LEFT;
			}
		} else {
			$this->limit = $this->dao->countDjif()-1;
		}
	}

	public function getRange() {
		return array($this->n, SEQUENCE_SIZE);
	}

	public function getMsg() {
		return $this->text;
	}
	
	public function getImgsRender( $sort_by ) {
		$output = "";
		$previews = $this->dao->getPreviewsFromSeqBy($this, $sort_by);
		while($row = $previews->fetch_assoc()) {
			$hash = $row["hash"];
			$output .= replacePlaceHolders(
					file_get_contents('templates/djif-preview.html'), 
					array('[[hash]]' => $row["hash"], '[[title]]' => $row["title"] )
			);
		}
		return $output;
	}

	public function command($cmd) {
		if($cmd == 'prev' && $this->n > 0) {
			$pholders = array(
				'[[target]]' => $this->type,
				'[[text]]' => '<',
				'[[n]]' => max($this->n - SEQUENCE_SIZE, 0)
			);
			return replacePlaceHolders(file_get_contents('templates/buttons/command.html'), $pholders);
		} else if ($cmd == 'next' && $this->n + SEQUENCE_SIZE < $this->limit) {
			$pholders = array(
				'[[target]]' => $this->type,
				'[[text]]' => '>',
				'[[n]]' => $this->n + SEQUENCE_SIZE
			);
			return replacePlaceHolders(file_get_contents('templates/buttons/command.html'), $pholders);
		} else if ($cmd == 'random') {
			$pholders = array(
				'[[target]]' => 'wtf',
				'[[text]]' => $this->text,
				'[[n]]' => $this->n+1
			);
			return replacePlaceHolders(file_get_contents('templates/buttons/command.html'), $pholders);
		}
		return '';
	}
	
	public function getTemplate() {
		$fileName = 'templates/sequence.html';
		if( file_exists( $fileName ) ) {
			return file_get_contents( $fileName );
		} else {
			return false;
		}
	}
	
	public function getPlaceholders() {
		$makeButton = replacePlaceHolders(file_get_contents('templates/buttons/make.html'), array('[[default]]' => MAKE_BUTTON));
		return array(
				'[[imgs]]' => $this->imgs,
				'[[command]]' => $this->command('prev') . $makeButton . $this->command('next')
		);
	}

	public function render( $sort_by='date', $placeholders=array() ) {
		
		$this->imgs = $this->getImgsRender($sort_by);
		$placeholders = array_merge( (array)$this->getPlaceholders(), (array)$placeholders );
		return replacePlaceHolders($this->getTemplate(), $placeholders);
	}

}

