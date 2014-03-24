<?php
    $file = "fish_prices_trend_report.php";
    $title = "Sushi Bai Kiyoshi - Fish Prices Trend Report";
    $banner = "Sushi Bai Kiyoshi - Fish Prices Trend Report";
    $description = "This page generates a report of prices of different types of fish over a period of time";
    $date = "22/03/2014";
    require 'header.php';
?>

<?php

$fish_prices_trend = array
     (
         array('Type'=>"Salmon",'Date'=>'01-12-2000','Price'=>15.5),
         array('Type'=>"Tuna",'Date'=>'01-15-2000','Price'=>17.9),
         array('Type'=>"Swordfish",'Date'=>'01-13-2000','Price'=>22.0),
         array('Type'=>"Carp",'Date'=>'01-12-2000','Price'=>7.75),
         array('Type'=>"Salmon",'Date'=>'02-10-2000','Price'=>17.5),
         array('Type'=>"Tuna",'Date'=>'02-05-2000','Price'=>16.9),
         array('Type'=>"Swordfish",'Date'=>'02-13-2000','Price'=>21.0),
         array('Type'=>"Carp",'Date'=>'02-12-2000','Price'=>12.75),
         array('Type'=>"Salmon",'Date'=>'03-02-2000','Price'=>15.5),
         array('Type'=>"Tuna",'Date'=>'03-16-2000','Price'=>17.9),
         array('Type'=>"Swordfish",'Date'=>'03-13-2000','Price'=>22.0),
         array('Type'=>"Carp",'Date'=>'03-22-2000','Price'=>7.75),
         array('Type'=>"Salmon",'Date'=>'04-12-2000','Price'=>15.5),
         array('Type'=>"Tuna",'Date'=>'04-12-2000','Price'=>17.9),
         array('Type'=>"Swordfish",'Date'=>'04-23-2000','Price'=>19.0),
         array('Type'=>"Carp",'Date'=>'04-25-2000','Price'=>10.75),
         array('Type'=>"Salmon",'Date'=>'05-29-2000','Price'=>11.5),
         array('Type'=>"Tuna",'Date'=>'05-15-2000','Price'=>17.9),
         array('Type'=>"Swordfish",'Date'=>'05-03-2000','Price'=>21.0),
         array('Type'=>"Carp",'Date'=>'05-22-2000','Price'=>7.75),
         array('Type'=>"Salmon",'Date'=>'06-16-2000','Price'=>16.5),
         array('Type'=>"Tuna",'Date'=>'06-15-2000','Price'=>14.9),
         array('Type'=>"Swordfish",'Date'=>'06-19-2000','Price'=>20.0),
         array('Type'=>"Carp",'Date'=>'06-20-2000','Price'=>15.75),         
         array('Type'=>"Salmon",'Date'=>'07-12-2000','Price'=>13.5),
         array('Type'=>"Tuna",'Date'=>'07-15-2000','Price'=>13.9),
         array('Type'=>"Swordfish",'Date'=>'07-13-2000','Price'=>22.0),
         array('Type'=>"Carp",'Date'=>'07-12-2000','Price'=>17.75)
     );

?>


<section id="MainContent">            

    <div style="display:inline">
        <div class="float-left" style="max-width:85%; max-height:100%; min-width:100px; min-height:100px; margin-left:20px" id="myCanvas"></div>
        <div class="float-right" style="max-width:15%; max-height:100%; min-width:100px; min-height:100px;margin-right:20px" id="checkboxes">
        Select year:
        <select>
          <option value="1998">1998</option>
          <option value="1999">1999</option>
          <option value="2000">2000</option>
          <option value="2001">2001</option>
        </select><br/>
        </div>
    </div>
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

    /**
    reference: https://stackoverflow.com/questions/11246758/how-to-get-unique-values-in-a-array
    */
    Array.prototype.contains = function(v) {
        for(var i = 0; i < this.length; i++) {
            if(this[i] === v) return true;
        }
        return false;
    };
    /**
    reference: https://stackoverflow.com/questions/11246758/how-to-get-unique-values-in-a-array
    */
    Array.prototype.unique = function() {
        var arr = [];
        for(var i = 0; i < this.length; i++) {
            if(!arr.contains(this[i])) {
                arr.push(this[i]);
            }
        }
        return arr; 
    }

    var parseDate = d3.time.format("%m-%d-%Y").parse;
    var fishData, MAX_CANVAS_WIDTH, MAX_CANVAS_HEIGHT, CENTRE_X, CENTRE_Y, svg, canvas, graph, MAX_PRICE, timeScale;
    var yScale = d3.scale.linear();        
    var xScale = d3.scale.linear();
    var fishTypes = new Array();
    var fishTypesUnique = new Array();
    var dates = new Array();
    var prices = new Array();
    var priceDomain = new Array();
    
    fishData = <?php print json_encode($fish_prices_trend); ?>;
    console.log(fishData);
    
    for(var i = 0; i < fishData.length; i++) {
        fishTypes.push(fishData[i].Type); //
        dates.push(fishData[i].Date);
        prices.push(fishData[i].Price);
    }
    
    MAX_PRICE = getMaxPrice(); //get max price
    for (var i = MAX_PRICE; i >= 0; i-=5) {
        priceDomain.push(i); //set price domain at $5 intervals
    }
    
    fishTypesUnique = fishTypes.unique(); //get unique values for fish types and add checkboxes 
    for (var i = 0; i < fishTypesUnique.length; i++) { //add checkbox for each fish type
        $('#checkboxes').append('<input type="checkbox" value='+fishTypesUnique[i]+' onchange="plotLineGraph(this.checked,this.value)"/>'+fishTypesUnique[i]+'<br />');
    }
    
    var year = parseDate(fishData[0].Date).getFullYear();
    var daysInAYear = (((year % 4 == 0) && (year % 100 != 0)) || (year % 400 == 0)) ? 366 : 365;

    /**
    This function creates the <svg> canvas on which line graph will be drawn
    */
    function createCanvas() {
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
        graph = canvas.append("g")
            .attr("transform", "translate(" + (-(parseFloat(CENTRE_X)) + parseFloat(60)) + "," + (parseFloat(CENTRE_Y) - parseFloat(50)) + ")");
    }
    
    /**
    This function draws x and y axes to represent the height and length of the walls and the items within the walls
    */
    function drawAxes() { 

    //bottom axis
        timeScale = d3.time.scale()
            .domain([new Date(year, 0, 1), new Date(year, 11, 31)])
            .range([0, xScale(daysInAYear)]); 

        var xAxis = d3.svg.axis()
            .scale(timeScale)
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
    
    /**
    This function draws the graphing area including the gridlines
    */
    function drawGraph(){ 
        //graph area
        drawRect(graph, xScale(daysInAYear), yScale(d3.max(priceDomain)), 0, -yScale(d3.max(priceDomain)), "white", 1.0, "white");
        var pt1, pt2;
        
        //horizontal grid lines
        for (var i = yScale(5); i < yScale(d3.max(priceDomain)) - yScale(5); i+=yScale(5)) {
            pt1 = { "x": 0, "y": -i }; //line left coordinates
            pt2 = { "x": xScale(daysInAYear), "y": -i }; //line left coordinates
            drawLine(pt1, pt2, graph, 1, "lightgray"); 
        }
        
        var leapYear = daysInAYear === 365 ? 0 : 1;
        
        var jan = 31;
        var feb = jan + 28 + leapYear;
        var mar = feb + 31;
        var apr = mar + 30;
        var may = apr + 31;
        var jun = may + 30;
        var jul = jun + 31;
        var aug = jul + 31;
        var sep = aug + 30;
        var oct = sep + 31;
        var nov = oct + 30;
        
        ///vertical grid lines
            //january
            pt1 = { "x": xScale(jan), "y": 0 }; //line left coordinates
            pt2 = { "x": xScale(jan), "y": -yScale(d3.max(priceDomain)) }; //line left coordinates
            drawLine(pt1, pt2, graph, 1, "lightgray"); 
            //february
            pt1 = { "x": xScale(feb), "y": 0 }; //line left coordinates
            pt2 = { "x": xScale(feb), "y": -yScale(d3.max(priceDomain)) }; //line left coordinates
            drawLine(pt1, pt2, graph, 1, "lightgray"); 
            //march
            pt1 = { "x": xScale(mar), "y": 0 }; //line left coordinates
            pt2 = { "x": xScale(mar), "y": -yScale(d3.max(priceDomain)) }; //line left coordinates
            drawLine(pt1, pt2, graph, 1, "lightgray"); 
            //april
            pt1 = { "x": xScale(apr), "y": 0 }; //line left coordinates
            pt2 = { "x": xScale(apr), "y": -yScale(d3.max(priceDomain)) }; //line left coordinates
            drawLine(pt1, pt2, graph, 1, "lightgray"); 
            //may
            pt1 = { "x": xScale(may), "y": 0 }; //line left coordinates
            pt2 = { "x": xScale(may), "y": -yScale(d3.max(priceDomain)) }; //line left coordinates
            drawLine(pt1, pt2, graph, 1, "lightgray"); 
            //june
            pt1 = { "x": xScale(jun), "y": 0 }; //line left coordinates
            pt2 = { "x": xScale(jun), "y": -yScale(d3.max(priceDomain)) }; //line left coordinates
            drawLine(pt1, pt2, graph, 1, "lightgray"); 
            //july
            pt1 = { "x": xScale(jul), "y": 0 }; //line left coordinates
            pt2 = { "x": xScale(jul), "y": -yScale(d3.max(priceDomain)) }; //line left coordinates
            drawLine(pt1, pt2, graph, 1, "lightgray"); 
            //august
            pt1 = { "x": xScale(aug), "y": 0 }; //line left coordinates
            pt2 = { "x": xScale(aug), "y": -yScale(d3.max(priceDomain)) }; //line left coordinates
            drawLine(pt1, pt2, graph, 1, "lightgray"); 
            //september
            pt1 = { "x": xScale(sep), "y": 0 }; //line left coordinates
            pt2 = { "x": xScale(sep), "y": -yScale(d3.max(priceDomain)) }; //line left coordinates
            drawLine(pt1, pt2, graph, 1, "lightgray"); 
            //october
            pt1 = { "x": xScale(oct), "y": 0 }; //line left coordinates
            pt2 = { "x": xScale(oct), "y": -yScale(d3.max(priceDomain)) }; //line left coordinates
            drawLine(pt1, pt2, graph, 1, "lightgray"); 
            //november
            pt1 = { "x": xScale(nov), "y": 0 }; //line left coordinates
            pt2 = { "x": xScale(nov), "y": -yScale(d3.max(priceDomain)) }; //line left coordinates
            drawLine(pt1, pt2, graph, 1, "lightgray"); 
        ///end of vertical grid lines        
    }
    
    /**
    This function sets the scale for x and y axis to optimally draw the graph regardless of the size of the screen
    */
    function setScales() {
        yScale.domain([0 , MAX_PRICE])
             .range([0 , MAX_CANVAS_HEIGHT - 100]);
        xScale.domain([0 , daysInAYear]) 
             .range([0 , MAX_CANVAS_WIDTH - 100]);
    }
    
    /**
    This function determines and returns the max date value from the JSON array.
    */
    function getMaxDate() {
        var maxPrice = 0;
        for(var i = 0; i < fishData.length; i++) {
            if(fishData[i].Price > maxPrice) 
                maxPrice = fishData[i].Price;
        }
        return maxPrice;
    }
    
    /**
    This function determines and returns the max price value from the JSON array.
    */
    function getMaxPrice() {
        var maxPrice = 0;
        for(var i = 0; i < fishData.length; i++) {
            if(fishData[i].Price > maxPrice) 
                maxPrice = fishData[i].Price;
        }
        return (Math.round(maxPrice / 10) * 10) + 10;
    }
    
    
    function plotLineGraph(checked, name) {
        if(checked) {
            var points = new Array();
            for (var i = 0; i < fishData.length; i++) {
                if (fishData[i].Type === name) {
                    points.push({"x": timeScale(parseDate(fishData[i].Date)), "y": (-yScale(fishData[i].Price))});
                }
            }
            console.log(points);    
            var gLine = graph.append("g");
            drawPolyLine(gLine, points, "black", 1, name, name);
        }    
        else {
            if ($("#"+name))
                d3.selectAll("#"+name).remove(); //remove existing walls
        }
    }
    
    
    /**
    This function draws a polygon on the canvas with the given data points as coordinates and sets it id to the given id
    @param pt1 - x and y coordinates of starting point
    @param pt2 - x and y coordinates of ending point
    @param g - the <g> element on which to append the line
    @param strokeWidth - width of the line drawn
    @param stroke - colour of the line drawn
    @param opacity - transparency of the line
    */
    function drawLine(pt1, pt2, g, strokeWidth, stroke, opacity) {

        strokeWidth = typeof strokeWidth !== 'undefined' ? strokeWidth : 1;
        stroke = typeof stroke !== 'undefined' ? stroke : "black";
        opacity = typeof opacity !== 'undefined' ? opacity : 1.0;

        var poly = g.append("line")
                 .attr("x1", pt1.x)
                 .attr("y1", pt1.y)
                 .attr("x2", pt2.x)
                 .attr("y2", pt2.y)
                 .attr("stroke", stroke)
                 .attr("stroke-width", strokeWidth)
                 .attr("stroke-opacity", opacity);

        //.attr("onmouseover", "$(\"#wall\").attr(\"fill\", \"#F3F3F3\");")
        //.attr("onmouseout", "$(\"#wall\").attr(\"fill\", \"white\");");
        //.attr("onclick", "$(\"#MainContent_txtWidth" + wallIndex + "\").focus();"); //put focus on the first editable field for the wall
    }

    /**
    This function draws a recangle on the canvas with the given data points as coordinates and sets it id to the given id
    @param g - the <g> element on which to append the rect
    @param width - rectangle width
    @param height - rectangle height
    @param x - starting x coordinate
    @param y - starting y coordinate
    @param colour - fill colour (default: white)
    @param opacity - fill opacity (default: 1.0)
    @param stroke - outline stroke colour (default: black)
    */    
    function drawRect(g, width, height, x, y, colour, opacity, stroke) {
    
        colour = typeof colour !== 'undefined' ? colour : "white";
        opacity = typeof opacity !== 'undefined' ? opacity : 1.0;
        stroke = typeof stroke !== 'undefined' ? stroke : "black";

        var rect = g.append('rect')
            .attr('id', 'graph')
            .attr('width', width)
            .attr('height', height)
            .attr('x', x)
            .attr('y', y)
            .style('fill', colour)
            .style('fill-opacity', opacity)
            .attr('stroke', stroke);
            
        //.attr("onmouseover", "$(\"#wall\").attr(\"fill\", \"#F3F3F3\");")
        //.attr("onmouseout", "$(\"#wall\").attr(\"fill\", \"white\");");
        //.attr("onclick", "alert"); //put focus on the first editable field for the wall
    }

    /**
    This function draws a polygon on the canvas with the given data points as coordinates and sets it id to the given id
    @param g - the <g> element on which to append the polygon
    @param points - coordinates of a given polygon
    @param stroke - line colour (default: black)
    @param stroke-width - line width (default: 1)
    @param id - to be given to the polygon object (default: "")
    @param title - to give a name to the shape drawn (default: "")
    */
    function drawPolyLine(g, points, stroke, strokeWidth, id, title) {

        stroke = typeof stroke !== 'undefined' ? stroke : "black";
        strokeWidth = typeof strokeWidth !== 'undefined' ? strokeWidth : 1;
        id = typeof id !== 'undefined' ? id : "";
        title = typeof title !== 'undefined' ? title : "";
    
        var poly = g.selectAll("polyline")
                 .data([points])
                 .enter().append("polyline")
                 .attr("id", id)
                 .attr("title", title)
                     .attr("points", function (d) { 
                         return d.map(function (d) { 
                             return [d.x, d.y].join(",");
                         }).join(" ");
                     })
                 .attr("fill", "none")
                 .attr("stroke", stroke)
                 .attr("stroke-width", strokeWidth);
                 //.attr("onmouseover", "$(\"#wall\").attr(\"fill\", \"#F3F3F3\");")
                 //.attr("onmouseout", "$(\"#wall\").attr(\"fill\", \"white\");");
                 //.attr("onclick", "alert"); //put focus on the first editable field for the wall
    }
    
    $(document).ready(function () {    
        createCanvas();
        setScales();
        drawAxes();
        drawGraph();
    }); 
   
</script>

<?php include 'footer.php'; ?>