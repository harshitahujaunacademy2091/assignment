<?php
require dirname(dirname(__FILE__)).'/vendor/autoload.php';
$development=true;
if($development){
    $conn = mysqli_connect('localhost', 'developer', 'Master@1234', 'rtcamp1');
}else{
    $databaseurl=parse_url(getenv("CLEARDB_DATABASE_URL"));
    $server=$databaseurl["host"];
    $user=$databaseurl["user"];
    $pass=$databaseurl["pass"];
    $db=substr($databaseurl["path"],1);
    $conn = mysqli_connect($server, $user, $pass, $db);
}
if (!$conn) {
    echo 'failed to connect';
}
$sendgrid = new \SendGrid("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");
$mail = new \SendGrid\Mail\Mail();
$mail->setFrom("harshitahuja2091@gmail.com", "harshit ahuja");
?>