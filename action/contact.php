<?php 
if ($_POST['name'] && $_POST['email'] && $_POST['message']) {
	require_once('config/config.php');
	$to      = CONTACT;
	$subject = CONTACT_SUBJECT;
	
	$message = '
	<html>
		<head>
			<title>'.CONTACT_SUBJECT.'</title>
		</head>
		<body>
			<h2>'.CONTACT_SUBJECT.'</h2>
			<p>
				<strong>'.NAME.'</strong><br>
				' . $_POST['name'] . '
			</p>
			<p>
				<strong>'.EMAIL.'</strong><br>
				' . $_POST['email'] . '
			</p>
			<p>
				<strong>'.MESSAGE.'</strong><br>
				' . nl2br($_POST['message']) . '
			</p>
				
		</body>
	</html>
	';
	
	// Pour envoyer un mail HTML, l'en-tête Content-type doit être défini
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
	$headers .= 'From: contact@djif.net' . "\r\n" .
			'Reply-To: ' . $_POST['email'] . "\r\n" .
			'X-Mailer: PHP/' . phpversion();
	
	mail($to, $subject, $message, $headers);
?>
	<p class="quote"><?php echo CONTACT_THANKS;?></p>
	<form action="/" method="post">
		<input type="hidden" name="from" value="contact" />
		<div class="submit_button">
		<input type="submit" value="<?php echo CONTACT_BOAST_BUTTON;?>" />
		</div>
	</form>
<?php 
} else {
?>
	<form action="/contact" method="post" id="contact">
		<div class="input_group">
			<label for="name"><?php echo CONTACT_FORM_NAME;?>*</label>
			<input type="text" name="name" value="<?php echo $_POST['name']; ?>" required="required" placeholder="Lol Cat" />
			<label for="email"><?php echo CONTACT_FORM_EMAIL;?>*</label>
			<input type="email" name="email" value="<?php echo $_POST['email']; ?>" required="required" placeholder="lol.cat@wtf.com" />
			<label for="message"><?php echo CONTACT_FORM_MESSAGE;?>*</label>
			<textarea name="message" rows="6" required="required" placeholder="<?php echo CONTACT_FORM_EXEMPLE_MESSAGE;?>"><?php echo $_POST['message']; ?></textarea>
			<span class="small text-right">* <?php echo CONTACT_FORM_REQUIRED;?></span>
		</div>
		<div class="submit_button">
		<input id="remix" type="submit" value="<?php echo CONTACT_FORM_SEND;?>" />
		</div>
	</form>
<?php } ?>
