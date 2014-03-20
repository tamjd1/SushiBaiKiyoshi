<?php
$file = "menu.php";
$title = "Sushi Bai Kiyoshi - Menu";
$banner = "Sushi Bai Kiyoshi - Menu";
$description = "This page displays the menu items for Sushi Bai Kiyoshi";
$date = "05/03/2014";

require 'header.php';
?>
        <section id="MainContent">

        <p style="padding-left:30px">Click on a category and start adding items to the menu to create your order.</p>
        
        <!--<table id="menu_options">
            <tr>
                <th colspan="10">Menu Categories</th>
            </tr>
            <tr>
                <td id="combos" onclick="menu_list(this.id); return false;">Combos</td>
                <td id="rolls" onclick="menu_list(this.id); return false;">Rolls</td>
                <td>Appetizers</td>
                <td>Sashimi</td>
            </tr>
        </table>-->
        fdfdfdfdfdfdfdsahghhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhh
            <div id="menu" class="float-left">
                          <ul class="toggleOptions">
            <li>
                <input type="radio" id="radMenuItemType1" name="menuItemType"  />
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
            <li>
                <input type="radio" id="radMenuItemType2" name="menuItemType"  />
                <label id="lblMenuItem2Radio" for="radMenuItemType2" ></label>
                <label id="lblMenuItem2" for="radMenuItemType2">Rolls</label>
           
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
                                </tr>
                                <tr><td></td><td><br/><input type="button" value="Add to Order"/></td></tr></tr>
                            </table>
                        </li>
                    </ul>            
                </div>
            </li>
            <li>
                <input type="radio" id="radMenuItemType3" name="menuItemType"  />
                <label id="lblMenuItem3Radio" for="radMenuItemType3" ></label>
                <label id="lblMenuItem3" for="radMenuItemType3">Special Rolls</label>
           
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
                                </tr>
                                <tr><td></td><td><br/><input type="button" value="Add to Order"/></td></tr></tr>
                            </table>
                        </li>
                    </ul>            
                </div>
            </li>
            <li>
                <input type="radio" id="radMenuItemType4" name="menuItemType"  />
                <label id="lblMenuItem4Radio" for="radMenuItemType4" ></label>
                <label id="lblMenuItem4" for="radMenuItemType4">Sashimi</label>
           
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
                                </tr>
                                <tr><td></td><td><br/><input type="button" value="Add to Order"/></td></tr></tr>
                            </table>
                        </li>
                    </ul>            
                </div>
            </li>
            <li>
                <input type="radio" id="radMenuItemType5" name="menuItemType"  />
                <label id="lblMenuItem5Radio" for="radMenuItemType5" ></label>
                <label id="lblMenuItem5" for="radMenuItemType5">Appetizers</label>
           
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
                                </tr>
                                <tr><td></td><td><br/><input type="button" value="Add to Order"/></td></tr></tr>
                            </table>
                        </li>
                    </ul>            
                </div>
            </li>
            <li>
                <input type="radio" id="radMenuItemType6" name="menuItemType"  />
                <label id="lblMenuItem6Radio" for="radMenuItemType6" ></label>
                <label id="lblMenuItem6" for="radMenuItemType6">Combos</label>
           
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
                                </tr>
                                <tr><td></td><td><br/><input type="button" value="Add to Order"/></td></tr></tr>
                            </table>
                        </li>
                    </ul>            
                </div>
            </li>
         </ul>
            </div>
        
            <div id="cartDiv" class="float-right">
                <table id="cart">
                    <tr>
                        <th class="t_c">My Cart</th><hr/>
                    </tr>
                    
                    <!-- temp -->
                    <tr style="text-align:left">
                        <td>Spicy Tuna Combo</td>
                    </tr>
                    <tr style="text-align:left">
                        <td>Avocado Cucumber Combo</td>
                    </tr>
                    <!-- /temp -->
                    
                    <tr>
                        <td><hr/>Subtotal: $20.00</td>
                    </tr>
                    <tr class="t_c">
                        <td><hr/><input id="checkout" type="button" value="Checkout"/></td>
                    </tr>
                </table>
            </div>
        </section>
            
<?php include 'footer.php'; ?>