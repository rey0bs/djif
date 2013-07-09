<?php

class Dao {

	var $db;

	function __construct() {
		$this->db =  new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
		if ($this->db->connect_errno) {
			die ("Could not connect db " . DB_NAME . "\n" . $this->db->connect_error);
		}
	}

	/** Operations concerning Djifs **/
	function countDjif() {
		$select = "SELECT count(*) as n FROM djifs";
		$result = $this->db->query($select);
		$row = $result->fetch_assoc();
		if( empty($row) ) {
			return 0;
		} else {
			return $row['n'];
		}
	}

	function fullDjifLine() {
		$select = "
			SELECT
				hash,
				title,
				img.width, img.height,
				img.url AS img,
				imgType.name AS imgType,
				audio.url AS audio,
				audioType.name AS audioType
			FROM
				djifs,
				media AS img, types AS imgType,
				media AS audio, types AS audioType
			WHERE
				djifs.gif = img.id AND djifs.audio = audio.id
				AND img.type = imgType.id AND audio.type = audioType.id";
		return $select;
	}

	function getDjifByHash($hash) {
		$hash = $this->db->real_escape_string(substr($hash,0,5));
		$select = $this->fullDjifLine() . " AND hash = '$hash'";
		$result = $this->db->query($select);
		$row = $result->fetch_assoc();
		if( empty($row) ) {
			return null;
		} else {
			$this->db->query("UPDATE djifs SET visits = visits + 1 WHERE hash = '$hash'");
			return Djif::fromAssoc($row);
		}
	}

	function getNthDjifBy($n, $criterion) {
		$select = $this->fullDjifLine() . " ORDER BY $criterion DESC LIMIT $n, 1";
		$result = $this->db->query($select);
		if($row = $result->fetch_assoc()) {
			return Djif::fromAssoc($row);
		} else {
			die ("Could not retrieve Djif #$n (by $criterion)");
		}
	}

	function getPreviewsFromSeqBy($seq, $criterion) {
		$range = $seq->getRange();
		$from = $range[0];
		$n = $range[1];
		$select = "
			SELECT
			hash,
			title,
			types.name as type
		FROM djifs, media, types
		WHERE djifs.audio = media.id AND media.type = types.id
		ORDER BY $criterion DESC LIMIT $from, $n";
		$result = $this->db->query($select);
		if($result) {
			return $result;
		} else {
			die ("Could not retrieve $n previews from $from (by $criterion)");
		}
	}

	function getRandomDjif() {
		$select = "SELECT hash FROM djifs ORDER BY RAND() LIMIT 1";
		$result = $this->db->query($select);
		if($row = $result->fetch_assoc()) {
			return $this->getDjifByHash($row["hash"]);
		} else {
			die ("Could not get random Djif");
		}
	}

	function getUrlsFromHash($hash) {
		$hash = $this->db->real_escape_string(substr($hash,0,5));
		$select = "
			SELECT
				img.url as imgUrl,
				audio.url as audioUrl
			FROM
				djifs,
				media as img,
				media as audio
			WHERE
			hash = '$hash'
			AND djifs.gif = gif.id
			AND djifs.audio = audio.id";
		$result = $this->db->query($select);
		if ($result && $row = $result->fetch_assoc()) {
			return array('[[gifUrl]]' => $row["imgUrl"], '[[audioUrl]]' => $row["audioUrl"]);
		}
		return null;
	}

	function preview($hash) {
		$hash = $this->db->real_escape_string(substr($hash,0,5));
		$select = "SELECT preview FROM djifs WHERE hash = '$hash'";
		$result = $this->db->query($select);
		if ($result && $row = $result->fetch_assoc()) {
			return $row['preview'];
		}
		return null;
	}

	function storeDjif($hash, $gif_id, $audio_id, $preview, $title) {
		$ip = ip2long ($this->db->real_escape_string($_SERVER['REMOTE_ADDR']));
		$preview = $this->db->real_escape_string($preview);
		$insert = "
			INSERT INTO
				djifs(hash, gif, audio, ip, preview, title)
			VALUES ('$hash', '$gif_id', '$audio_id', '$ip', '$preview', '$title')";
		$this->db->query($insert);
	}

	/** Operation concerning Media **/
	function getMediaType($name) {
		$select = "SELECT id FROM types WHERE name='$name'";
		$result = $this->db->query($select);
		if($result && $row = $result->fetch_assoc()) {
			return $row['id'];
		} else {
			die ("Could not retrieve media type named '$name'");
		}
	}

	function storeMedia($id, $type, $url, $width, $height) {
		$url = $this->db->real_escape_string($url);
		$insert = "
			INSERT INTO
				media(id, type, url, width, height)
		 	VALUES ('$id', '$type', '$url', '$width', '$height')";
		$this->db->query($insert);
	}
}
?>
