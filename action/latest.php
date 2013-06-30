<?php
	require_once('config/config.php');
	require_once('classes/dao.php');
	require_once('classes/media.php');
	require_once('classes/djif.php');
	require_once('classes/sequence.php');

	$dao = new Dao();
	$seq = new Sequence($dao, 'latest');
	echo '<div id="previews">';
	$previews = $dao->getPreviewsFromSeqBy($seq, 'date');
	while($row = $previews->fetch_assoc()) {
		$hash = $row["hash"];
?>
		<a href="/<?php echo $hash;?>">
			<img class="preview" src="/<?php echo $hash;?>.jpg"/>
		</a>
<?php
	}
	echo '</div>';
	$seq->command('prev');
	include('templates/buttons/make.html');
	$seq->command('next');

?>

