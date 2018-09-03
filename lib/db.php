<?php



//--------------------------------------------------------
class DB
{

    public static  $link;

    public function __construct()
    {
       
      
	self::$link = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);     

	if (self::$link->connect_error) {
    	die("<font color=red>Connection failed: " . self::$link->connect_error."</font>");
       } 

    }

   public  function run($sql)
   {

    if (!($result = mysqli_query(self::$link, $sql)))
  		{
          die("<font color=red>Error description: " . mysqli_error(self::$link)."</font> <br>".$sql);
        }
    return $result;

   }

 
//--------------------------------------------------------
function sql_prepare($str)
{
   return "'".str_replace("'","''",stripslashes($str))."'" ;
} 
//--------------------------------------------------------



}//class DB
//--------------------------------------------------------



?>