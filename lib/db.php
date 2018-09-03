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



/*
$db = new DB;

$result = $db->run('SELECT IDTasksStatus, Name from tasksstatus');



var_export($result->num_rows );
 while( $row = mysqli_fetch_assoc($result) ){ 
        printf("%s (%s)\n", $row['IDTasksStatus'], $row['Name']); 
    } 


 $result->close(); 

die();

$link = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);     
$result = mysqli_query($link, 'SELECT IDTasksStatus, Name from tasksstatus WHERE IDTasksStatus=99');
 
 
var_export($result->num_rows);
 while( $row = mysqli_fetch_assoc($result) ){ 
        printf("%s (%s)\n", $row['IDTasksStatus'], $row['Name']); 
    } 
*/
/*

$db = new db;

     		$stmt = $db::$pdo->query('SELECT * from tasksstatus');
     		//$stmt->execute(array('test'));
var_export($stmt);
die();


$stmt= $db->run('SELECT * from tasksstatus',array('test'));
var_export($stmt);

foreach ($stmt as $row)
{
    echo $row[1] . "\n";
    echo $row[2] . "\n";
}

var_export($stmt, TRUE);

*/

/*

foreach ($stmt as $row)
{
    echo $row['name'] . "\n";
}
*/
//$db->connect();






?>