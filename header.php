<?php 
/*
	error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);

	ob_start();

	require ('./includes/constants.php');
	require ('./includes/db.php');
	require ('./includes/util.php');

	if(session_id() == "")
	{
		session_start();
	}
	
	$message = "";
	
	if(isset($_SESSION['message']))
	{
		$message = $_SESSION['message'];
		unset($_SESSION['message']);
	}
	
	if (isset($page_specific_css))
	{
		$count = count($page_specific_css);
		for ($i = 0; $i < $count; $i++)
		{
			echo "<link rel='syltesheet' type='text/css' href='".$page_specific_css[$i]."' />";
		}
	}
	
	if (isset($page_specific_js))
	{
		$count = 0;
		$count = count($page_specific_js);
		for ($i = 0; $i < $count; $i++)
		{
			echo "<script src='".$page_specific_js[$i]."' type='text/javascript'></script>";
		}
	}
*/
?>

<?php
	if(session_id() == "")
	{
		session_start();
	}
?>
    
<?php
$login = "";
$password = "";

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
  $login = test_input($_POST["login"]);
  $password = test_input($_POST["password"]);
  echo "ssssssssssssss";
}

// edits for input that could effect the database
function test_input($data)
{
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}


    // if($_POST['login'] == "")
    // {
        // $errorMessage += ("Login is empty!<br>");
     
    // }
    
    // if(empty($_POST['password']))
    // {
        // $errorMessage += ("Password is empty!<br>");
    // }
     
    //$username = trim($_POST['login']);
    //$password = trim($_POST['password']);

    //session_start();


   //echo $errorMessage;   
?>

 <?PHP

// session_start();

// if (!(isset($_SESSION['login']) && $_SESSION['login'] != '')) {

// header ("Location: index.php");

// }

// ?>
<!DOCTYPE html>

<html lang="en">
<head runat="server">
    <meta charset="utf-8" />
    <link rel="stylesheet" type="text/css" href="./css/site.css" />
    <link rel="stylesheet" type="text/css" href="./css/styles.css" />
    <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
    <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
    <script src="./js/d3.js"></script>
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
        <input id="password" type="password" class="float-right textbox" value="password" /> 
        <input id="login" type="text" class="float-right textbox" value="Username" />
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
                 <!-- <li><a href="./edit_menu_items.php">Edit Menu Items</a></li>-->
                 <!-- <li><a href="./edit_fish_Prices.php">Edit Fish Prices</a></li>-->
                 <!-- <li><a href="./edit_profile.php">Edit Profile</a></li>-->
                 <!-- <li><a href="./password_recovery.php">Recover Password</a></li>-->
                
            </ul>
        </nav>
        </header>