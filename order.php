<?php
$file = "menu.php";
$title = "Sushi Bai Kiyoshi - Menu";
$banner = "Sushi Bai Kiyoshi - Menu";
$description = "This page displays the menu items for Sushi Bai Kiyoshi";
$date = "05/03/2014";

require 'header.php';


function db_connect() {
	$conn = pg_connect("host=127.0.0.1 port=5432 dbname=sushi user=postgres password=100338841");
	return $conn;
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
    $menu_items[$i] = array('ID'=>$i,'Item'=>$row[0],'Price'=>$price,'Type'=>$row[2],'PromotionID'=>$row[3]);
    $i++;
}

$sql = "SELECT DISTINCT \"ItemType\"FROM \"tblMenuItems\" WHERE \"ItemStatus\" = 'e'";
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
                                                    $menu_list_html .= '<tr><td><input id="'.$menu_items[$k]['ID'].'" onblur="updateCart(this.id)" type="textbox" style="width:18px" value="0"/>'.$menu_items[$k]['Item'].'</td>';
                                                    $menu_list_html .= '<td> $'.$menu_items[$k]['Price'].'</td></tr>';
                                                }
                                            }
                    $menu_list_html .= '</table></td><tr><td></td><td><br/><input type="button" value="Add to Order"/></td></tr></tr>
                                </tr>
                            </table>
                        </li>
                    </ul>            
                </div>
            </li>';             
}

function getMenuType($val) {
    return ($val == 'r') ? 'Rolls' : ($val == 's') ? 'Sashimi' : ($val == 'sr') ? 'Special Rolls' : ($val == 'a') ? 'Appetizers' : 'Combos';
}

?>

        <section id="MainContent">

        <p style="padding-left:30px">Click on a category and start adding items to the menu to create your order.</p>

            <div id="menu" class="float-left">
            <ul class="toggleOptions">
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

    function updateCart(id) {
        var quantity = $("#"+id).val();
        if (quantity > 0) {
            var price = Math.round((data[id].Price * quantity) * 100) / 100;
            var html = "<tr id='item"+id+"'><td>"+data[id].Item+"</td><td id='quantity"+id+"'>"+quantity+"</td><td style='text-align:right;'>$"+price+"</td></tr>";
            $("#cart").append(html);
            var subtotal = $("#subtotal").html();
            console.log(subtotal);
            subtotal = parseFloat(subtotal) + parseFloat(price);
            console.log(subtotal);
            $("#subtotal").html(subtotal);
        }
        else {
            $("#item"+id).remove();
            var subtotal = $("#subtotal").html();
            subtotal = parseFloat(subtotal) - (Math.round((parseFloat(data[id].Price) * parseFloat($("#quantity"+id).html())) * 100) / 100);
            $("#subtotal").html(subtotal);
            
        }
    }

//data = <?php print json_encode($types); ?>; 
//console.log(data);
//data = <?php print json_encode($menu_list_html); ?>; 
//console.log(data);
</script>
            
            
<?php include 'footer.php'; ?>