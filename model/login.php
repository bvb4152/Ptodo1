<?php




class Login
{

  public $u_name='';
  public $u_id='';
  public $u_email='';
  public $u_pass='';
  public $msg='';
	
	function __construct()
	{
       global $auth;
       if ($auth->GetAuthStatus()) header('location: index.php?action=dashboard');

       if (isset($_REQUEST["event"])) $this->Authorization();
	}

 


 function Authorization(){
  global $db;

  $this->u_email  =  substr(trim($_REQUEST["email"])     , 0 , 50) ;
  $this->u_pass   =  substr(trim($_REQUEST["password"])  , 0 , 50) ;

  if (!strlen($this->u_email))  {$this->msg="<font color=red>Empty Email</font>";                    return; }
  if (!strlen($this->u_pass))   {$this->msg="<font color=red>Empty Pass confirm</font>";             return; }

  $result = $db->run("SELECT idUser, Name FROM users WHERE email like ".$db->sql_prepare($this->u_email)." AND pass='".md5($this->u_pass)."'");
  if ($result->num_rows!=1)     {$this->msg="<font color=red>Password or Email not found</font>";           return; }
  
  $row = mysqli_fetch_assoc($result);
  $this->u_name = $row['Name'];
  $this->u_id   = $row['idUser'];
  $result->close();
  
  
  //set hash
  $hash = md5(rand());
  $db->run("UPDATE  users SET hash='".$hash."' WHERE  idUser= ".$this->u_id." ");
  setcookie("todo_hash", $hash);

  header('location: index.php?action=dashboard');
  die();

 }


}

  ?>