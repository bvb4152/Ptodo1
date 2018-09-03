<?php
ini_set('display_errors', 1);



require_once("_config.php"); 
require_once("lib/db.php"); 
require_once("lib/auth.php"); 

$db = new DB;
$auth= new Auth;

//echo $auth->GetAuthStatus();



//$result = $db->run("SELECT idUser FROM users ");
 


require_once("views/header.php"); 
//default page
if (!isset($_GET['action'])) $_GET['action']='register';

switch($_GET['action'])
{ 
	case "login" :
		require_once("model/login.php"); 
		require_once("views/login.php"); 
		break;

	case "logout" :
		require_once("model/logout.php"); 
		break;

	case "register" :
		require_once("model/register.php"); 
		require_once("views/register.php"); 
		break;

	case "dashboard" :
		require_once("model/dashboard.php"); 
		require_once("views/dashboard.php"); 
		break;


	default : 
		require_once("views/page404.php"); 
	break;
}


require_once("views/footer.php"); 

?>