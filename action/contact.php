<?php 
if ($_POST['name'] && $_POST['email'] && $_POST['message']) {
	require_once('config/config.php');
	$to      = CONTACT;
	$subject = 'Contact from djif.net';
	
	$message = '
	<html>
		<head>
			<title>Contact from djif.net</title>
		</head>
		<body>
			<h2>Contact from djif.net</h2>
			<p>
				<strong>Name</strong><br>
				' . $_POST['name'] . '
			</p>
			<p>
				<strong>Email</strong><br>
				' . $_POST['email'] . '
			</p>
			<p>
				<strong>Message</strong><br>
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
	<p class="quote">Thanks for your feedback.</p>
	<form action="/" method="post">
		<input type="hidden" name="from" value="contact" />
		<div class="submit_button">
			<input type="submit" value="I'm the best" />
		</div>
	</form>
<?php 
} else {
?>
	<form action="/contact" method="post" id="contact">
		<div class="input_group">
			<label for="name">Your name*</label>
			<input type="text" name="name" value="<?php echo $_POST['name']; ?>" required="required" placeholder="Lol Cat" />
			<label for="email">Your email*</label>
			<input type="email" name="email" value="<?php echo $_POST['email']; ?>" required="required" placeholder="lol.cat@wtf.com" />
			<label for="message">Your message*</label>
			<textarea name="message" rows="6" required="required" placeholder="Your website is an insult to my race."><?php echo $_POST['message']; ?></textarea>
			<span class="small text-right">* Required</span>
		</div>
		<div class="submit_button">
			<input id="remix" type="submit" value="Send !" />
		</div>
	</form>
<?php } ?>
