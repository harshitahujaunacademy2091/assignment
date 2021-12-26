<?php
include_once dirname(__FILE__).'/config.php';
$url='https://c.xkcd.com/random/comic/';
$headers=get_headers($url,1);
$unparsedurl=$headers['Location'][0]; 
$parsedurl= parse_url($unparsedurl,PHP_URL_PATH);
$code=filter_var($parsedurl, FILTER_SANITIZE_NUMBER_INT);
$url = 'https://xkcd.com/'.$code.'/info.0.json'; 
$imgdata = file_get_contents($url); 
$char = json_decode($imgdata);
$image=$char->img;
$sql = "SELECT email, name, hash FROM users WHERE active is NOT NULL";
$stmt=mysqli_query($conn,$sql);
$rows = array();
if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
    $verify = 'https';
} else {
    $verify = 'http';
}
$mail->setSubject("XKCD Comic");
while($row = mysqli_fetch_assoc($stmt)){
    $mail->addTo($row['email'],$row['name']);
    $mail->addContent("text/html",'Your free copy of  XKCD is attached. Have fun!<br><br> <img src='.$image.'> <br><br> <a href='.$verify.'://'.$_SERVER['HTTP_HOST'].'/unsubs.php?id='.$row['hash'].'>Click here to Unsubscribe.</a>'."\r\n");
    try {
        $response = $sendgrid->send($mail);  
    } catch (Exception $e) {
        echo 'Caught exception: '. $e->getMessage() ."\n";
    }        
}
?>
