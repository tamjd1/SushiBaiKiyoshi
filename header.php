<?php
    if(session_id() == "")
    {
        session_start();
    }
    
    /*
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {       
        //the page got here from submitting the form, let's try to process
        $loginID = trim($_POST["login"]);
        $password = trim($_POST["pass"]);
        
        //let's do some data validation
        if(!isset($loginID) || $loginID == "" || !isset($password) || $password == "" )
        {
            //means the user did not enter anything
            $error = "Login/password not found in the database";
            $loginID = "";
        }
        else
        {
            //no errors connent to db
            //Attempts to select a record where the entered information is matching
            $sql = "SELECT id, password, usertype, last_access, first_name, last_name
                    FROM users, agents
                    WHERE users.id=agents.user_id AND id ='".$loginID."' AND password = '".$password."'";
            //Runs the select query
            $result = pg_query($conn, $sql);
            //Checks how many records result from the query
            $records = pg_num_rows($result);
            
            //If the information entered results in a resulting record (ie. the username&password are legit) then do this stuff
            if ($records > 0)
            {           
                session_start();            
                $_SESSION['id'] = $loginID;     
                $_SESSION['last_access'] = pg_fetch_result($result, 0, 3);
                $_SESSION['usertype'] = pg_fetch_result($result, 0, 2);
                $_SESSION['firstname'] = pg_fetch_result($result, 0, 4);
                $_SESSION['lastname'] = pg_fetch_result($result, 0, 5);
                $_SESSION['message'] = "";
                $sql = "UPDATE users SET last_access = '". date("Y-m-d", time()) . "' WHERE id = '".$loginID."'";
                $results = pg_query($conn, $sql);
                
                if (!isset($_COOKIE["loginID"]))
                {               
                    setcookie("loginID", $loginID, time() + 60*60*24*30); // Expire in 30 days
                }
            
            
                //Updates the last access date
                $sql = "UPDATE users SET last_access = '" . date("Y-m-d",time()) . "' WHERE id = '" . $loginID . "'";               
                //Run the update query
                pg_query($conn,$sql); 
            
            
                echo $_SESSION['id'];   
                echo $_SESSION['last_access'];
                echo $_SESSION['usertype'];
                echo $_SESSION['firstname'];
                echo $_SESSION['lastname'];
            
                //REMOVE THIS LINE AFTER??????????????? --------------------Temp to redirect to welcome.php, need to create a session here to store user login.
                header('Location:./welcome.php');
            /*
                //Displays the login message
                $msg = "Welcome back " . pg_fetch_result($result,0,'id') ." ". 
                       "<br/>Our records show that your<br/>
                       email address is: " . pg_fetch_result($result,0,'email_address') .
                       "<br/>and you last accessed our system: " . pg_fetch_result($result,0,'last_access');
                       
            }
            else
            {
                //lets check to see if the username is real!
                $sql = "SELECT * FROM users WHERE id = '".$loginID."'";
                //Runs the select query
                $result = pg_query($conn, $sql);
                //Checks how many records result from the query
                $records = pg_num_rows($result);
                //If the information entered results in a resulting record (ie. the username&password are legit) then do this stuff
                if ($records > 0)
                {   
                    $error = "Login/password combination not found in the database";
                }
                else
                {
                $error = "Login/password not found in the database";
                $loginID = ""; //clears the sticky form if we cant find the desired id in the database
                //$password = ""; //no need to clear password, because it is not a sticky form
                }
            }
        }
    }
    else
    {
        //there were problems, concatentate the TRY AGAIN message
        $error .= "<br/>Please Try Again";      
    }
*/?>
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
    <script>
        $(document).ready(function () {
            $("#body").css("min-height", ($(window).height() - $("footer").height() - $("header").height() - $("#top").height()) - 50);

            /*
            // slide navigation 
            $('.slidePanel').click(function () {

                // set active item link
                //$('.slidePanel').removeClass('selected');
                //$(this).addClass('selected');

                // get current slide, for resizePanel() function
                var current = $(this);

                // scroll page to selected slide
                $('.slide-window').scrollTo($(this).attr('data-slide'), 600);

                //$(this).siblings('.toggleOptions').find('.toggleContent').slideUp(400);
                //slide(current);

                // cancel the link default behaviour
                return false;
            });
            */

            
            /*
            function slide(current) {
                // scroll page to selected slide
                $('.slide-window').scrollTo($(this).attr('data-slide'), 600);
            }
            */

            // toggle visibility of radio button (accordion) options
            $('ul.toggleOptions > li > input[type="radio"]').click(function () {
                // toggle (show/hide) clicked radio button option 
                $(this).siblings('.toggleContent').slideToggle(400);

                // hide other options
                $(this).parent().siblings().children('.toggleContent').slideUp(400);
            });


            // set height of content wrapper
            //var contentWrapperHeight = $(window).height() - 100;
            //$('.content-wrapper').css('height', contentWrapperHeight);

            /*
            // set max height of scrollbox div
            var scrollHeight = $(window).height() - 280;
            $('.scrollbox').css('max-height', scrollHeight);

            // set max height of paging div
            var pagingHeight = $('.slide-window').height() - 20;
            $('#paging-wrapper').css('max-height', pagingHeight);

            // set width of slide paging container
            var pagingWidth = $('.content-wrapper').width() - $('.slide-window').width() - 30;
            $('#paging-wrapper').css('width', pagingWidth);
            */

            /*
            function resizePanel() {
                //get the browser width and height
                width = $(window).width();
                height = $(window).height();
                //get the mask width: width * total of items
                mask_width = width * $('.slide').length;

                //set the dimension    
                $('.slide-window, .slide').css({ width: width, height: height });
                $('.slide-wrapper').css({ width: mask_width, height: height });

                //if the item is displayed incorrectly, set it to the corrent pos
                $('.slide-window').scrollTo($('.selected').attr('href'), 0);

            }*/


            /*
            // window resize events
            $(window).resize(function () {
                //call the resizePanel function
                //resizePanel();

                // set height of content wrapper
                //var contentWrapperHeight = $(window).height() - 100;
                //$('.content-wrapper').css('height', contentWrapperHeight);

                // set max height of scrollbox div
                var scrollHeight = $(window).height() - 280;
                $('.scrollbox').css('max-height', scrollHeight);

                // set max height of paging div
                var pagingHeight = $('.slide-window').height() - 20;
                $('#paging-wrapper').css('max-height', pagingHeight);

                // set width of slide paging container
                var pagingWidth = $('.content-wrapper').width() - $('.slide-window').width() - 30;
                $('#paging-wrapper').css('width', pagingWidth);
            });
            */

        });
    </script>
    <div id="top" class="login-bar"> 
    <form id="loginForm" action="" method="post">
        <input id="register "type="button" class="float-left button" value="Register" />
        <input id="go "type="button" class="float-right button" value=">" onclick=""/> 


        
        
        
        <input id="password" type="password" class="float-right textbox" value="" /> 
        <input id="login" type="text" class="float-right textbox" value="" /> 
      
        
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
                <li><a href="./register.php">Register</a></li>
                <!--<li><a id="login" href="./login.php">Login</a></li>-->
                
                 <!-- temp links for testing-->
                 <li><a href="./edit_menu_items.php">Edit Menu Items</a></li>
                  <li><a href="./edit_fish_Prices.php">Edit Fish Prices</a></li>
                  <li><a href="./edit_profile.php">Edit Profile</a></li>
                  <li><a href="./password_recovery.php">Recover Password</a></li>
                
            </ul>
        </nav>
        </header>