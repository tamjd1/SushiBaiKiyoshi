<?php


function db_connect() {
	$conn = pg_connect("host=127.0.0.1 port=5432 dbname=sushi user=postgres password=100338841");
	return $conn;
}

function isValidEmail($email) {
	return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function isExistingId($uid) {
	$conn = db_connect();
	$sql = "SELECT * FROM users WHERE userid = '".$uid."'";
	$result = pg_query($conn, $sql);
	return pg_num_rows($result) > 0;
}

/*
function edited by Taha Amjad
added a string parameter which will indicate whether 
we want the user to have the option to say "All" or not
for searching a listing, the user may want to be able to search
for "All" however, for creating a listing, one single listing
can't have "All" options.
To create a dropdown/checkbox set/option group set with "All"
option, pass in "All" or "all" as a string, else pass in an empty string
*/
function create_sticky_dropdown($dbname, $sticky = "", $string = "") {
	$conn = db_connect();
	$sql = "SELECT * FROM \"";
	$sql .= $dbname."\""; //added literal quotes for postgres
	$result = pg_query($conn, $sql);
	
	$html = "";
	if ($string != "")
	{
		$html .= "<select name='".$dbname."'><option value='0'>". $string."</option>";
	}
	else
	{
		$html .= "<select name='$dbname'>";
	}
	
	while ($row = pg_fetch_row($result))
	{
		$html .= "<option value='$row[0]' ";
		if($sticky == $row[0]){
			$html .= "selected=\"".$sticky."\"";
		}
		$html .= ">".$row[1]."</option>";
        
	}
	$html .= "</select>";
	echo $html;
    
}

// Selects all values of a column given its name in a table
function create_sticky_dropdown_Field($table, $field, $sticky = "", $string = "") {
	$conn = db_connect();
	$sql = "SELECT  '$field' 
            FROM \"$table\"
            group by \"$field\"" ;
   
	$result = pg_query($conn, $sql);
	echo $sql;
	$html = "";
	if ($string != "")
	{
		$html .= "<select name='".$field."'><option value='0'>". $string."</option>";
	}
	else
	{
		$html .= "<select name='$field'>";
	}
	
	while ($row = pg_fetch_row($result))
	{
		$html .= "<option value='$row[0]' ";
		if($sticky == $row[0]){
			$html .= "selected=\"".$sticky."\"";
		}
		$html .= ">".$row[1]."</option>";
        
	}
	$html .= "</select>";
	echo $html;
    
}

function get_dropdown_name($table, $value) {
	$conn = db_connect();
	$sql = "SELECT property FROM $table WHERE value = '$value'";
	$result = pg_query($conn, $sql);
	return pg_fetch_result($result, 0, "property");
}

function get_dropdown_value($table, $property) {
	$conn = db_connect();
	$sql = "SELECT value FROM $table WHERE property = '$property'";
	//echo $sql;
	$result = pg_query($conn, $sql);
	return pg_fetch_result($result, "value");	
}

//edited and made sticky by Taha Amjad
function create_checkboxset($dbname, $string = "", $preselect = 0) {
	$conn = db_connect();
	$sql = "SELECT * FROM ";
	$sql .= $dbname;
	$result = pg_query($conn, $sql);
	$records = pg_num_rows($result);
	
	$html = "";
	//if ($string == "all" || $string == "All")
	if ($string != "")
	{
		$html .= "<input type='checkbox' name=".$dbname."[]  value='0' />".$string;
	}
	else
	{
		$i = 0;
		while ($i < $records)
		{
			$value = pg_fetch_result($result, $i, "value");
			$property = pg_fetch_result($result, $i, "property");
			$checked = (isBitSet($i, $preselect))? " checked='checked' ": "";
			$html .= "<input type='checkbox' name='".$dbname."[]' value='$value'" . $checked . " />".$property;
			$html .= "<br/>";
			$i++;
			
			
		}
	}
	return $html;
}

//created/edited by Taha Amjad on Dec 06
function create_disabled_checkboxset($dbname, $string = "", $preselect = 0) {
	$conn = db_connect();
	$sql = "SELECT * FROM ";
	$sql .= $dbname;
	$result = pg_query($conn, $sql);
	$records = pg_num_rows($result);
	
	$html = "";
	//if ($string == "all" || $string == "All")
	if ($string != "")
	{
		$html .= "<input type='checkbox' disabled='disabled' name=".$dbname."[]  value='0' />".$string;
	}
	else
	{
		$i = 0;
		while ($i < $records)
		{
			$value = pg_fetch_result($result, $i, "value");
			$property = pg_fetch_result($result, $i, "property");
			$checked = (isBitSet($i, $preselect))? " checked='checked' ": "";
			$html .= "<input type='checkbox' disabled='disabled' name='".$dbname."[]' value='$value'" . $checked . " />".$property;
			$html .= "<br/>";
			$i++;
		}
	}
	return $html;
}

//edited and made sticky by Taha Amjad
function create_optiongroup($dbname, $sticky = "", $string = "") {
	$conn = db_connect();
	$sql = "SELECT * FROM ";
	$sql .= $dbname;
	$result = pg_query($conn, $sql);
	
	$html = "";
	
	//if($string == "all" || $string == "All")
	if($string != "")
	{
	$html = "<input type='radio' name=".$dbname." value='0'/>".$string;
	}
	else
	{
		while ($row = pg_fetch_row($result))
		{
			$html .= "<span>&nbsp;</span><input type='radio' name=".$dbname." value=".$row[0];
		
			if($sticky == $row[0])
			{
				$html .= " checked='checked'";
			}
			$html .= " /><span>&nbsp;</span>".$row[1]."<span>&nbsp;</span><span>&nbsp;</span>";
		}
	}
	return $html;
	
}

function create_imagelist() {

	$html = "";
	if($_SESSION['listing_id'] != ""){

		$conn = db_connect();
		$sql = "SELECT id, image_count FROM listings WHERE id =" . $_SESSION['listing_id'];
		$result = pg_query($conn, $sql);
		
		
		$img_count = pg_fetch_result($result, 0, 'image_count');
		$imagename = $_SESSION['listing_id'] . "_";
		if(pg_num_rows($result) > 0){
		
			
			$html = "<table>";		
			for ($i = 1; $i <= $img_count; $i++)
			{
				$html .= "<tr>";
				
				$html .= "<td><img src=\"./images/listings/" . $_SESSION['listing_id'] . "/" . "$imagename";
				$html .= $i;
				$html .= ".jpg?";
				$html .= time();
				$html .= "\" alt=\"sample image\" height=\"125\" width=\"200\" /></td>  
						<td><input type='radio' name=\"main\" value='$i' />
						<label>Make main image.</label><br/>
						<input type='checkbox' name='delete[]' value='$i' />
						<label>Delete image.</label></td>";
				
				$html .= "</tr>";
			}
			$html .= "</table>";
			
			
		}
		
		return $html;
	}
}

function create_thumbnails() {
	$html = "";
	
		$conn = db_connect();
		$sql = "SELECT id, image_count FROM listings WHERE id =" . $_SESSION['listing_id'];
		$result = pg_query($conn, $sql);
		
		
		$img_count = pg_fetch_result($result, 0, 'image_count');
		$imagename = $_SESSION['listing_id'] . "_";
		if(pg_num_rows($result) > 0){
		
			
			$html .= "<table><tr><td>";	
			for ($i = 1; $i <= $img_count; $i++)
			{
				
				$html .= "<a href=\"images/listings/" . $_SESSION['listing_id'] . "/" . $imagename . $i . "\">";
				$html .= "<img src=\"./images/listings/" . $_SESSION['listing_id'] . "/" . $imagename;
				$html .= $i;
				$html .= ".jpg\" alt=\"sample image\" height=\"94\" width=\"150\" /></a>";
				
			}
			$html .= "</td></tr></table>";
		
			
			
		
		
		return $html;
	}	
}

//edited and made sticky by Taha Amjad 
function years_dropdown($startyear, $sticky = "", $string = "") {
	$html = "<select name='years'>";
	//if ($string == "all" || $string == "All")
	if ($string != "")
	{
		$html .= "<option value='0'>".$string."</option>";
	}
	for ($i = $startyear; $i <= date('Y'); $i++)
	{	
		$year = date('Y')-($i-$startyear);
		$html .= "<option value='$year'";
		if($sticky == $year)
		{
			$html .= "selected='$sticky'";
		}
		$html .= ">".$year."</option>";
	}
	$html .= "</select>";
	return $html;
}

?>

	<?php
//*****AUTHENTICATION FUNCTIONS***********************************************************************
//
//***void reset_session_variables()
function reset_session_variables() {
	session_unset(); //edited by Taha Amjad
	//unset $_SESSION['login'];
	//unset $_SESSION['userid'];
	//unset $_SESSION['agent'];
	//unset $_SESSION['userid'];
	//unset $_SESSION['fname'];
	//unset $_SESSION['lname'];
	//unset $_SESSION['utype'];
	//unset $_SESSION['email'];
	//unset $_SESSION['last_login'];

	//delete user login COOKIE
	//setcookie("ulC", $name, time()-3600);
}

//***bool is_authed()
//@return	return bool	if true the user is already authenticated
function is_authed() {
	$result = false;
	if ($_SESSION['login'] == 1)
	{
		$result = true;
	}
	return $result;
}

//***bool is_admin()
//@return	return bool	if true the user is an admin
function is_admin() {
	$result = false;
	if ($_SESSION['utype'] == ADMIN)
	{
		$result = true;
	}
	return $result;
}

//***bool is_agent()
//@return	return bool	if true the user is an agent
function is_agent() {
	$result = false;
	if ($_SESSION['agent'] == 1 || $_SESSION['utype'] == AGENT)
	{
		{
			$result = true;
		}
	}
	return $result;
}

function new_session_data($set_cookie = false, $conn, $result) {
		date_default_timezone_set('Canada/Eastern');
		$sql = "UPDATE users SET last_login='".date("Y-m-d")."'WHERE userid='".pg_fetch_result($result, 'userid')."'";
		pg_query($conn, $sql);
		
		//create login token, and reset session attempts
		$_SESSION['login'] = 1;
		//$_SESSION['attempts'] = 0;
		$_SESSION['agent'] = 0;
		$_SESSION['userid'] = pg_fetch_result($result, 'userid');
		$_SESSION['utype'] = pg_fetch_result($result, 'utype');
		$_SESSION['email'] = pg_fetch_result($result, 'email');
		$_SESSION['last_login'] = pg_fetch_result($result, 'last_login');
		//$_SESSION['agentid'] = pg_fetch_result($result, 'agentid'); //added by Taha Amjad on Nov 06
		
		if ($set_cookie)
		{
			//create user login COOKIE
			setcookie("ulC", pg_fetch_result($result, 'userid'), time()+2592000);
		}

		if (is_agent() || is_admin())
		{
			$sql = "SELECT fname, lname FROM agents WHERE userid ='".pg_fetch_result($result, 'userid')."'";
			$result = pg_query($conn, $sql);
			$_SESSION['agent'] = 1;
			$_SESSION['fname'] = pg_fetch_result($result, 'fname');
			$_SESSION['lname'] = pg_fetch_result($result, 'lname');
		}
}

//***bool auth(string, string, string)
//@param	name string 	user's login name
//@param	pass string	user's password
//@param	rurl string	redirect url
//@return	return bool	if true the user is now authenticated
function auth($name, $pass) {
	$return = false;
	$conn = db_connect();
	$sql = "SELECT * FROM users WHERE userid = '$name'";
	$result = pg_query($conn, $sql);
	$result_pass = pg_fetch_result($result, 'password');
	$result_utype = pg_fetch_result($result, 'utype');

	//start session and record login attempt
	
	$_SESSION['attempts']++;

	if ( $pass == $result_pass)
	{ //successful login		
		new_session_data(true, $conn, $result);
		$return = true;
	}
	return $return;
}



//*****SEEDING FUNCTIONS******************************************************************************
//


//***void seed(pg_connection, string)
//@param	conn pg_connection		database connection string
//@param	num_records integer		number of loop iterations
//fixed up by Taha Amjad on Nov 14	
function seed_users($conn, $num_records = 10) {
	$male_fname_file = "./includes/seed data/male-first";
	$female_fname_file = "./includes/seed data/female-first";
	$lnames_file = "./includes/seed data/lastname";
	$street_file = "./includes/seed data/streets";
	$email_file = "./includes/seed data/emails";

	for ($i = 0; $i<$num_records; $i++) {
		if (mt_rand(0, 1))
		{
			//random male first name and salutation
			$fname = trim(random_line($male_fname_file));
			$salu = 'Mr.';
		} else {
			//random female first name and salutation
			$salu = (mt_rand(0, 1))? 'Ms.' : 'Mrs.'; 
			$fname = trim(random_line($female_fname_file));
		}
		$contact = (mt_rand(0, 1))? 'Email' : 'Phone';
		
		//$salu, $lname, $fname, $street, $num, $uid
		$lname = trim(random_line($lnames_file));			//last name
		$street = trim(random_line($street_file));			//street name
		$num = mt_rand(100, 999);					//street number
		$addr = $num." ".$street;					//full address
		$userid = trim(substr($fname, 0, 1).$lname).$num;		//user id
		$pass = "password";						//password
		$utype = random_utype();					//random user type
		$email = trim(random_line($email_file));				//random email
		$prov = get_dropdown_name('provinces', random_opt_value("provinces"));			//random province
		$city = get_dropdown_name('cities', random_opt_value("cities"));				//random cities
		$postal_code = chr(65 + mt_rand(0, 25)).mt_rand(0, 9).chr(65 + mt_rand(0, 25))." ".mt_rand(0, 9).chr(65 + mt_rand(0, 25)).mt_rand(0, 9); //random postal code 
		$first_set = mt_rand(100,999);
		$second_set = mt_rand(100,999);
		$third_set = mt_rand(1000,9999);								
		$phone = $first_set.$second_set.$third_set;		//random phone number

		//update db with new user
		$sql = 'INSERT INTO users (userid, password, utype, email) VALUES ( $1, $2, $3, $4 )';
		$result = pg_query_params($conn, $sql, array($userid, $pass, $utype, $email));
		echo $i." - - - ".$result."<br><br>";

		$sql = 'INSERT INTO agents (userid, salutation, fname, lname, province, city, address, postal_code, phone, pref_contact) VALUES ( $1, $2, $3, $4, $5, $6, $7, $8, $9, $10 )';
		$result = pg_query_params($conn, $sql, array($userid, $salu, $fname, $lname, $prov, $city, $addr, $postal_code, $phone, $contact));
		echo $i." - - - ".$result."<br><br>";
		
	}
}


//@param	conn pg_connection		database connection string
//@param	num_records integer		number of loop iterations
//created by Taha Amjad on Nov 15	
function seed_listings($conn, $num_records = 10) {
	$street_file = './includes/seed data/streets';
	$title_file = './includes/seed data/listing_titles.txt';
	//$descr_file = './includes/seed data/listing_descr.txt'; //no descr file (using title file only)

	for ($i = 0; $i<$num_records; $i++) {
		
		
		$agentid = get_random_agentid();
		$userid = get_userid($agentid);
		
		//title and description of the listing
		$title = trim(random_line($title_file));
		$descr1 = trim(random_line($title_file));
		$descr2 = trim(random_line($title_file));
		$descr3 = trim(random_line($title_file));
		$description = $descr1." ".$descr2." ".$descr3;
		
		//address
		$street = trim(random_line($street_file));			//street name
		$num = mt_rand(100, 999);					//street number
		$addr = $num." ".$street;					//random full address
		
		$postal_code = chr(65 + mt_rand(0, 25)).mt_rand(0, 9).chr(65 + mt_rand(0, 25))." ".mt_rand(0, 9).chr(65 + mt_rand(0, 25)).mt_rand(0, 9); //random postal code 
		$prov = random_opt_value('provinces');			//random province
		$city = random_opt_value('cities');				//random cities
		
		$type = random_opt_value('building_types'); //random building types
		$heat = random_opt_value('heating'); //random heating types
		$elec = random_opt_value('electricity'); //random electricity types
		$status = random_opt_value('listing_status'); //random status of listing
		
		$opt = mt_rand(0, 256); //values that can be represented by 1 byte (i.e. 8 options)
		
		$year = mt_rand(1900,2012); //random year starting from 1900 until 2012
		$size = mt_rand(5000,15000); //random size between 5000sqft to 15000sqft
		$price = mt_rand(50000,5000000); //random price between $50,000 and $5,000,000		

		$bed = mt_rand(1, 5); //random number of bedrooms from 1 to 5
		$bath = mt_rand(1, 5);//random number of bathrooms from 1 to 5


		//update db with new listing
		$sql = 'INSERT INTO listings 
			(userid, agentid, title, address, city, province, postal_code, building_type, description, year, price, heating, elec, num_bedrooms, num_bathrooms, options, sqfeet, status) 
			VALUES ( $1, $2, $3, $4, $5, $6, $7, $8, $9, $10, $11, $12, $13, $14, $15, $16, $17, $18 )';
		$result = pg_query_params($conn, $sql, array($userid, $agentid, $title, $addr, $city, $prov, $postal_code, $type, $description, $year, $price, $heat, $elec, $bed, $bath, $opt, $size, $status));
		echo $i." - - - ".$result."<br><br>";

	}
}


//***string random_opt_value(string)
//@param 	a database title witha field 'name'
//@return	a single field from a record 
//fixed up by Taha Amjad on Nov 14
function random_opt_value($dbname) {
	$conn = db_connect();
	//$sql = "SELECT property FROM ";
	$sql = "SELECT value FROM "; //to get the binary equivalent of the property Dec 05, 2012
	$sql .= $dbname;
	//$sql .= " WHERE utype = 'a'";
	$result = pg_query($conn, $sql);
	$opt = pg_fetch_result($result, mt_rand(0, pg_num_rows($result)-1), 0);
	return $opt;
}

//@param	no parameters
//@return	a single agentid from the whole list
//created by Taha Amjad on Nov 15
function get_random_agentid() {
	$conn = db_connect();
	$sql = "SELECT agentid FROM agents INNER JOIN users ON (users.userid = agents.userid) WHERE (users.utype = 'a' OR users.utype = 'd')";
	$result = pg_query($conn, $sql);
	$id = pg_fetch_result($result, mt_rand(0, pg_num_rows($result)-1), 0);
	return $id;
}

//@param	agentid 
//@return	userid of the given agent
//create by Taha Amjad on Nov 15
function get_userid($agentid) {
	$conn = db_connect();
	$sql = "SELECT userid FROM agents WHERE agentid = '".$agentid."'";
	$result = pg_query($conn, $sql);
	
	return pg_fetch_result($result, 'userid');
}


//***char random_utype()
//@return	a char representing the user type
//fixed up by Taha Amjad on Nov 14
function random_utype() {
	$num = mt_rand(1, 3);
	switch ($num) {	
		case ($num == 1):
			$utype = 'p'; //pending
			break;
		case ($num == 2):
			$utype = 'a'; //agent
			break;
		case ($num == 3):
			$utype = 'd'; //denied agent
			break;
	}
	
	return $utype;
}


//***string random_line(string)
//@param	the file to read from
//@return	a line from the file
function random_line($filename) { 
	$lines = file($filename) ; 
	return $lines[array_rand($lines)] ; 
} 

// Added for shorter/cleaner if logic - Ale
function is_set($temp) {
	if (!isset($temp) || $temp == "")
	{
		$result = false;
	}
	else 
	{
		$result = true;
	}
	return $result;
}

// Added to shorten header code for links - Ale
function usertype_link($link, $display) {
	echo "<li><a href='$link'>$display</a></li>";
}

function sum_array($arg) {
	$sum = 0;
	if(is_array($arg))
	{
		for ($i = 0; $i < sizeof($arg); $i++)
		{
			if(is_numeric($arg[$i]))
				$sum += $arg[$i];
		}
	}
	return $sum;
}

function isBitSet($pow, $num) {
	return (pow(2, $pow) & $num);
}

function format_currency($value){
	$end = 0;
	$end = $end + strlen($value);
	$remainder = $end%3;
	$new_value = substr($value, 0, $remainder);
	
	
		for($i = $remainder; $i < $end; $i+=3)
		{
			if($remainder > 0){
			$new_value .= ",";
			}
			$new_value .= substr($value, $i, 3);
			
			
		}
	return $new_value;
}


?>