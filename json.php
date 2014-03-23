<?php
    //$arr = array ('a'=>1,'b'=>2,'c'=>3,'d'=>4,'e'=>5);
    //echo json_encode($arr); // {"a":1,"b":2,"c":3,"d":4,"e":5}
    
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
    
    echo json_encode($fish_prices_trend); // {"a":1,"b":2,"c":3,"d":4,"e":5}
    
    
?>