<?php
ob_start();
session_start();

//database credentials
define('DBHOST','127.0.0.1');
define('DBUSER','sandra');
define('DBPASS','tiger');
define('DBNAME','beautifymycity');

//application address
define('DIR','http://127.0.0.1/');
define('SITEEMAIL','cecminiproject@yandex.com');

try {

	//create PDO connection
	$db = new PDO("mysql:host=".DBHOST.";dbname=".DBNAME, DBUSER, DBPASS);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $mysqli = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);

} catch(PDOException $e) {
	//show error
    echo '<p class="bg-danger">'.$e->getMessage().'</p>';
    exit;
}

//include the user class, pass in the database connection
include('classes/user.php');
include('classes/phpmailer/mail.php');
$user = new User($db);
?>
