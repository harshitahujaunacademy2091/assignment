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
    .imgcontainer {
        text-align: center;
        margin: 24px 0 12px 0;
    } 
    .container {
        padding: 16px;
    }
    </style>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>XKCD Subscribe</title>
</head>

<body>
    <div id="header">
        <h3 style="text-align:center;line-height:50px">XKCD Comics  Subscriber</h3>
    </div>
    <div id="wrap">

        <?php

        include_once dirname(__FILE__).'/config.php';
        if (isset($_GET['id']) && !empty($_GET['id'])) {
          
            $hash = $conn->real_escape_string($_GET['id']); // Set hash variable
            if ($search = $conn->query("SELECT hash, active FROM users WHERE hash='" . $hash . "' AND active IS NULL")) {
                $count = $search->num_rows;
            }
            if ($count > 0) {       
              
                $conn->query("UPDATE users SET active='1' WHERE hash='".$hash."' AND active IS NULL");
                $msg = 'Your account has been activated! Enjoy free XKCD comics every 5 minutes.';
                $color ='color:darkgreen;';
                $image='https://cdn.iconscout.com/icon/free/png-256/verified-badge-1-866240.png';
            }else{
                $image = 'https://img.icons8.com/pastel-glyph/2x/error.png';
                $msg = 'Account already activated or Invalid request!';
                $color ='color:darkred;';
            }                   
        }else{
            $image = 'https://img.icons8.com/pastel-glyph/2x/error.png';
            $msg = 'Invalid Request, Please register!';
            $color ='color:darkred;';
        }
        ?>
        
        <?php
            if (isset($image)) { 
                echo ' <div class="imgcontainer"><img style="width:170px" src= '.$image.' alt="Avatar" > </div>'; // Display our message and wrap it with a div with the class "statusmsg".
            }
            ?>
        <?php
            if (isset($msg)) {
                echo '<div style='.$color.';overflow: auto ><h3 style="text-align:center;line-height:32px">' . $msg . '</h3></div>'; // Display our message and wrap it with a div with the class "statusmsg".
            }
            ?>

    </div>
</body>

</html>