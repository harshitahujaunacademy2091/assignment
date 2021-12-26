<!DOCTYPE html>
<html>
<style>    
    *{
        font-family: sans-serif;
    }    
    html,body{
        width:100%;
        height:100%;
        margin:0;
    }
    body{
        background: linear-gradient(to top, #373b44, #4286f4);        
        background-position: center;
        background-size: cover;
        background-repeat: no-repeat;
        display: flex;
        justify-content: center;
        align-items: center;
    }    
    input[type=text],
    input[type=password] {
        width: 100%;
        padding: 12px 20px;
        margin: 8px 0;
        display: inline-block;
        border: 1px solid #ccc;
        box-sizing: border-box;
        outline:none;
    }
    button {
        background-color: #4CAF50;
        color: white;
        padding: 14px 20px;
        margin: 8px 0;
        border: none;
        cursor: pointer;
        width: 100%;
    }
  
    #header{
        position: fixed;
        top: 0;
        width: 220px;
        font-size:20pt;
        color:white;        
    }    
    #wrap{
        background-color: #fff;   
        border-radius:0.3em;     
        width:430px;
        margin:10px;
    }    
    button:hover {
        opacity: 0.8;
    }
    .cancelbtn {
        width: auto;
        padding: 10px 18px;
        background-color: #f44336;
    }
    .imgcontainer {
        text-align: center;
        margin: 24px 0 12px 0;
    }
    img.avatar {
        width: 40%;
        border-radius: 50%;
    }
    .container {
        padding: 16px;
    }
    span.psw {
        float: right;
        padding-top: 16px;
    }
    form .field{
        margin:20px 0;
    }
    form label{
        font-size:11pt
    }
    @media screen and (max-width: 300px) {
        span.psw {
            display: block;
            float: none;
        }

        .cancelbtn {
            width: 100%;
        }
    }
</style>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>XKCD Subscribe</title>
</head>

<body>
    <div id="header">
        <h3 style="text-align:center;line-height: 50px;">XKCD Comics Subscriber</h3>
    </div>

    <div id="wrap">
        <?php

        include_once dirname(__FILE__).'/config.php';
        $color = 'color:green;';

        $name = $email  = "";
        if (isset($_POST['name']) && !empty($_POST['name']) and isset($_POST['email']) && !empty($_POST['email'])) {
            $name = trim($conn->real_escape_string($_POST['name']));
            $email = trim($conn->real_escape_string($_POST['email']));
            $hash = md5(rand(0, 1000));
            $count = 1;
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $msg = 'The email you have entered is invalid, please try again.';
                $color = 'color:red;';
            } else {

                //check if email already exits in db
                if ($result = $conn->query("SELECT * FROM users WHERE email = '$email' and active is NOT NULL")) {
                    $count = $result->num_rows;
                }
                if ($count == 0) {
                    //send email if new email

                    if ($conn->query("SELECT * FROM users WHERE email = '$email' and active is NULL")->num_rows == 1) {
                        $conn->query("UPDATE users set name = '$name', hash = '$hash' where email = '$email'");
                        $msg = 'Verifification email has been resent, Name updated successfully!';
                        $color = 'color:green;';
                    } else {
                        mysqli_query($conn, "INSERT IGNORE INTO users (name, email, hash) VALUES('" . $name . "', '" . $email . "', '" . $hash . "') ");
                        $msg = 'Verifification email sent to '."$email".' successfully! Activate your account to enroll for comics.';
                        $color = 'color:green;';
                    }
                    $mail->addTo($email, $name);
                    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
                        $verify = 'https';
                    } else {
                        $verify = 'http';
                    }
                    $verify .= '://';
                    $patharr=explode("/",$_SERVER['REQUEST_URI']);
                    $verify.=$_SERVER['HTTP_HOST'];
                    $patharr[count($patharr)-1]="verify.php";
                    $verify.=join("/",$patharr);                                                    
                    $mail->setSubject("Account Verification");
                    $mail->addContent("text/html",'Hello, ' . $name . '<br>Please verify your email to subscribe to XKCD Comics very 5 minutes for free.<br> '.$verify.'?id=' . $hash . "\r\n");
                    try{
                        $response=$sendgrid->send($mail);
                    }catch(Exception $e){
                        $msg = 'Verifification email failed, try again later!';
                        $color = 'color:red;';                        
                    }
                } else {
                    $msg = 'Already subscribed with this email!';
                    $color = 'color:red;';
                }
            }
        }

        ?>
        <div class="form-group">
        </div>


        <!--Step 1 : Adding HTML-->
        <form action="" method="post">
            <div class="imgcontainer">
                <img src="https://xkcd.com/s/0b7742.png" alt="Avatar">
            </div>

            <div class="container">
                <div class="field">
                    <label><b>Name</b></label>
                    <input autocomplete="off" type="text" placeholder="Enter Name" name="name" required>
                </div>
                <div class="field">
                    <label><b>Email</b></label>
                    <input autocomplete="off" type="text" placeholder="Enter Email Address" name="email" required>
                </div>
                <?php
                if (isset($msg)) {  // Check if $msg is not empty
                    echo '<div style=' . $color . '>' . $msg . '</div>'; // Display our message and wrap it with a div with the class "statusmsg".
                }
                ?>

                <button type="submit">Subscribe</button>
            </div>

        </form>

</body>

</html>