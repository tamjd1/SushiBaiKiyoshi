<?php
	//error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
    $login = '';
    $password = '';
    $message = '';
    $error = '';

    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {           
        $login = trim($_POST['login']);
        $password = trim($_POST['password']);
        
        if(!isset($login) || $login == '' || !isset($password) || $password == '')
        {
            $error = 'Must enter a login and password.';
        }
        else
        {
            $conn = pg_connect('host=localhost port=5432 dbname= user=postgres password=');
            $sql = "SELECT \"UserID\", \"UserType\" FROM \"tblUsers\" WHERE \"UserID\" = '$login' AND \"Password\" = '$password'";
            //echo $sql;
            $result = pg_query($conn, $sql);
            $record = pg_num_rows($result);
            
            if ($record > 0)
            {
                session_start();
                $_SESSION['user'] = pg_fetch_result($result, 0, 0);
                $_SESSION['user_type'] = pg_fetch_result($result, 0, 1);
                $_SESSION['cart'] = array();
            }
            else 
            {
                $error = 'Login information not found.';
            }   
        }
        
        if ($error != '')
        {
            $message = $error;
        }
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
    
    <div id="top" class="login-bar" style="text-align:center"> 
        <form id="loginForm" action="" method="post">
            <?php
            
            if (!isset($_SESSION)) {
                //echo "<input id='register' type='button' class='float-left button' value='Register' onclick='' />";
                echo "<input id='go' type='button' class='float-right button' value='Login' onclick='submit()'/>";
                echo "<input id='password' name='password' type='password' class='float-right textbox' value='$password' />"; 
                echo "<input id='login' name='login' type='text' class='float-right textbox' value='$login' />";
            }
            else {
                echo "<p style='margin:0; text-align:center'>Welcome, $login</p>"; 
                echo "<input id='go' type='button' style='position:relative; bottom:20px;' class='float-right button' value='Logout' onclick='logout()'/>";
            }

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
            
                if (!isset($_SESSION))
                {
                    echo "<li><a href='./register.php'>Register</a></li>";
                }                              
                else if (isset($_SESSION) && $_SESSION['user_type'] == 'c')
                {
                    echo "<li><a href='./edit_profile.php'>Edit Account</a></li>";
                    echo "<li><a href='./password_recovery.php'>Recover Password</a></li>";
                }
                else if (isset($_SESSION) && $_SESSION['user_type'] == 'a')
                {
                    echo "<li><a href='./admin.php'>Admin Pages</a></li>";
                }
                
                ?>
            </ul>
        </nav>
    </header>
        
    <div id="messageArea" style="text-align:center; width:100%; color:red;">
        <p id="message"><?php echo $message; ?></p>
    </div>
        