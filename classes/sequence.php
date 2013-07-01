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
					$this->text = 'Another !';
					break;
				case 1:
					$this->text = 'Another one !';
					break;
				case 2:
					$this->text = 'Yet another !';
					break;
				case 3:
					$this->text = 'Again !';
					break;
				case 4:
				case 5:
					$this->text = 'And again !';
					break;
				case 6:
					$this->text = 'Please another one';
					break;
				case 7:
					$this->text = 'Just one more !';
					break;
				case 8:
					$this->text = 'Or two ?';
					break;
				case 9:
					$this->text = 'Good things come in threes';
					break;
				case 10:
					$this->text = 'Ok last one';
					break;
				case 11:
					$this->text = 'Shouldn\'t I be working ?';
					break;
				case 12:
					$this->text = 'Last one this time';
					break;
				case 13:
					$this->text = 'But this time I mean it';
					break;
				case 14:
					$this->text = 'I promise';
					break;
				case 15:
					$this->text = 'I can quit anytime';
					break;
				case 16:
					$this->text = 'It\'s not like I\'m addicted';
				case 17:
					$this->text = 'I kan haz lil moa ?';
					break;
				default:
					$this->text = 'Ok I\'ll stop last year';
					break;
			}
			if($this->n == $this->limit-1) {
				$this->text = 'Shit ! Only one left';
			}
		} else {
			$this->limit = $this->dao->countDjif()-1;
		}
	}

	public function getRange() {
		return array($this->n, min(SEQUENCE_SIZE, $this->limit - $this->n));
	}

	public function getMsg() {
		return $this->text;
	}
	
	public function getImgsRender( $sort_by ) {
		$output = "";
		$previews = $this->dao->getPreviewsFromSeqBy($this, $sort_by);
		while($row = $previews->fetch_assoc()) {
			$hash = $row["hash"];
			$output .= replacePlaceHolders(file_get_contents('templates/djif-preview.html'), array('[[hash]]' => $hash ));
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
	
		return array(
				'[[imgs]]' => $this->imgs,
				'[[command]]' => $this->command('prev') . file_get_contents('templates/buttons/make.html') . $this->command('next')
		);
	}

	public function render( $sort_by='date', $placeholders=array() ) {
		
		$this->imgs = $this->getImgsRender($sort_by);
		$placeholders = array_merge( (array)$this->getPlaceholders(), (array)$placeholders );
		return replacePlaceHolders($this->getTemplate(), $placeholders);
	}

}

