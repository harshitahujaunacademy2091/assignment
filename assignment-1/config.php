<?php
require dirname(dirname(__FILE__)).'/vendor/autoload.php';
$server="";
$user="";
$pass="";
$db="";
$apikey="";
$sendgridmail="";
$sendgridname="";
$conn = mysqli_connect($server, $user, $pass, $db);
if (!$conn) {
    echo 'failed to connect';
}
$sendgrid = new \SendGrid($apikey);
$mail = new \SendGrid\Mail\Mail();
$mail->setFrom($sendgrid, $sendgridname);
?>