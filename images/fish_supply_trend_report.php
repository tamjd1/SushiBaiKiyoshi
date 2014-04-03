<?php
    $file = "fish_prices_trend_report.php";
    $title = "Sushi Bai Kiyoshi - Fish Prices Trend Report";
    $banner = "Sushi Bai Kiyoshi - Fish Prices Trend Report";
    $description = "This page generates a report of prices of different types of fish over a period of time";
    $date = "22/03/2014";
    require 'header.php';


$fish_supply_trend = array();

$conn = db_connect();
$sql = "SELECT \"Type\", \"Date\", \"SupplyStatus\" FROM \"tblFishMarket\" ORDER BY \"Date\"";
$result = pg_query($conn, $sql);

$i = 0;
$tabular_report = "<table id='tabular_report'><tr><th>Date</th><th>Fish Type</th><th>Status</th></tr>";
while ($row = pg_fetch_row($result))
{
    //$status_letter = ($row[2] == 'l') ? "Low" : ($row[2] == 'm') ? "Medium" : ($row[2] == 'h') ? "High" : "None"; 
    //echo $row[2] . "<br/>";
    //$status_value = ($row[2] == "l") ? 10 : ($row[2] == "m") ? 20 : ($row[2] == "h") ? 30 : 0; 
    //$tabular_report .= "<tr id=''><td>".$row[1]."</td><td>".$row[0]."</td><td>".$status_letter."</td></tr>";
    $fish_supply_trend[$i] = array('Type'=>$row[0],'Date'=>$row[1],'Status'=>$row[2]/*, 'StatusValue'=>$status_value*/);
    $i++;
}
$tabular_report .="</table>";

?>


<section id="MainContent">            
    <h1 class="center">Fish Supply Trend Report</h1> 
    <div style="display:inline">
        <div class="float-left" style="max-width:85%; max-height:100%; min-width:100px; min-height:100px; margin-left:20px" id="myCanvas"></div>
        <div class="float-right" style="max-width:15%; max-height:100%; min-width:100px; min-height:100px;margin-right:20px" id="checkboxes">
        Select year:
        <select id="years" onchange="yearChanged(this.value);"></select><br/>
        </div>
    </div>
</section>
<?php //echo $tablular_report; ?>
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

    var parseDate = d3.time.format("%Y-%m-%d").parse;
    var fishData, yearSelected, daysInAYear, MAX_CANVAS_WIDTH, MAX_CANVAS_HEIGHT, CENTRE_X, CENTRE_Y, svg, canvas, graph, timeScale;
    var yScale = d3.scale.linear();        
    var xScale = d3.scale.linear();
    var fishTypes = new Array();
    var fishTypesUnique = new Array();
    var years = new Array();
    var yearsUnique = new Array();
    var dates = new Array();
    var statuses = new Array();
    var statusDomain = new Array();
    var statusValue = new Array();
    var statusValueDomain = new Array();
    var fishDataByYear = new Array();
    var fishSupplyValueByYear = new Array();
    
    fishData = <?php print json_encode($fish_supply_trend); ?>;
    //console.log(fishData);
    
    for(var i = 0; i < fishData.length; i++) {
        fishTypes.push(fishData[i].Type); //
        dates.push(fishData[i].Date);
        //var status = (fishData[i].Status === "l") ? "Low" : (fishData[i].Status === "m") ? "Medium" : (fishData[i].Status === "h") ? "High" : "0";
        //statuses.push(status);
        var value = (fishData[i].Status === "l") ? 10 : (fishData[i].Status === "m") ? 20 : (fishData[i].Status === "h") ? 30 : 0;
        statusValue.push(value);
        years.push(parseDate(fishData[i].Date).getFullYear());
    }
    
    //console.log(statuses);
    fishTypesUnique = fishTypes.unique(); //get unique values for fish types and add checkboxes     
    //statusDomain = statuses.unique();
    //statusDomain.sort();
    statusDomain.push(" ");
    statusDomain.push("High");
    statusDomain.push("Medium");
    statusDomain.push("Low");
    statusDomain.push("0");
    
    statusValueDomain = statusValue.unique();
    statusValueDomain.push(40);
    statusValueDomain.sort();
    yearsUnique = years.unique(); //get unique values for year to add to dropdown.
    yearsUnique.sort();

    function createCheckboxList() {
        var html = "<table>";
        for (var i = 0; i < fishTypesUnique.length; i++) { //add checkbox for each fish type
            html +='<tr><td><div style="display:inline-block; background-color:'+getRandomColour(i)+';"><input type="checkbox" id="'+i+'" value="'+fishTypesUnique[i]+'" onchange="plotLineGraph(this.id, this.checked,this.value,getRandomColour(this.id))"/></div></td><td style="text-align:left;">'+fishTypesUnique[i]+'</td></tr>';
        }
        html += "</table>";
        //html += "<a href='./fish_price_trend_tabular.php'>Tabular Report</a>";
        $('#checkboxes').append(html);
    }
    
    function createDropdownList() {
        var html = "";
        for (var i = 0; i < yearsUnique.length; i++) { //add checkbox for each fish type
            html +="<option value='"+yearsUnique[i]+"'>"+yearsUnique[i]+"</option>";
        }
        $('#years').append(html);
    }
   
    function yearChanged(value) {
        //var e = document.getElementById("years");
        //var value = e.options[e.selectedIndex].text;
        //alert(value);
        yearSelected = value;
        
        fishDataByYear = new Array();
        
        for(var i = 0; i < fishData.length; i++) {
            if(parseDate(fishData[i].Date).getFullYear() == yearSelected) {
                fishDataByYear.push(fishData[i]);
                fishSupplyValueByYear.push(statusValue[i]);
            }
        }
        console.log(fishDataByYear);
        console.log(fishSupplyValueByYear);
        
        //MAX_PRICE = getMaxPrice(); //get max price
        //for (var i = MAX_PRICE; i >= 0; i-=5) {
        //    priceDomain.push(i); //set price domain at $5 intervals
        //}        
    
        daysInAYear = (((yearSelected % 4 == 0) && (yearSelected % 100 != 0)) || (yearSelected % 400 == 0)) ? 366 : 365;
        
        timeScale = d3.time.scale()
            .domain([new Date(yearSelected, 0, 1), new Date(yearSelected, 11, 31)])
            .range([0, xScale(daysInAYear)]); 
    
    }
    
    /**
    This function creates the <svg> canvas on which line graph will be drawn
    */
    function createCanvas() {
        $("#myCanvas").height(($(window).height() - $("footer").height() - $("header").height()));
        $("#myCanvas").width($(window).width()*0.80); 
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
            .attr("transform", "translate(" + (-(parseFloat(CENTRE_X)) + parseFloat(60)) + "," + (parseFloat(CENTRE_Y) - parseFloat(50)) + ")");
    }
    
    /**
    This function draws x and y axes to represent the height and length of the walls and the items within the walls
    */
    function drawAxes() { 

    //bottom axis
        timeScale = d3.time.scale()
            .domain([new Date(yearSelected, 0, 1), new Date(yearSelected, 11, 31)])
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

    //console.log(statusDomain);
        
        var leftScale = d3.scale.ordinal()
            .domain(statusDomain)
            .rangePoints([0, yScale(40)]);

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
        drawRect(graph, xScale(daysInAYear), yScale(d3.max(statusValueDomain)), 0, -yScale(d3.max(statusValueDomain)), "white", 1.0, "white");
        var pt1, pt2;
        
        //horizontal grid lines
        for (var i = yScale(5); i < yScale(d3.max(statusValueDomain)); i+=yScale(5)) {
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
            pt2 = { "x": xScale(jan), "y": -yScale(d3.max(statusValueDomain)) }; //line left coordinates
            drawLine(pt1, pt2, graph, 1, "lightgray"); 
            //february
            pt1 = { "x": xScale(feb), "y": 0 }; //line left coordinates
            pt2 = { "x": xScale(feb), "y": -yScale(d3.max(statusValueDomain)) }; //line left coordinates
            drawLine(pt1, pt2, graph, 1, "lightgray"); 
            //march
            pt1 = { "x": xScale(mar), "y": 0 }; //line left coordinates
            pt2 = { "x": xScale(mar), "y": -yScale(d3.max(statusValueDomain)) }; //line left coordinates
            drawLine(pt1, pt2, graph, 1, "lightgray"); 
            //april
            pt1 = { "x": xScale(apr), "y": 0 }; //line left coordinates
            pt2 = { "x": xScale(apr), "y": -yScale(d3.max(statusValueDomain)) }; //line left coordinates
            drawLine(pt1, pt2, graph, 1, "lightgray"); 
            //may
            pt1 = { "x": xScale(may), "y": 0 }; //line left coordinates
            pt2 = { "x": xScale(may), "y": -yScale(d3.max(statusValueDomain)) }; //line left coordinates
            drawLine(pt1, pt2, graph, 1, "lightgray"); 
            //june
            pt1 = { "x": xScale(jun), "y": 0 }; //line left coordinates
            pt2 = { "x": xScale(jun), "y": -yScale(d3.max(statusValueDomain)) }; //line left coordinates
            drawLine(pt1, pt2, graph, 1, "lightgray"); 
            //july
            pt1 = { "x": xScale(jul), "y": 0 }; //line left coordinates
            pt2 = { "x": xScale(jul), "y": -yScale(d3.max(statusValueDomain)) }; //line left coordinates
            drawLine(pt1, pt2, graph, 1, "lightgray"); 
            //august
            pt1 = { "x": xScale(aug), "y": 0 }; //line left coordinates
            pt2 = { "x": xScale(aug), "y": -yScale(d3.max(statusValueDomain)) }; //line left coordinates
            drawLine(pt1, pt2, graph, 1, "lightgray"); 
            //september
            pt1 = { "x": xScale(sep), "y": 0 }; //line left coordinates
            pt2 = { "x": xScale(sep), "y": -yScale(d3.max(statusValueDomain)) }; //line left coordinates
            drawLine(pt1, pt2, graph, 1, "lightgray"); 
            //october
            pt1 = { "x": xScale(oct), "y": 0 }; //line left coordinates
            pt2 = { "x": xScale(oct), "y": -yScale(d3.max(statusValueDomain)) }; //line left coordinates
            drawLine(pt1, pt2, graph, 1, "lightgray"); 
            //november
            pt1 = { "x": xScale(nov), "y": 0 }; //line left coordinates
            pt2 = { "x": xScale(nov), "y": -yScale(d3.max(statusValueDomain)) }; //line left coordinates
            drawLine(pt1, pt2, graph, 1, "lightgray"); 
        ///end of vertical grid lines        
    }
    
    /**
    This function sets the scale for x and y axis to optimally draw the graph regardless of the size of the screen
    */
    function setScales() {
        yScale.domain([0, 40])
             .range([0 , MAX_CANVAS_HEIGHT - 100]);
        xScale.domain([0 , daysInAYear]) 
             .range([0 , MAX_CANVAS_WIDTH - 100]);
    }
    
    /**
    This function determines and returns the max date value from the JSON array.
    */
    function getMaxDate() {
        var maxPrice = 0;
        for(var i = 0; i < fishDataByYear.length; i++) {
            if(fishDataByYear[i].Price > maxPrice) 
                maxPrice = fishDataByYear[i].Price;
        }
        return maxPrice;
    }
    
    /**
    This function determines and returns the max price value from the JSON array.
    */
    function getMaxPrice() {
        var maxPrice = 0;
        for(var i = 0; i < fishDataByYear.length; i++) {
            if(fishDataByYear[i].Price > maxPrice) 
                maxPrice = fishDataByYear[i].Price;
        }
        return (Math.round(maxPrice / 10) * 10) + 10;
    }
    
    
    /**
    This functions returns a random colour depending on the value of the id
    @param id - id of the (fish type) checkbox
    @return colour - returns the colour as a string
    */
    function getRandomColour(id) {
        id += ""; //make it a string if its not
        return colour = (id === "0") ? "red" 
                   : (id === "1") ? "blue" 
                   : (id === "2") ? "purple" 
                   : (id === "3") ? "green" 
                   : (id === "4") ? "magenta"
                   : (id === "5") ? "black"
                   : (id === "6") ? "orange"
                   : (id === "7") ? "brown"                       
                   : (id === "8") ? "lime"
                   : (id === "8") ? "yellow"
                   : (id === "9") ? "cyan" : "black";
    }
    
    /**
    This function sets the x and y coordinates of the line and draws it on the graph.
    This function also deletes a line from the graph.
    @param checked - nature of the checkbox (checked = true or unchecked = false) 
    @param name - name of the checkbox
    @param colour - colour of the line
    */
    function plotLineGraph(id, checked, name, colour) {
 
        if(checked) {

            var points = new Array();
            for (var i = 0; i < fishDataByYear.length; i++) {
                if (fishDataByYear[i].Type === name) {
                    points.push({"x": timeScale(parseDate(fishDataByYear[i].Date)), "y": (-yScale(fishSupplyValueByYear[i]))});
                }
            }
            //console.log(points);    
            var gLine = graph.append("g");
            drawPolyLine(gLine, points, colour, 2, "poly"+id, name);
        }    
        else {
            if ($("#poly"+id)) {
                d3.selectAll("#poly"+id).remove(); //remove existing walls
            }
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
        createDropdownList();
        yearChanged(d3.min(yearsUnique));
        createCheckboxList();
        createCanvas();
        setScales();
        drawAxes();
        drawGraph();
    }); 
   
</script>

<?php include 'footer.php'; ?>