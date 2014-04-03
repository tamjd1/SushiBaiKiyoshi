<?php
$file = "menu.php";
$title = "Sushi Bai Kiyoshi - Menu";
$banner = "Sushi Bai Kiyoshi - Menu";
$description = "This page displays the menu items for Sushi Bai Kiyoshi";
$date = "05/03/2014";

require 'header.php';
require 'functions.php';

//$str_json = file_get_contents('php://input');
//echo "Hello" . $str_json;
$array = json_decode($_POST['jsondata']);
echo "Goodbye ".$array;

$menu_items_detailed = array();
$items = array();
//$prices = array();
$types = array();

$conn = db_connect();
$sql = "SELECT \"ItemDescription\", \"ItemPrice\", \"ItemType\", \"PromotionID\" FROM \"tblMenuItems\" WHERE \"ItemStatus\" = 'e'";
$result = pg_query($conn, $sql);
$type_string;
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
                                                    $menu_list_html .= '';
                                                    $menu_list_html .= '<tr><td>'.$menu_items[$k]['Item'].'</td>';
                                                    $menu_list_html .= '<td> $'.$menu_items[$k]['Price'].'</td>';
                                                    $menu_list_html .= '<td><input id="a'.$menu_items[$k]['ID'].'" type="button" value="+" onclick="addToCart(this.id)" /></td>';
                                                    $menu_list_html .= '<td><input id="r'.$menu_items[$k]['ID'].'" type="button" value="-" onclick="removeFromCart(this.id)" disabled="disabled" /></td>';
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
                    <!-- temp 
                    <tr style="text-align:left">
                        <td>Spicy Tuna Combo</td>
                    </tr>
                    <tr style="text-align:left">
                        <td>Avocado Cucumber Combo</td>
                    </tr>
                    <!-- /temp 
                    
                    <tr>
                        <td><hr/>Subtotal: $20.00</td>
                    </tr>
                    <tr class="t_c">
                        <td><hr/><input id="checkout" type="button" value="Checkout"/></td>
                    </tr>-->
                </table>
                <table>
                    <tr>
                        <td><hr/>Subtotal: </td><td id="subtotal">$0.00</td>
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
console.log(data);
var json_cart = new Array();
    function addToCart(id) {
    
        var index = id.substring(1,id.length);
        var quantity = $("#quantity"+index).html();
        
        if (typeof quantity === 'undefined')
        {
            //console.log("quantity: "+parseInt($("#quantity"+index).html()));
            quantity = 1;
            data[index].Quantity = quantity;
            json_cart = JSON.stringify(data);
            ajax();
            console.log(json_cart);
            //console.log("quantity: "+quantity);
            var price = data[index].Price * quantity;
            price = price.toFixed(2);
            var html = "<tr id='item"+index+"'><td>"+data[index].Item+"</td><td id='quantity"+index+"'>"+quantity+"</td><td id='price"+index+"' style='text-align:right;'>$"+price+"</td></tr>";
            $("#cart").append(html);
                $("#r"+index).removeAttr('disabled');
            var subtotal = $("#subtotal").html();
            console.log(subtotal);
            subtotal = parseFloat(subtotal) + parseFloat(price);
            console.log(subtotal);
            $("#subtotal").html(subtotal);
        }
        else
        {
            quantity++;
            data[index].Quantity = quantity;
            json_cart = JSON.stringify(data);
            ajax();
            console.log(json_cart);
            //console.log("quantity: "+quantity);
            var price = data[index].Price * quantity;
            price = price.toFixed(2);
            //var html = "<tr id='item"+index+"'><td>"+data[index].Item+"</td><td id='quantity"+index+"'>"+quantity+"</td><td style='text-align:right;'>$"+price+"</td></tr>";
            $("#quantity"+index).html(quantity);
            $("#price"+index).html(price);
            //$("#cart").append(html);
            var subtotal = $("#subtotal").html();
            console.log(subtotal);
            subtotal = parseFloat(subtotal) + parseFloat(price);
            console.log(subtotal);
            $("#subtotal").html(subtotal);        
        }
        
    }

    function removeFromCart(id) {
        var index = id.substring(1,id.length);
        var quantity = $("#quantity"+index).html();
        //console.log("quantity: "+quantity);
        quantity--;
        data[index].Quantity = quantity;
        json_cart = JSON.stringify(data);
        ajax();
        //console.log("quantity: "+quantity);
        //console.log(json_cart);
        if (quantity !== 0)
        {
            //console.log("quantity: "+quantity);
            var price = data[index].Price * quantity;
            price = price.toFixed(2);
            //var html = "<tr id='item"+index+"'><td>"+data[index].Item+"</td><td id='quantity"+index+"'>"+quantity+"</td><td style='text-align:right;'>$"+price+"</td></tr>";
            $("#quantity"+index).html(quantity);
            $("#price"+index).html(price);
        }
        else if (quantity == 0)
        {
            //console.log("yes");          
            $("#r"+index).attr('disabled','disabled');  // disabling '-' button
            $("#item"+index).remove();
            var subtotal = $("#subtotal").html();
            subtotal = parseFloat(subtotal) - (Math.round((parseFloat(data[index].Price) * parseFloat($("#quantity"+index).html())) * 100) / 100);
            $("#subtotal").html(subtotal);   
        }
    }
    
    function setCart() {
        //for ( var i = 0; i < 
    }
    
    function jsonify(data2) {
        json_cart = JSON.stringify(data2);
        request = new XMLHttpRequestObject();
        request.open("POST", "JSON_Handler.php", true);
        request.setRequestHeader("Content-type", "application/json");
        request.send(json_cart);
    }
    
    function ajax() {
        $.ajax({
            url: '<?php echo site_url(); ?>',
            type: 'POST',
            data: json_cart,
            success: function(){
            alert("Success!")
            }
            });
    }    
    
    
//data = <?php print json_encode($types); ?>; 
//console.log(data);
//data = <?php print json_encode($menu_list_html); ?>; 
//console.log(data);
</script>
            
            
<?php include 'footer.php'; ?>