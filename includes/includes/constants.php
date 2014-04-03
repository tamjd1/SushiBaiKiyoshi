<?php
/*
Group 12
Date: 10/02/2012
*/

//user lengths
define("MIN_UID_LENGTH", 5);
define("MAX_UID_LENGTH", 32);
define("MIN_PASS_LENGTH", 6);
define("MAX_PASS_LENGTH", 256);
define("MAX_FNAME_LENGTH", 32);
define("MAX_LNAME_LENGTH", 32);
define("MAX_EMAIL_LENGTH", 128);
define("MAX_ADDRESS_LENGTH", 50);
define("POSTAL_CODE_LENGTH", 6);
define("PHONE_LENGTH", 10);
//sizes below are in square feet
define("MIN_PROPERTY_SIZE", 500); //added by Taha Amjad on Nov. 03
define("MAX_PROPERTY_SIZE", 5000); //added by Taha Amjad on Nov. 03
define("MIN_PROPERTY_PRICE", 50000); //added by Taha Amjad on Nov. 03
define("MAX_PROPERTY_PRICE", 10000000); //added by Taha Amjad on Nov. 03
define("MAX_CITY_LENGTH", 40);
define("PREF_CONTACT_LENGTH", 1);
define("HOST", "localhost"); //added by Taha Amjad on Nov. 10
define("DB_NAME", "group12_db"); //added by Taha Amjad on Nov. 10
define("DB_USERID", "group12_admin"); //added by Taha Amjad on Nov. 10
define("DB_PASS", "dbP@ssw0rd"); //added by Taha Amjad on Nov. 10
define("MAX_IMAGE_SIZE", 3000000);
define("MAX_LISTING_IMAGES", 6);
define("LISTINGS_PER_PAGE", 10);

//user types
define("ADMIN", "z");
define("PENDING", "p");
define("AGENT", "a");
//define("USER", "u");
define("DISABLED", "d");

define("MAX_ATTEMPTS", 10);
define("MIN_AREA_CODE", 100);
define("MAX_AREA_CODE", 999);

// listing status
define("OPEN", "o");
define("CLOSED", "c");
define("SOLD", "s");
?>