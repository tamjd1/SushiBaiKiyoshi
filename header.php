<?php
    require 'includes/functions.php';
    //error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
    
    session_start();
    

    $login = '';
    $password = '';
   

   
// The login submit
if (!empty($_POST['login_submit'])) {
    $login = trim($_POST["login"]);
    $password = trim($_POST["password"]);
    
    //let's do some data validation
    if($login == "")
    {
        //means the user did not enter anything
        $_SESSION['message'] = "You did not enter a user name";
        $login = "";
        $password = "";
    }    
    else
    {
        $sql = "SELECT \"UserID\", \"Password\", \"UserFirst\", \"UserLast\", \"UserEmail\", \"UserPhone\", 
                        \"UserType\"
                FROM \"tblUsers\"
                WHERE \"UserID\" = '".$login."' AND \"Password\" = '".$password."'";

$conn = db_connect();
        $result = pg_query($conn, $sql);
        //Checks how many records result from the query
        $records = pg_num_rows($result);

        if ($records > 0)
        {           
          
        $_SESSION['UserID'] = $login;                   
        $_SESSION['UserFirst'] = pg_fetch_result($result, 0, 2);
        $_SESSION['UserLast'] = pg_fetch_result($result, 0, 3);
        $_SESSION['UserEmail'] = pg_fetch_result($result, 0, 4);
        $_SESSION['UserPhone'] = pg_fetch_result($result, 0, 5);
        $_SESSION['UserType'] = pg_fetch_result($result, 0, 6);
        $_SESSION['message'] = "Welcome ".$_SESSION['UserFirst']."!";
        $results = pg_query($conn, $sql);


        /*
        if (!isset($_COOKIE["loginID"]))
        {               
        setcookie("loginID", $loginID, time() + 60*60*24*30); // Expire in 30 days
        }*/
    }       
    else // no results
    {
        //lets check to see if the username is real!
        $sql = "SELECT * FROM \"tblUsers\"
                WHERE \"UserID\" = '".$login."'";
                $conn = db_connect();
        //Runs the select query
        $result = pg_query($conn, $sql);
        //Checks how many records result from the query
        $records = pg_num_rows($result);
        //If the information entered results in a resulting record (ie. the username&password are legit) then do this stuff
        if ($records > 0)
        {   
            $_SESSION['message'] = "Login/password combination not found in the database";
            $password = "";
        }
        else
        {
            $_SESSION['message'] = "Login/password not found in the database";
            $login = ""; //clears the sticky form if we cant find the desired id in the database
            $password = ""; //no need to clear password, because it is not a sticky form
        }
    }
    }
}

if (!empty($_POST['logout_submit'])) 
{
 header("Location: ./index.php");
    session_destroy();
    session_start();
    $_SESSION['message'] = "Logged out";
   
}

    
?>
<!DOCTYPE html>

<html lang="en">
<head runat="server">
    <meta charset="utf-8" />
    <link rel="stylesheet" type="text/css" href="./css/site.css" />
    <link rel="stylesheet" type="text/css" href="./css/styles.css" />
    <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
    <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
    <script src="./js/d3.js"></script>
    <script src="./js/functions.js"></script>
    <script src="./js/jquery-1.8.2.min.js"></script>
    <!--
        PageAccessed: <?php date_default_timezone_set('Canada/Eastern'); echo date("m/d/y"); ?>
        Author: Taha/Alejandro 
        Filename: <?php echo $file; ?>
        Date: <?php echo $date; ?>
        Description: <?php echo $description; ?>
    -->
    <title><?php echo $title ?></title>
</head>
<body>

    <div id="top" class="login-bar" style="text-align:center"> 
        <form id="login" name="login" action="" method="post">
            <?php
            
            
            
            // If not logged in show 
            if (!isset($_SESSION['UserID']))
            {
                echo "<input id='register' name='login_submit' type='button' class='float-left button' value='Register' onclick='' />";
                echo "<input id='login_submit' name='login_submit' type='submit' class='float-right button' value='Login' onclick='login()'  />";
              
                echo "<input id='password' name='password' type='password' class='float-right textbox' value='$password' placeholder='Password'/>"; 
                  echo "<input id='login' name='login' type='text' class='float-right textbox' value='$login' placeholder='Username'/>";
                
            }
            else
            {
                echo "Welcome <a href=\"edit_profile.php\">".$_SESSION['UserFirst']." ".$_SESSION['UserLast']."!</a>";
                echo "<input id='logout_submit' name='logout_submit' type='submit' class='float-right button' value='Logout' onclick='logout()'/>";
                
                if($_SESSION['UserType'] != 'u')
                {
                    //echo "<li><a href=\"logout.php\">Logout</li></a>";
                    //echo "<li><a href=\"welcome.php\">Account Page</li></a>";       
                }
                else if ($_SESSION['UserType'] == 'a')
                {
                    //echo "<li><a href=\"admin.php\">Admin Panel</a></li>";
                }
                
            //echo "<li>Welcome " . $_SESSION['id'] . ", <a href href=\"welcome.php\">Account Page</a>";

           }
            
            //if not signed in
            
                //echo "<input id='password' name='password' type='password' class='float-right textbox' value='$password' />"; 
                //echo "<input id='login' name='login' type='text' class='float-right textbox' value='$login' />";
           
                //echo "<p style='margin:0; text-align:center'>Welcome, $login</p>"; 
                //echo "<input id='go' type='submit' style='position:relative; bottom:20px;' class='float-right button' value='Logout' onclick='logout()'/>";
            

            ?>
        </form>
    </div>   
    
    <header>
        <div id="logoDiv">
            <img height="130px" src="./images/logo.jpg" alt="logo" />
        </div>
        <nav> 
            <ul> 
                <li><a href="./index.php">Home</a></li>
                <li><a href="./index.php">About Us</a></li>
                <li><a href="./order.php">Order Online</a></li>           
                <?php
                //if not signed in
               
                if (isset($_SESSION['UserID']))
                {
                     echo "<li><a href=\"edit_profile.php\">Edit Profile</li></a>"; 
                     if ($_SESSION['UserType'] == 'a')
                    {
                        echo "<li><a href=\"admin.php\">Admin Panel</a></li>";
                    }
                }
                            
                                 
                 
                           
                       
                ?>
            </ul>
        </nav>
    </header>
        
    <div id="messageArea" class="message"">
       <?php echo $_SESSION['message'];
       $_SESSION['message'] = "";?>
       
    </div>
        