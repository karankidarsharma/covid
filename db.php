<?php 

define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
// I did not set the password for this so I am just passing an empty string below
define('DB_PASSWORD',"");
define('DB_NAME', 'omni');


// connecting to the database
$con = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// testin connection with database

if($con === false){
    die("error: unable to connect". $con->connect_error);
}


?>