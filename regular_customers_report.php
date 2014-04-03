<?php
$file = "regular_customers_report.php";
$title = "Sushi Bai Kiyoshi - Regular Customers";
$banner = "Sushi Bai Kiyoshi - Regular Customers";
$description = "This page generates and displays a report of regular customers";
$date = "25/03/2014";

require 'header.php';


$customers = array();
$cancels = array();

$conn = db_connect();
$sql = "SELECT \"tblUsers\".\"UserID\", \"tblUsers\".\"UserFirst\", \"tblUsers\".\"UserLast\", COUNT(\"tblInvoices\".\"InvoiceID\")
  FROM \"tblUsers\" JOIN \"tblInvoices\" ON \"tblUsers\".\"UserID\" = \"tblInvoices\".\"UserID\"
  GROUP BY \"tblUsers\".\"UserID\", \"tblUsers\".\"UserFirst\", \"tblUsers\".\"UserLast\"
  ORDER BY COUNT(\"tblInvoices\".\"InvoiceID\") DESC LIMIT 10";
$result = pg_query($conn, $sql);

$i = 0;
while ($row = pg_fetch_row($result))
{
    $sql = "SELECT COUNT(\"InvoiceStatus\") FROM \"tblInvoices\" WHERE \"UserID\" = '".$row[0]."' AND \"InvoiceStatus\" = 'x'";
    $result2 = pg_query($conn, $sql);
    $row2 = pg_fetch_row($result2);
    $customers[$i] = array('UserID'=>$row[0],'FullName'=>$row[1].' '.$row[2],'FirstName'=>$row[1],'LastName'=>$row[2],'OrderCount'=>$row[3], 'CancelCount'=>$row2[0]);
    $i++;
}

?>

<style>
    .names text {
        font: 14px sans-serif;
    }
    .names path,
    .names line {
        fill: none;
        stroke: #000;
        shape-rendering: crispEdges;
    }
    .axis text {
        font: 14px sans-serif;
    }
    .axis path,
    .axis line {
        fill: none;
        stroke: #000;
        shape-rendering: crispEdges;
    }
</style>

<section class="center">
    <h1 class="center"  style="display:inline-block; padding-left:20px; padding-top:20px;">Regular Customers Report</h1> 
    <div class="float-right" style="display:inline-block; padding-right:20px; padding-top:20px;">
        <div style="background:#2d578b; display:inline-block;"><input type="checkbox" name="legend" value="invoices" disabled="disabled"></div>Total Invoice Count<br>
        <div style="background:red; display:inline-block;"><input type="checkbox" name="legend" value="cancels" disabled="disabled"></div>Cancelled Invoice Count
    </div>   
    <div style="max-width:95%; max-height:100%; min-width:100px; min-height:100px; margin-left:auto; margin-right:auto; margin-top:20px" id="myCanvas"></div>    
</section>


<script>
    var customers, MAX_CANVAS_WIDTH, MAX_CANVAS_HEIGHT, CENTRE_X, CENTRE_Y, svg, canvas, graph, MAX_ORDER;
    var yScale = d3.scale.linear();        
    var xScale = d3.scale.linear();
    var names = new Array();
    var orders = new Array();
    var orderDomain = new Array();
    
    customers = <?php print json_encode($customers); ?>;
    console.log(customers);
    
    names.push(" ");
    for(var i = 0; i < customers.length; i++) {
        names.push(customers[i].FullName); //
        orders.push(parseInt(customers[i].OrderCount));
    }
    //names.push(" ");
    
    MAX_ORDER = parseFloat(d3.max(orders)) + parseFloat(5); //get max price
    for (var i = MAX_ORDER; i >= 0; i--) {
        orderDomain.push(i); //set price domain at $5 intervals
    }
    
    
    /**
    This function creates the <svg> canvas on which line graph will be drawn
    */
    function createCanvas() {
        $("#myCanvas").height(($(window).height() - $("footer").height() - $("header").height()));
        $("#myCanvas").width($(window).width()); 
        $("#myCanvas").css("margin-bottom", 20); 
        
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
            .attr("transform", "translate(" + (-(parseFloat(CENTRE_X)) + parseFloat(60)) + "," + (parseFloat(CENTRE_Y) - parseFloat(60)) + ")");
    }

    /**
    This function draws x and y axes to represent the height and length of the walls and the items within the walls
    */
    function drawAxes() { 

    //bottom axis
        //bottomScale = d3.scale.ordinal()
        //    .domain(names)
        //    .rangePoints([0, xScale(names.length)]); 

        //var xAxis = d3.svg.axis()
        //    .scale(bottomScale)
        //    .orient("bottom");
            //.ticks(d3.time.months)
            //.tickSize(16, 0)
            //.tickFormat(d3.time.format("%B"));

        //canvas.append("g")
        //    .attr("class", "x names")
        //    .attr("transform", "translate(" + (-(parseFloat(CENTRE_X)) + parseFloat(60)) + "," + (parseFloat(CENTRE_Y) - parseFloat(60)) + ")")
        //    .call(xAxis)
        //    .selectAll(".tick text")
        //    .style("cursor", "pointer")
        //    .on("click", function(d){ document.location.href = "http://localhost/SushiBaiKiyoshi/index.php?" + d; })
        //    .style("text-anchor", "end")
        //    .attr("transform", function(d) { return "rotate(-25)" })
        //    .attr("dx", "-.8em")
        //    .attr("dy", ".15em")
        //    .attr("x", -16)
        //    .attr("y", 0);
    //end of bottom axis

        //left (y) axis representing the start height
        var leftScale = d3.scale.ordinal()
            .domain(orderDomain)
            .rangePoints([0, yScale(d3.max(orderDomain))]);

        var leftAxis = d3.svg.axis()
            .scale(leftScale)
            .orient("left");

        canvas.append("g")
            .attr("transform", "translate(" + (-(parseFloat(CENTRE_X)) + parseFloat(60)) + "," + (-(parseFloat(CENTRE_Y) - parseFloat(40))) + ")")
            .attr("class", "x axis")
            .call(leftAxis);
        //end of left (y) axis
    }    
    
    /**
    This function sets the scale for x and y axis to optimally draw the graph regardless of the size of the screen
    */
    function setScales() {
        yScale.domain([0 , MAX_ORDER])
             .range([0 , MAX_CANVAS_HEIGHT - 100]);
        xScale.domain([0 , names.length]) 
             .range([0 , MAX_CANVAS_WIDTH - 100]);
    }
    
    /**
    This function draws the graphing area including the gridlines
    */
    function drawGraph(){ 
        //graph area
        drawRect(graph, xScale(names.length), yScale(d3.max(orderDomain)), 0, -yScale(d3.max(orderDomain)), "white", 1.0, "white");
        var pt1, pt2;
        
        //horizontal grid lines
        for (var i = yScale(0); i < yScale(d3.max(orderDomain)); i+=yScale(1)) {
            pt1 = { "x": 0, "y": -i }; //line left coordinates
            pt2 = { "x": xScale(names.length), "y": -i }; //line left coordinates
            drawLine(pt1, pt2, graph, 1, "lightgray"); 
        }
    }
   
   
    function drawBars() {
          var g = graph.append("g");
          g.selectAll("rect")
              .data(customers)
              .enter()
              .append("svg:rect")
              .attr("x", function(d, i) { return xScale(parseFloat(i)+parseFloat(1)); })
              .attr("y", function(d) { return -yScale(d.OrderCount); })
              .attr("height", function(d) { return yScale(d.OrderCount); })
              .attr("width", xScale(0.5))
              .style("cursor", "pointer")
              .on("click", function(d){ document.location.href = "./customer_favourites_report.php?id=" + d.UserID; })
              .attr("fill", "#2d578b");
           
           var g2 = graph.append("g");   
           g2.selectAll("rect")
              .data(customers)
              .enter()
              .append("svg:rect")
              .attr("x", function(d, i) { return xScale(parseFloat(i)+parseFloat(1)); })
              .attr("y", function(d) { return -yScale(d.CancelCount); })
              .attr("height", function(d) { return yScale(d.CancelCount); })
              .attr("width", xScale(0.5))
              .style("cursor", "pointer")
              .on("click", function(d){ document.location.href = "./customer_favourites_report.php?id=" + d.UserID; })
              .attr("fill", "red");
          
          g.selectAll("text")
              .data(customers)
              .enter()
              .append("svg:text")
              .attr("x", function(d, i) { return xScale(parseFloat(i)+parseFloat(1)) + xScale(0.5); })
              .attr("y", function(d) { return -yScale(d.OrderCount); })
              .attr("dx", -(xScale(0.5)/2))
              .attr("dy", "1.2em")
              .attr("text-anchor", "middle")
              .text(function(d) { return d.OrderCount;})
              .attr("fill", "white");
          
          g2.selectAll("text")
              .data(customers)
              .enter()
              .append("svg:text")
              .attr("x", function(d, i) { return xScale(parseFloat(i)+parseFloat(1)) + xScale(0.5); })
              .attr("y", function(d) { return -yScale(d.CancelCount); })
              .attr("dx", -(xScale(0.5)/2))
              .attr("dy", "1.2em")
              .attr("text-anchor", "middle")
              .text(function(d) { return (d.CancelCount == 0) ? "" : d.CancelCount;})
              .attr("fill", "white");
              
          g.selectAll("text.yAxis")
              .data(customers)
              .enter().append("svg:text")
              .attr("x", function(d, i) { return xScale(parseFloat(i)+parseFloat(1)) + xScale(0.5); })
              .attr("y", 5)
              .attr("dx", -(xScale(0.5)/2))
              .attr("text-anchor", "middle")
              .attr("style", "font-size: 12; font-family: Helvetica, sans-serif")
              .text(function(d) { return d.FullName;})
              .style("cursor", "pointer")
              .on("click", function(d){ document.location.href = "./customer_favourites_report.php?id=" + d.UserID; })
              .attr("transform", "translate(0, 18)")
              .attr("class", "yAxis");
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
    
    $(document).ready(function () {    
        //createCheckboxList();
        createCanvas();
        setScales();
        drawAxes();
        drawGraph();
        drawBars();
    }); 
    
</script>
<?php include 'footer.php'; ?>