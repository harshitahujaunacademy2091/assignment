<!DOCTYPE html>
<html>
<style>
    body{
        background-image: url('xkcd.png');
        background-position: center;
        background-size: cover;
        height: 100vh;
        background-repeat: no-repeat;
        display: flex;
        justify-content: center;
        align-items: center;
    }    
  
    #header{
        position: fixed;
        top: 0;
        width: 100%;
        background: #fff;        
    }    
    #wrap{
        background-color: #fff;        
    }
    .imgcontainer {
        text-align: center;
        margin: 24px 0 12px 0;
    }
</style>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>XKCD Subscribe</title>
</head>

<body style="background-color:#6C7990;">
    <div id="header">
        <h3 style="text-align:center;">XKCD Comics Subscriber </h3>
    </div>
    <div id="wrap">

        <?php
         include_once dirname(__FILE__).'/config.php'; //_dir_ is faster but since dirname  is more widely used
         if (isset($_GET['id']) && !empty($_GET['id'])) {
            $hash = $conn->real_escape_string($_GET['id']); 

            if ($conn->query("SELECT hash, active FROM users WHERE hash='" . $hash . "' AND active IS NOT NULL")->num_rows > 0) {
                
                $conn->query("UPDATE users SET active = NULL WHERE hash='".$hash."' AND active IS NOT NULL");
                $msg = 'Unsuscribed! You will not recieve anymore comics from now.</div>';
                $image='https://cdn.iconscout.com/icon/premium/png-256-thumb/unsubscribe-3313787-2794127.png';
                $color ='color:darkgreen;';
            }else{
                $msg = 'Already Unsubscribed or invalid request!</div>';
                $image = 'https://img.icons8.com/pastel-glyph/2x/error.png';
                $color ='color:darkred;';
            }
        }
        ?>

        <?php
            if (isset($image)) {  // Check if $msg is not empty
                echo ' <div class="imgcontainer"><img src= '.$image.' alt="Avatar" > </div>'; // Display our message and wrap it with a div with the class "statusmsg".
            }
            ?>
        <?php
            if (isset($msg)) {  // Check if $msg is not empty
                echo '<div style='.$color.' ><h4 style="text-align:center;">' . $msg . '</h3></div>'; // Display our message and wrap it with a div with the class "statusmsg".
            }
            ?>
    </div>
</body>
        
</html>