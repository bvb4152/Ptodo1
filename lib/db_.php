<?php



class DB
{

    public static  $pdo;

    public function __construct()
    {
       
        try 
        {
            
			$dsn = 'mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset='.DB_CHAR;
 			$opt = [
        				PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        				PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        				PDO::ATTR_EMULATE_PREPARES   => false,
    				];

			self::$pdo  = new PDO($dsn, DB_USER, DB_PASS, $opt);

        } catch (PDOException $e) {
            echo '<br>Connection DB error '.$e->getMessage().' <br>';
        }
        
        return self::$pdo;
    }

   public  function run($sql, $args = [])
   {

     try
        { 
     		$stmt = self::$pdo->prepare($sql);
     		$stmt->execute($args);

 		} catch (PDOException $e) {
             echo '<br>SQL error '.$e->getMessage().' <br>';
             return false;
        }     		

     return $stmt;
   }

 


}//class DB



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



/*

foreach ($stmt as $row)
{
    echo $row['name'] . "\n";
}
*/
//$db->connect();






?>