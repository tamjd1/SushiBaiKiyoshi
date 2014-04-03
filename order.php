<?php
$file = "menu.php";
$title = "Sushi Bai Kiyoshi - Menu";
$banner = "Sushi Bai Kiyoshi - Menu";
$description = "This page displays the menu items for Sushi Bai Kiyoshi";
$date = "05/03/2014";

require 'header.php';

//$str_json = file_get_contents('php://input');
//echo "Hello" . $str_json;
//$data = json_decode($_GET['data']);
//echo "Goodbye ".$data;
//echo "dfjalhf".$_GET['data'];

//session_destroy();

    //echo $_SESSION['cart_data'][0]['Item'];
    //echo $_SESSION['subtotal'];
    
   $subtotal = (isset($_SESSION['subtotal'])) ? $_SESSION['subtotal'] : 0.00;
    
$cart_html = "";
    for ($cart_counter = 0; $cart_counter < sizeof($_SESSION['cart_data']); $cart_counter++) {
        $cart_quantity = $_SESSION['cart_data'][$cart_counter]['Quantity'];
        if($cart_quantity > 0) {
            $cart_item = $_SESSION['cart_data'][$cart_counter]['Item'];
            $cart_price = $_SESSION['cart_data'][$cart_counter]['Price'] * $cart_quantity;
            $cart_html .= "<tr id='item".$cart_counter."'><td>".$cart_item."</td><td id='quantity".$cart_counter."'>".$cart_quantity."</td><td id='price".$cart_counter."' style='text-align:right;'>$".$cart_price."</td></tr>";
        }
    }

$menu_items_detailed = array();
$items = array();
//$prices = array();
$types = array();

$conn = db_connect();
$sql = "SELECT \"ItemDescription\", \"ItemPrice\", \"ItemType\", \"PromotionID\" FROM \"tblMenuItems\" WHERE \"ItemStatus\" = 'e'";
$result = pg_query($conn, $sql);
//$type_string;
$i = 0;

while ($row = pg_fetch_row($result))
{
    $price = $row[1];
    if($row[3] != null) {
        $sql2 = "SELECT \"PromotionDescription\", \"PromotionValue\", \"IsPercent\" FROM \"tblPromotions\" WHERE \"PromotionID\" = " . $row[3];
        //echo $sql2;
        $result2 = pg_query($conn, $sql);
        $row2 = pg_fetch_row($result2);
        $price = ($row2[2] == 't') ? $price * $row2[1] : $price - $row2[1];
    }   
    //$types[$i] = $row[2];
    $menu_items[$i] = array('ID'=>$i,'Item'=>$row[0],'Price'=>$price,'Type'=>$row[2],'PromotionID'=>$row[3],'Quantity'=>0);
    $i++;
}

$sql = "SELECT DISTINCT \"ItemType\" FROM \"tblMenuItems\" WHERE \"ItemStatus\" = 'e'";
//echo $sql;
$result = pg_query($conn, $sql);
//$type_string;
$i = 0;

while ($row = pg_fetch_row($result))
{
    $types[$i] = $row[0];
    $i++;
}

//$types = array_unique($types);
$menu_list_html = "";
//$unique_count = 0;
for($j = 0; $j < sizeof($types); $j++) {
//echo "HEREJHLKEHJRKE" . getMenuType($types[$j]);

$menu_list_html .= '<li><input type="radio" id="rad'.$types[$j].'" name="menuItemTypes"  />
                <label id="lbl'.$types[$j].'Radio" for="rad'.$types[$j].'" ></label>
                <label id="lbl'.$types[$j].'" for="rad'.$types[$j].'">'.$types[$j].'</label>
                <div class="toggleContent">
                    <ul>
                        <li>
                            <table id="'.$types[$j].'_list" class="menu">                               
                               <tr>
                                    <td class="menu_item_img">
                                         <img src="./images/menu/1.png" />
                                    </td>
                                    <td>
                                    <table>';
                                            for($k = 0; $k < sizeof($menu_items) - 1; $k++) {
                                                if($menu_items[$k]['Type'] == $types[$j]) {
                                                    //$menu_list_html .= '<tr><td><input id="'.$menu_items[$k]['ID'].'" onblur="updateCart(this.id)" type="textbox" style="width:18px" value="0"/> ';
                                                    $disabled = ($_SESSION['cart_data'][$k]['Quantity'] == 0) ? "disabled='disabled'" : "";
                                                    $menu_list_html .= '';
                                                    $menu_list_html .= '<tr><td>'.$menu_items[$k]['Item'].'</td>';
                                                    $menu_list_html .= '<td> $'.$menu_items[$k]['Price'].'</td>';
                                                    $menu_list_html .= '<td><input id="a'.$menu_items[$k]['ID'].'" type="button" value="+" onclick="addToCart(this.id)" /></td>';
                                                    $menu_list_html .= '<td><input id="r'.$menu_items[$k]['ID'].'" type="button" value="-" onclick="removeFromCart(this.id)" '. $disabled .' /></td>';
                                                    $menu_list_html .= '</tr>';
                                                }
                                            }
                                    $menu_list_html .= '</table></td>
                                </tr>
                            </table>
                        </li>
                    </ul>            
                </div>
            </li>';             
}

?>
    
        <section id="MainContent">

        <p style="padding-left:30px">Click on a category and start adding items to the menu to create your order.</p>

            <div id="menud" class="float-left">
            <ul class="toggleOptions">
            <!--
            <li>
                <input type="radio" id="radMenuItemType1" name="menuItemTypes"  />
                <label id="lblMenuItem1Radio" for="radMenuItemType1" ></label>
                <label id="lblMenuItem1" for="radMenuItemType1">Favourites</label>
                <div class="toggleContent">
                    <ul>
                        <li>
                            <table id="combos_list" class="menu">
                                <tr>
                                    <td class="menu_item_img">
                                         <img src="./images/menu/1.png" />
                                    </td>
                                    <td>
                                        <b>Maki Combo</b><br/><hr/>
                                        <input type="textbox" style="width:18px" value="0"/> Spicy Tuna <br/>
                                        <input type="textbox" style="width:18px" value="0"/> Spicy Salmon <br/>
                                        <input type="textbox" style="width:18px" value="0"/> Real California <br/>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="menu_item_img">
                                        <img src="./images/menu/2.png" />
                                    </td>
                                    <td>
                                        <b>Nigiri Combo</b><br/><hr/>
                                        Spicy Tuna <input type="textbox" style="width:18px" value="0"/><br/>
                                        Spicy Salmon <input type="textbox" style="width:18px" value="0"/><br/>
                                        Avocado Cucumber <input type="textbox" style="width:18px" value="0"/><br/>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="menu_item_img">
                                        <img src="./images/menu/3.png" />
                                    </td>
                                    <td>
                                        <b>Sashimi Combo</b><br/><hr/>
                                        Chefs Selection (12 pc) <input type="textbox" style="width:18px" value="0"/><br/>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="menu_item_img">
                                        <img src="./images/menu/4.png" />
                                    </td>
                                    <td>
                                        <b>Sushi Combo</b><br/><hr/>
                                        Spicy Tuna <input type="textbox" style="width:18px" value="0"/><br/>
                                        Spicy Salmon <input type="textbox" style="width:18px" value="0"/><br/>
                                        Avocado Cucumber <input type="textbox" style="width:18px" value="0"/><br/>
                                    </td> 
                                    <tr><td></td><td><br/><input type="button" value="Add to Order"/></td></tr></tr>
                                </tr>
                            </table>
                        </li>
                    </ul>            
                </div>
            </li>
                        
            -->            
                        
            <?php echo $menu_list_html; ?>
            
         </ul>
            </div>
        
            <div id="cartDiv" class="float-right">
                <table id="cart">
                    <tr>
                        <th class="t_c">My Cart</th><th class="t_c"></th><th class="t_c"></th><hr/>
                    </tr>
                    <tr><td>Item</td><td>Quantity</td><td style='text-align:right;'>Total</td></tr>
                    <?php echo $cart_html; ?>
                </table>
                <table>
                    <tr><hr/>
                        <td>Subtotal: </td><td id="subtotal"><?php echo $subtotal; ?></td>
                    </tr>
                    <tr class="t_c">
                        <td colspan="2" style="text-align:center;"><hr/><input id="checkout" type="button" value="Checkout"/></td>
                    </tr>
                </table>
            </div>
        </section>
        
<script> 
//this is all for debugging purposes
var data = <?php print json_encode($menu_items); ?>; 
//var session_cart <?php //print json_encode($_SESSION['cart_data']); ?>; 
//console.log(data);
//console.log(session_cart);
var json_cart = new Array();
    function addToCart(id) {
    
        var index = id.substring(1,id.length);
        var quantity = $("#quantity"+index).html();
        
        if (typeof quantity === 'undefined')
        {
            quantity = 1;
            data[index].Quantity = quantity;
            json_cart = JSON.stringify(data);
            //console.log(json_cart);
            
            var request = $.ajax({
                url: "./ajax_cart.php",
                type: "POST",
                data: {data: json_cart}, // (variable to be passed, variable selected)
                dataType: "html"
                //success: function() {
                //    alert("success!");
                //}
            });
						
            request.fail(
                function(jqXHR, textStatus) {
                    alert( "Request failed: " + textStatus );
                }
            );

            
            var price = parseFloat(data[index].Price);
            var total = parseFloat(data[index].Price * quantity);
            var html = "<tr id='item"+index+"'><td>"+data[index].Item+"</td><td id='quantity"+index+"'>"+quantity+"</td><td id='price"+index+"' style='text-align:right;'>$"+total+"</td></tr>";
            $("#cart").append(html);
            $("#r"+index).removeAttr('disabled');
            //var subtotal = $("#subtotal").html();
            //subtotal = parseFloat(subtotal) + parseFloat(price);
            //$("#subtotal").html(subtotal);
        }
        else
        {
            quantity++;
            data[index].Quantity = quantity;
            json_cart = JSON.stringify(data);
            //console.log(json_cart);


            var request = $.ajax({
                url: "./ajax_cart.php",
                type: "POST",
                data: {data: json_cart}, // (variable to be passed, variable selected)
                dataType: "html"
                //success: function() {
                //    alert("success!");
                //}
            });
						
            request.fail(
                function(jqXHR, textStatus) {
                    alert( "Request failed: " + textStatus );
                }
            );

            
            var total = parseFloat(data[index].Price * quantity);
            var price = parseFloat(data[index].Price + price);
            $("#quantity"+index).html(quantity);
            $("#price"+index).html("$"+total.toFixed(2));     
            //var subtotal = $("#subtotal").html();
            //subtotal = parseFloat(subtotal) + parseFloat(price);
            //$("#subtotal").html(subtotal);        
        }
        
        var subtotal = $("#subtotal").html();
        console.log("sub: "+subtotal);
        subtotal = parseFloat(subtotal) + parseFloat(price);
        $("#subtotal").html(subtotal.toFixed(2));  
              
           
           var request = $.ajax({
                url: "./ajax_subtotal.php",
                type: "POST",
                data: {subtotal: subtotal}, // (variable to be passed, variable selected)
                dataType: "html"
                //success: function() {
                //    alert("success!");
                //}
            });
						
            request.fail(
                function(jqXHR, textStatus) {
                    alert( "Request failed: " + textStatus );
                }
            );
            
            
    }

    function removeFromCart(id) {
        var index = id.substring(1,id.length);
        var quantity = $("#quantity"+index).html();
        quantity--;
        data[index].Quantity = quantity;
        json_cart = JSON.stringify(data);
        
        
            var request = $.ajax({
                url: "./ajax_cart.php",
                type: "POST",
                data: {data: json_cart}, // (variable to be passed, variable selected)
                dataType: "html"
                //success: function() {
                //    alert("success!");
                //}
            });
						
            request.fail(
                function(jqXHR, textStatus) {
                    alert( "Request failed: " + textStatus );
                }
            );
        
        
        //console.log(json_cart);
        if (quantity !== 0)
        {
            var price = data[index].Price * quantity;
            price = price.toFixed(2);
            $("#quantity"+index).html(quantity);
            $("#price"+index).html(price);
            var subtotal = $("#subtotal").html();
            subtotal = parseFloat(subtotal) - parseFloat(data[index].Price);
            subtotal = (subtotal < 0) ? 0 : subtotal;
            $("#subtotal").html(subtotal.toFixed(2));   
            
            
           var request = $.ajax({
                url: "./ajax_subtotal.php",
                type: "POST",
                data: {subtotal: subtotal}, // (variable to be passed, variable selected)
                dataType: "html"
                //success: function() {
                //    alert("success!");
                //}
            });
						
            request.fail(
                function(jqXHR, textStatus) {
                    alert( "Request failed: " + textStatus );
                }
            );
            
            
        }
        else if (quantity == 0)
        {
            $("#r"+index).attr('disabled','disabled');  // disabling '-' button
            var subtotal = $("#subtotal").html();
            subtotal = parseFloat(subtotal) - (Math.round((parseFloat(data[index].Price) * parseFloat($("#quantity"+index).html())) * 100) / 100);
            subtotal = subtotal < 0 ? 0 : subtotal;
            $("#subtotal").html(subtotal.toFixed(2));   
            $("#item"+index).remove();
           

           var request = $.ajax({
                url: "./ajax_subtotal.php",
                type: "POST",
                data: {subtotal: subtotal}, // (variable to be passed, variable selected)
                dataType: "html"
                //success: function() {
                //    alert("success!");
                //}
            });
						
            request.fail(
                function(jqXHR, textStatus) {
                    alert( "Request failed: " + textStatus );
                }
            );
           
           
           
        }
    }
    
//data = <?php print json_encode($types); ?>; 
//console.log(data);
//data = <?php print json_encode($menu_list_html); ?>; 
//console.log(data);
</script>
            
            
<?php include 'footer.php'; ?>