<?php
$file = "customer_favourites_report.php";
$title = "Sushi Bai Kiyoshi - Customer Favourites";
$banner = "Sushi Bai Kiyoshi - Customer Favourites";
$description = "This page generates and displays a report of most frequently bought items for a particular customer";
$date = "01/04/2014";

require 'header.php';


$id = $_GET['id'];
$favourites = array();

$conn = db_connect();
$sql =  "SELECT \"tblUsers\".\"UserFirst\", \"tblUsers\".\"UserLast\", \"tblInvoices\".\"InvoiceID\"
  FROM \"tblUsers\" JOIN \"tblInvoices\" ON \"tblUsers\".\"UserID\" = \"tblInvoices\".\"UserID\"
  WHERE \"tblUsers\".\"UserID\" = '" . $id . "'";// AND \"tblInvoices\".\"InvoiceStatus\" = 'c'";

$result = pg_query($conn, $sql);
$row = pg_fetch_row($result);
$firstName;
$lastName;

$i = 0;
while ($row = pg_fetch_row($result))
{
    $firstName = $row[0];
    $lastName = $row[1];

    $sql2 = "SELECT \"tblMenuItems\".\"ItemDescription\", \"tblInvoiceItems\".\"ItemQuantity\" 
                FROM \"tblInvoiceItems\" JOIN \"tblMenuItems\" 
                ON \"tblInvoiceItems\".\"ItemID\" = \"tblMenuItems\".\"ItemID\"   
                WHERE \"tblInvoiceItems\".\"InvoiceID\" = " . $row[2];
    $result2 = pg_query($conn, $sql2);
    $row2 = pg_fetch_row($result2);
    
    $favourites[$i] = array('Item'=>$row2[0], 'Quantity'=>$row2[1]);
    echo "<br/>".$sql2;
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
    <h2>Customer Favourites Report</h2>
    <h3>Most Frequently Bought Items by <?php echo $firstName . " " . $lastName ?></h3>    
    <div style="max-width:95%; max-height:100%; min-width:100px; min-height:100px; margin-left:auto; margin-right:auto; margin-top:20px" id="myCanvas"></div>    
</section>


<script>
    var favourites, MAX_CANVAS_WIDTH, MAX_CANVAS_HEIGHT, CENTRE_X, CENTRE_Y, svg, canvas, graph, MAX_ORDER;
    var yScale = d3.scale.linear();        
    var xScale = d3.scale.linear();
    var items = new Array();
    var names = new Array();
    //var namesUnique = new Array();
    var orders = new Array();
    var orderDomain = new Array();
    
    favourites = <?php print json_encode($favourites); ?>;
    console.log(favourites);
    
    for (var i = 0; i < favourites.length; i++) {
        items[i] = favourites[i].Item;
    }
    
    names = items.unique();
    
    var data = new Array();
    
    for (var i = 0; i < names.length; i++) {
        var count = 0;
        for (var j = 0; j < favourites.length; j++) {
            if (names[i] === favourites[j].Item) {
                count += parseFloat(favourites[j].Quantity);
            }
        }
        orders[i] = count;
    }
    
    console.log(names);
    console.log(orders);
   
    for (var i = 0; i < names.length; i++) {
        data.push({"Item": names[i], "Quantity": orders[i]});
    }
    console.log(data);
    
    names.push(" ");
    //for(var i = 0; i < items.length; i++) {
    //    names.push(items[i].FullName); //
    //    orders.push(items[i].OrderCount);
    //}
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
              .data(data)
              .enter()
              .append("svg:rect")
              .attr("x", function(d, i) { return xScale(parseFloat(i)+parseFloat(1)); })
              .attr("y", function(d) { return -yScale(d.Quantity); })
              .attr("height", function(d) { return yScale(d.Quantity); })
              .attr("width", xScale(0.5))
              //.style("cursor", "pointer")
              //.on("click", function(d){ document.location.href = "http://localhost/SushiBaiKiyoshi/index.php?" + d.UserID; })
              .attr("fill", "#2d578b");
           
           //var g2 = graph.append("g");   
           //g2.selectAll("rect")
           //   .data(data)
           //   .enter()
           //   .append("svg:rect")
           //   .attr("x", function(d, i) { return xScale(parseFloat(i)+parseFloat(1)); })
           //   .attr("y", function(d) { return -yScale(d.CancelCount); })
           //   .attr("height", function(d) { return yScale(d.CancelCount); })
           //   .attr("width", xScale(0.5))
           //   .style("cursor", "pointer")
           //   .on("click", function(d){ document.location.href = "http://localhost/SushiBaiKiyoshi/index.php?" + d.UserID; })
           //   .attr("fill", "red");
          
          g.selectAll("text")
              .data(data)
              .enter()
              .append("svg:text")
              .attr("x", function(d, i) { return xScale(parseFloat(i)+parseFloat(1)) + xScale(0.5); })
              .attr("y", function(d) { return -yScale(d.Quantity); })
              .attr("dx", -(xScale(0.5)/2))
              .attr("dy", "1.2em")
              .attr("text-anchor", "middle")
              .text(function(d) { return d.Quantity;})
              .attr("fill", "white");
          
          //g2.selectAll("text")
          //    .data(data)
          //    .enter()
          //    .append("svg:text")
          //    .attr("x", function(d, i) { return xScale(parseFloat(i)+parseFloat(1)) + xScale(0.5); })
          //    .attr("y", function(d) { return -yScale(d.CancelCount); })
          //    .attr("dx", -(xScale(0.5)/2))
          //    .attr("dy", "1.2em")
          //    .attr("text-anchor", "middle")
          //    .text(function(d) { return d.CancelCount;})
          //    .attr("fill", "white");
              
          g.selectAll("text.yAxis")
              .data(data)
              .enter().append("svg:text")
              .attr("x", function(d, i) { return xScale(parseFloat(i)+parseFloat(1)) + xScale(0.5); })
              .attr("y", 5)
              .attr("dx", -(xScale(0.5)/2))
              .attr("text-anchor", "middle")
              .attr("style", "font-size: 12; font-family: Helvetica, sans-serif")
              .text(function(d) { return d.Item;})
              //.style("cursor", "pointer")
              //.on("click", function(d){ document.location.href = "http://localhost/SushiBaiKiyoshi/index.php?" + d.UserID; })
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