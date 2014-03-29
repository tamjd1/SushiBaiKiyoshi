<?php
$file = "index.php";
$title = "Sushi Bai Kiyoshi - Home Page";
$banner = "Sushi Bai Kiyoshi - Home Page";
$description = "This page displays the promotions and general information about the business Sushi Bai Kiyoshi";
$date = "05/03/2014";

require 'header.php';
?>
        <section id="MainContent">  
            <p class="message">
<?php echo  $_SESSION['message']; ?></p>
            <script>
                
                /**
                greeting
                This function sets the appropriate greeting on the home page depending on the time of day.
                @since 20/01/2014
                */
                function greeting() {
                    var date = new Date(); //get the current date time
                    var hours = date.getHours(); //get the current hour from the date

                    switch (true) {
                        case (hours < 6): //earlier than 6 AM, later than midnight
                            $("#greeting").text("Good Night!");
                            break;
                        case (hours < 12): //earlier than 12 PM (noon), later than 6 AM
                            $("#greeting").text("Good Morning!");
                            break;
                        case (hours < 18): //earlier than 6 PM, later than noon
                            $("#greeting").text("Good Afternoon!");
                            break;
                        case (hours <= 23): //earlier than 11 PM, later than 6 PM
                            $("#greeting").text("Good Evening!");
                            break;
                    }
                }
            
                $(function () {
                    var imgsarray = [
                            './images/banner (1).jpg',
                            './images/banner (2).jpg',
                            './images/banner (3).jpg',
                            './images/banner (4).jpg',
                            './images/banner (5).jpg',
                            './images/banner (6).jpg'
                            ];

                    var counter = imgsarray.length;
                    var $SlideShow = $('img[id$=SlideShow]');

                    $SlideShow.attr('src', imgsarray[counter - 1]);
                    setInterval(Slider, 5000);
                    function Slider() {
                        $SlideShow.fadeOut("slow", function () {
                            $(this).attr('src', imgsarray[(imgsarray.length++) % counter])
                            .fadeIn("slow");
                        });
                    }

                    $("#banner").width(imgsarray[0].clienWidth);
                    $("#banner").height(imgsarray[0].clienHeight);
                    //$("#banner").addClass("float-right");

                });
                $(document).ready(function() {
                    greeting();
                    //$("#favourites").click();
                });
            </script>
            
            <div id="banner">
                <img id="SlideShow" width="701px" src="banner (1).jpg" alt="banner" />
            </div>
            <h1 id="greeting" class="float-center"></h1>
            <p> 
                Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat.
            </p>

                
            
            
        </section>
            
<?php include 'footer.php'; ?>