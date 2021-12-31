<?php 
if (count(get_included_files()) == 1 || $_SERVER["REQUEST_URI"]=="/_contact.php") {header("Location:/");die();}
else{
include("core/class.phpmailer.php");

if (!empty($_POST)){
	$_email = (isset($_POST['email']) ? $_POST['email'] : null);
	$_reason = (isset($_POST['reason']) ? $_POST['reason'] : null);
	$_subject = (isset($_POST['subject']) ? $_POST['subject'] : null);
	$_message = (isset($_POST['message']) ? $_POST['message'] : null);
	
	if (strlen($_email)>8 && strlen($_reason)>5 && strlen($_subject)>10 && strlen($_message)>50){
		$ok=false;
		try{
			$gMessage="Who: ".$_email."<br />Reason: ".$_reason."<br /><br />Message: ".str_replace("\n","<br />",$_message);
			
			$mail = new PHPMailer();
			$mail->IsSMTP();
			$mail->SMTPAuth = true;
			$mail->SMTPSecure = 'tls';
			$mail->Host = "smtp.gmail.com";
			$mail->Port = 587;
			$mail->IsHTML(true);
			$mail->CharSet  ="utf-8";
			$mail->Username = "id@gmail.com";
			$mail->Password = "pw";
			$mail->SetFrom("id@gmail.com", $_g_siteName);
			$mail->AddAddress("id@gmail.com");
			$mail->Subject = $_subject;
			$mail->Body = $gMessage;
			if(!$mail->Send()){
				echo "Mail Error: ".$mail->ErrorInfo;
			} else {
				$ok=true;
			}
		}
		catch(Exception $e){
			$ok=false;
		}
		
		if (!$ok){
			alert("Your message could not be sent! Please try again later.");
		}
		else {
			alert("Your message has been sent successfully, if necessary, a response will be made to the e-mail address you provided.");
			redirect("/contact");
		}
	}
}
	
?>
<h1 class="ttl">Contact</h1>
<div class="pd">
You can use the form below to contact us. The form below sends an e-mail to <b>id@gmail.com</b>. If there is a problem in the form below, you can contact us at the e-mail address we have specified. 
</div>
<div class="contact">
<form method="post">
	<table class="ilTbl">
	<tr><td>E-mail: </td><td><input type="text" name="email" /><br />It will be used to communicate with you and get back to you.</td></tr>
	<tr><td>Reason: </td><td><select name="reason">
	<option value="Movie Request">Movie Request</option>
	<option value="Suggestion">Suggestion</option>
	<option value="Complaint">Complaint</option>
	<option value="Advertising Offer">Advertising Offer</option>
	<option value="Another Subject">Another Subject</option>
	</select></td></tr>
	<tr><td>Subject: </td><td><input type="text" name="subject" /></td></tr>
	<tr><td>Message: </td><td><textarea name="message"></textarea></td></tr>
	<tr><td></td><td align="right"><input type="submit" value="Send"></td></tr>
	</table>
</form>
</div>
<div class="clr"></div>
<?php }?>