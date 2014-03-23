<?php
    $file = "fish_prices_trend_report.php";
    $title = "Sushi Bai Kiyoshi - Fish Prices Trend Report";
    $banner = "Sushi Bai Kiyoshi - Fish Prices Trend Report";
    $description = "This page generates a report of prices of different types of fish over a period of time";
    $date = "22/03/2014";
    require 'header.php';
?>

<section id="MainContent">            

    <div style="max-width:100%; max-height:100%; min-width:100px; min-height:100px; margin: 0 auto;" id="myCanvas"></div>
  
</section>
<style>

    .axis text {
        font: 10px sans-serif;
    }

    .axis path,
    .axis line {
        fill: none;
        stroke: #000;
        shape-rendering: crispEdges;
    }
  
</style>
  
<script>
    $(document).ready(function () {    
        var fishData, MAX_CANVAS_WIDTH, MAX_CANVAS_HEIGHT, CENTRE_X, CENTRE_Y, svg, canvas, MAX_PRICE;
        var yScale = d3.scale.linear();        
        var xScale = d3.scale.linear();
        
        $.getJSON('http://localhost/SushiBaiKiyoshi/json.php', function(data) {
            
            fishData = data;
            console.log(fishData);
            
            $("#myCanvas").height(($(window).height() - $("footer").height() - $("header").height()));
            $("#myCanvas").width($("#body").width() - 50); 
            $("#myCanvas").css("margin-bottom", 20); 
        
            //var GRID_PADDING = 25 / 2;                  //size of the squares in the grid        
            //var CELL_PADDING = GRID_PADDING / 2;    //cell padding is half less than the grid padding
            MAX_CANVAS_WIDTH = $("#myCanvas").width();             //max width of canvas
            MAX_CANVAS_HEIGHT = $("#myCanvas").height();            //max height of canvas
            CENTRE_X = MAX_CANVAS_WIDTH / 2;
            CENTRE_Y = MAX_CANVAS_HEIGHT / 2;
         
             /* CREATE CANVAS */
            svg = d3.select("#myCanvas")            //Select the div tag with id "myCanvas"
                        .append("svg")                      //Add an svg tag to the selected div tag
                        .attr("width", MAX_CANVAS_WIDTH)    //Set the width of the canvas/grid to MAX_CANVAS_WIDTH
                        .attr("height", MAX_CANVAS_HEIGHT) //Set the height of the canvas/grid to MAX_CANVAS_HEIGHT
                        .style("border", "1px solid black");
            canvas = svg.append("g")
                        .attr("transform", "translate("+CENTRE_X+","+CENTRE_Y+")");
            setScales();
            drawAxes();
                     
            /**
            This function draws x and y axes to represent the height and length of the walls and the items within the walls
            */
            function drawAxes() { 

            //bottom axis
                var x = d3.time.scale()
                    .domain([new Date(2000, 0, 1), new Date(2000, 11, 31)])
                    .range([0, xScale(12)]);

                var xAxis = d3.svg.axis()
                    .scale(x)
                    .orient("bottom")
                    .ticks(d3.time.months)
                    .tickSize(16, 0)
                    .tickFormat(d3.time.format("%B"));

                canvas.append("g")
                    .attr("class", "x axis")
                    .attr("transform", "translate(" + (-(parseFloat(CENTRE_X)) + parseFloat(60)) + "," + (parseFloat(CENTRE_Y) - parseFloat(50)) + ")")
                    .call(xAxis)
                  .selectAll(".tick text")
                    .style("text-anchor", "start")
                    .attr("x", 6)
                    .attr("y", 6);
            //end of bottom axis
            
                var priceDomain = new Array();
                for (var i = MAX_PRICE; i >= 0; i-=5) {
                    priceDomain.push(i);
                }
            
                //left (y) axis representing the start height
                var leftScale = d3.scale.ordinal()
                    .domain(priceDomain)
                    .rangePoints([0, yScale(d3.max(priceDomain))]);

                var leftAxis = d3.svg.axis()
                    .scale(leftScale)
                    .orient("left");

                canvas.append("g")
                    .attr("transform", "translate(" + (-(parseFloat(CENTRE_X)) + parseFloat(60)) + "," + (-(parseFloat(CENTRE_Y) - parseFloat(50))) + ")")
                    .attr("class", "x axis")
                    .call(leftAxis);
                //end of left (y) axis
            }
            
            function setScales() {
                yScale.domain([0 , MAX_PRICE])
                     .range([0 , MAX_CANVAS_HEIGHT - 100]);
                xScale.domain([0 , 12])
                     .range([0 , MAX_CANVAS_WIDTH - 100]);
            }
            
            function getMaxDate() {
                var maxPrice = 0;
                for(var i = 0; i < fishData.length; i++) {
                    if(fishData[i].Price > maxPrice) 
                        maxPrice = fishData[i].Price;
                }
                return maxPrice;
            }
            
            function getMaxPrice() {
                var maxPrice = 0;
                for(var i = 0; i < fishData.length; i++) {
                    if(fishData[i].Price > maxPrice) 
                        maxPrice = fishData[i].Price;
                }
                return (Math.round(maxPrice / 10) * 10) + 10;
            }
        });
    }); 
</script>

<?php include 'footer.php'; ?>