<?php




class RegisterUser
{

  public $u_name='';
  public $u_email='';
  public $u_pass='';
  public $u_cpass='';
  public $msg='';
  public $RegistredStatus=0;
	
	function __construct()
	{
       global $auth;
       if ($auth->GetAuthStatus()) header('location: index.php?action=dashboard');

       if (isset($_REQUEST["event"])) $this->create_user();
	}


	function create_user()
	{

      global $db;
      $this->u_name   =  substr(trim($_REQUEST["Name"])      , 0 , 50) ;
      $this->u_email  =  substr(trim($_REQUEST["email"])     , 0 , 50) ;
      $this->u_pass   =  substr(trim($_REQUEST["password"])  , 0 , 50) ;
      $this->u_cpass  =  substr(trim($_REQUEST["cpassword"]) , 0 , 50) ;

      
      if (!strlen($this->u_name ))          {$this->msg="<font color=red>Empty Name</font>";                     return; }
      if (!strlen($this->u_email))          {$this->msg="<font color=red>Empty Email</font>";                    return; }
      if (!strlen($this->u_name ))          {$this->msg="<font color=red>Empty Pass</font>";                     return; }
      if (!strlen($this->u_cpass))          {$this->msg="<font color=red>Empty Pass confirm</font>";             return; }
      if ($this->u_pass!=$this->u_cpass)    {$this->msg="<font color=red>Password and confirm not match</font>"; return; }

      //check dublicate in DB
      $result = $db->run("SELECT idUser FROM users WHERE email like ".$db->sql_prepare($this->u_email)." ");
      if ($result->num_rows>0)              {$this->msg="<font color=red>Email already exists</font>";           return; }
      $result->close();


      $db->run("INSERT INTO users( Name, email, pass, Hash) 
      	                 VALUES (".$db->sql_prepare($this->u_name).",
      	                         ".$db->sql_prepare($this->u_email).",
      	                         '".md5($this->u_cpass)."',
      	                         '') ");

      $this->RegistredStatus=1;

	}

}





?>