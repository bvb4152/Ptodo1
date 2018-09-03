<?php


class Auth 
{
	
    public $authStatus=0;
    public $u_name='';
    public $u_id='';

	function __construct()
	{
		global $db;
		//verify auth

		 if (!isset($_COOKIE["todo_hash"])) return 0;
         $Q_Hash=htmlspecialchars(trim(substr($_COOKIE["todo_hash"] , 0 , 70))); 
         if (empty($Q_Hash)) return 0;

         $result = $db->run("SELECT idUser, Name FROM users WHERE hash = ".$db->sql_prepare($Q_Hash)." ");
         if ($result->num_rows==1){
                $row = mysqli_fetch_assoc($result);
                $this->u_name = $row['Name'];
                $this->u_id   = $row['idUser'];
                $this->authStatus=1;
         	 }        

         $result->close();	 

	}
 

   function GetAuthStatus(){
    
      return $this->authStatus;

   }
}
?>