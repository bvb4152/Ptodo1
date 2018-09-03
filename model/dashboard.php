<?php



class DashBoard 
{

	Public $msg='';
	Public $aProjects=[];
	Public $aTasks=[];
	
	function __construct()
	{
		

		if (isset($_REQUEST['event']	))
		switch($_REQUEST['event'])
		{ 
			case "addProject" :
			    $this->addProject();
				break;
			case "addTask" :
			    $this->addTask();
				break;

			default : 
			break;
		}


		if (isset($_REQUEST['taskevent']	))
		switch($_REQUEST['taskevent'])
		{ 
			case "del" :
			    $this->delTask();
				break;
			case "done" :
			    $this->DoneTask();
				break;
			case "save" :
			    $this->saveTask();
				break;

			default : 
			break;
		}


		if (isset($_REQUEST['projectevent']	))
		switch($_REQUEST['projectevent'])
		{ 
			case "del" :
			    $this->delProject();
				break;
			case "save" :
			    $this->saveProject();
				break;

			default : 
			break;
		}




		$this->init();

	}
//---------------------------------------------------

	function init()
	{
		global $db;
		 //fill data arrays from database

      if (@$_REQUEST["arhiv"]=="1")
         $str_filter=" projects.Archive=1  ";
      	else
         $str_filter=" projects.Archive=0 AND (tasks.IDTasksStatus=1 or tasks.IDTasksStatus is null)";


		$sql="SELECT ".
		"	projects.IDproject,".
		"	projects.Name,".
		"	projects.color,".
		"   count(tasks.Name) as CT".
		" FROM projects LEFT JOIN tasks ON projects.IDproject = tasks.IDproject".
		" WHERE    ".$str_filter.
		" GROUP BY ".
		"	projects.IDproject,".
		"	projects.Name,".
		"	projects.color".
		" ORDER BY ".
		"	projects.Name".
		"";


        $this->aProjects=[];
        $result = $db->run($sql);			
         while( $row = mysqli_fetch_assoc($result) ){ 
         	$this->aProjects[] = ["IDproject"=>$row['IDproject'], "Name"=>$row['Name'], "CT"=>$row['CT'], "color"=>$row['color']];
        } 
        
        $result->close();


       //filter tasks
       $taskFilter="";
       if (!isset($_REQUEST['FilterProject']	)) $_REQUEST['FilterProject'] = "today";

       if ($_REQUEST['FilterProject']=="today") $taskFilter=" AND (tasks.DeadLine>= CURDATE()  AND tasks.DeadLine<(CURDATE() + 1) )";
       if ($_REQUEST['FilterProject']=="SevenDays") $taskFilter=" AND (tasks.DeadLine>= CURDATE()  AND tasks.DeadLine<(CURDATE() + 7) )";
       if ($_REQUEST['FilterProject']=="all")   $taskFilter=" ";

       if (@$_REQUEST["arhiv"]=="1") $taskFilter=" ";

       $tmp_id=(int )$_REQUEST['FilterProject'];
       if ($tmp_id>0 )                          $taskFilter=" AND  projects.IDproject=".$_REQUEST['FilterProject'];

       	
      if (@$_REQUEST["arhiv"]=="1")
         $str_filter=" projects.Archive=1  ".$taskFilter;
      	else
         $str_filter=" projects.Archive=0 AND tasks.IDTasksStatus=1 ".$taskFilter;

       $sql=''.
        'SELECT '.
        '    tasks.IDTask,'.
        '    tasks.Name as	tasksName,'.
        '    tasks.DeadLine,'.
        '    projects.IDproject,'.
        '	 projects.Name as projectsName,'.
        '    projects.Color as projectColor,'.
        '    taskspriority.IDTasksPriority ,'.
        '    taskspriority.Name as priorityname,'.
        '    taskspriority.color as prioritycolor,'.
        '    tasksstatus.IDTasksStatus,'.
        '    tasksstatus.Name as tasksstatusname '.
        ' FROM tasks INNER JOIN projects ON projects.IDproject = tasks.IDproject'.
        '            INNER JOIN taskspriority ON taskspriority.IDTasksPriority = tasks.IDTasksPriority'.
        '            INNER JOIN tasksstatus ON tasksstatus.IDTasksStatus = tasks.IDTasksStatus '.
        ' WHERE    '.$str_filter.
        ' Order by '.
        ' (    CASE'.
        '     WHEN tasks.DeadLine < CURDATE() THEN 1'.
        '     ELSE 0'.
        '     END '.
        ' ) DESC,'.
        ' taskspriority.IDTasksPriority DESC,'.
        ' tasks.DeadLine '.
        '';


        $this->aTasks=[];
        $result = $db->run($sql);			
         while( $row = mysqli_fetch_assoc($result) ){ 
         	$this->aTasks[] = [
         	                   "IDTask"         =>$row['IDTask'], 
         	                   "IDproject"      =>$row['IDproject'], 
         	                   "tasksName"      =>$row['tasksName'], 
         	                   "DeadLine"       =>$row['DeadLine'], 
         	                   "projectsName"   =>$row['projectsName'],
         	                   "projectColor"   =>$row['projectColor'],
         	                   "IDTasksPriority"=>$row['IDTasksPriority'],
         	                   "priorityname"   =>$row['priorityname'],
         	                   "prioritycolor"  =>$row['prioritycolor'],
         	                   "IDTasksStatus"  =>$row['IDTasksStatus'],
         	                   "tasksstatusname"=>$row['tasksstatusname']
         	                  ];
        } 
        
        $result->close();



	}
//---------------------------------------------------


	function ListProject($id=0)
	{
		 global $db;

		 echo '<select id="select" Name="IDProject"  >';
		 echo '<option style="color:gray" value="null">select project</option>';

		 $result = $db->run("SELECT IDProject, Name, Color FROM projects WHERE Archive=0 ORDER BY Name");
         while( $row = mysqli_fetch_assoc($result) ){ 
          echo '<option '.(($id==$row['IDProject'])?" selected ":"").' style="color:'.$row['Color'].'" value="'.$row['IDProject'].'">'.$row['Name'].'</option>';
        } 

      echo '</select>';
      $result->close();
	}
//---------------------------------------------------


	function ListTasksPriority($id=0)
	{
		 global $db;

		 echo '<select id="select" Name="IDTasksPriority">';

		 $result = $db->run("SELECT IDTasksPriority,Name, Color FROM taskspriority");
         while( $row = mysqli_fetch_assoc($result) ){ 
          echo '<option '.(($id==$row['IDTasksPriority'])?" selected ":"").' style="color:'.$row['Color'].'" value="'.$row['IDTasksPriority'].'">'.$row['Name'].'</option>';
        } 

      echo '</select>';
      $result->close();
	}
//---------------------------------------------------


	function ListTasksStatus()
	{
		 global $db;

		 echo '<select id="select" Name="IDTasksStatus">';

		 $result = $db->run("SELECT IDTasksStatus, Name FROM tasksstatus");
         while( $row = mysqli_fetch_assoc($result) ){ 
          echo '<option style="color:'.$row['Color'].'" value="'.$row['IDTasksStatus'].'">'.$row['Name'].'</option>';
        } 

      echo '</select>';
      $result->close();
	}
//---------------------------------------------------



	function	addProject(){
     	global $db;

     	$ProjectName  =  substr(trim($_REQUEST["ProjectName"])      , 0 , 50) ;
     	$ProjectColor =  substr(trim($_REQUEST["ProjectColor"])     , 0 , 50) ;

        $result = $db->run("SELECT IDProject, Name FROM projects WHERE Name like ".$db->sql_prepare($ProjectName)." ");
        if ($result->num_rows>0)     {$this->msg="<font color=red>Project already exists <b>".$ProjectName."<b></font>";           return; }
        
        $db->run("INSERT INTO projects (Name, Color, Archive) VALUES (".$db->sql_prepare($ProjectName).",".$db->sql_prepare($ProjectColor)." ,0)");

	}
//---------------------------------------------------


	function	delProject(){
     	global $db;
        
        $IDProject  =  (int)substr(trim($_REQUEST["idproject"])      , 0 , 50) ;
     	
     	if ($IDProject==0)     {$this->msg="<font color=red>Project not  set <b>".$IDProject."<b></font>";           return; }


        $result = $db->run("SELECT IDTask FROM tasks WHERE IDTasksStatus=1 and IDProject=".$db->sql_prepare($IDProject)." ");
        if ($result->num_rows>0)     {$this->msg="<font color=red>All tasks must be completed</font>";           return; }

        $db->run("DELETE FROM tasks      WHERE IDProject=".$db->sql_prepare($IDProject)."; ");
        $db->run("DELETE FROM projects    WHERE IDProject=".$db->sql_prepare($IDProject)."; ");



	}
//---------------------------------------------------



	function	saveProject(){
     	global $db;
        $IDProject    =  (int)substr(trim($_REQUEST["idproject"])      , 0 , 50) ;
     	$ProjectName  =       substr(trim($_REQUEST["ProjectName"])      , 0 , 50) ;
     	$ProjectColor =       substr(trim($_REQUEST["ProjectColor"])     , 0 , 50) ;

     	if ($IDProject==0)     {$this->msg="<font color=red>Project not  set <b>".$IDProject."<b></font>";           return; }
        $db->run("UPDATE  projects SET Name=".$db->sql_prepare($ProjectName).", Color=".$db->sql_prepare($ProjectColor)." WHERE idproject=".$IDProject." ");

	}
//---------------------------------------------------


	function	addTask(){
     	global $db;

		$TaskName        =       substr(trim($_REQUEST["TaskName"])       , 0 , 50) ;
		$IDProject       =  (int)substr(trim($_REQUEST["IDProject"])      , 0 , 50) ;
		$IDTasksPriority =  (int)substr(trim($_REQUEST["IDTasksPriority"]), 0 , 50) ;
	  //$IDTasksStatus   =  (int)substr(trim($_REQUEST["IDTasksStatus"])  , 0 , 50) ;
		$IDTasksStatus   = 1; //run
		$Date            =       substr(trim($_REQUEST["Date"])           , 0 , 50) ;
        

        if ($IDProject==0)  {$this->msg="<font color=red>Select Project </font>";        return; }
        if (!strlen($Date))       {$this->msg="<font color=red>Select Deadline date </font>";  return; }

        $result = $db->run("SELECT IDTask, Name FROM tasks WHERE IDProject=".$IDProject."  AND  Name like ".$db->sql_prepare($TaskName)." ");
        if ($result->num_rows>0)     {$this->msg="<font color=red>Task already exists <b>".$TaskName."<b></font>";           return; }

      //  $result = $db->run("SELECT IDProject, Name FROM projects WHERE Name like ".$db->sql_prepare($ProjectName)." ");
       // if ($result->num_rows>0)     {$this->msg="<font color=red>Project already exists <b>".$ProjectName."<b></font>";           return; }
        
        $db->run("INSERT INTO tasks( IDProject, DeadLine, IDTasksStatus, IDTasksPriority, Name) 
        	      VALUES (".$IDProject.",  ".$db->sql_prepare($Date).", ".$IDTasksStatus." ,".$IDTasksPriority.",  ".$db->sql_prepare($TaskName)." )");

	}
//---------------------------------------------------





	function	delTask(){
     	global $db;

        $IDTask   =  (int)substr(trim($_REQUEST["idtask"])      , 0 , 50) ;
     	if ($IDTask ==0)     {$this->msg="<font color=red>IDTask not  set <b>".$IDTask."<b></font>";           return; }

        $db->run("DELETE FROM tasks  WHERE idtask=".$db->sql_prepare($IDTask )."; ");

	}
//---------------------------------------------------

	function	DoneTask(){
     	global $db;

        $IDTask   =  (int)substr(trim($_REQUEST["idtask"])      , 0 , 50) ;
     	if ($IDTask ==0)     {$this->msg="<font color=red>IDTask not  set <b>".$IDTask."<b></font>";           return; }
       
       // done
       $db->run("Update tasks set IDTasksStatus=10  WHERE idtask=".$db->sql_prepare($IDTask )."; ");
       

       //if all tasks done, move project in archiv
       $sql=" Select IDTask from tasks  ".
			" WHERE ".
						" IDTasksStatus=1 AND".
				" IDProject in ".
				" (SELECT IDProject FROM tasks as T1 WHERE IDTask=".$IDTask .")" ;
       $result = $db->run($sql);				
       if ($result->num_rows==0)    
       $db->run("Update projects set Archive=1  WHERE IDProject in (SELECT IDProject FROM tasks as T1 WHERE IDTask=".$IDTask .")");

	}
//---------------------------------------------------

	function	saveTask(){
     	global $db;

        $IDTask          =  (int)substr(trim($_REQUEST["IDTask"])         , 0 , 50) ;
		$TaskName        =       substr(trim($_REQUEST["TaskName"])       , 0 , 50) ;
		$IDProject       =  (int)substr(trim($_REQUEST["IDProject"])      , 0 , 50) ;
		$IDTasksPriority =  (int)substr(trim($_REQUEST["IDTasksPriority"]), 0 , 50) ;
	  //$IDTasksStatus   =  (int)substr(trim($_REQUEST["IDTasksStatus"])  , 0 , 50) ;
		$IDTasksStatus   = 1; //run
		$Date            =       substr(trim($_REQUEST["Date"])           , 0 , 50) ;
        

        if ($IDTask==0)           {$this->msg="<font color=red>NO  IDTask </font>";            return; }
        if ($IDProject==0)        {$this->msg="<font color=red>Select Project </font>";        return; }
        if (!strlen($Date))       {$this->msg="<font color=red>Select Deadline date </font>";  return; }


        
        $db->run("UPDATE  tasks SET  IDProject=".$IDProject.", ".
        	                        " DeadLine=".$db->sql_prepare($Date).",  ".
        	                        " IDTasksStatus=".$IDTasksStatus.",  ".
        	                        "  IDTasksPriority=".$IDTasksPriority.",  ".
        	                        "  Name=".$db->sql_prepare($TaskName)."  ".
        	      " WHERE IDTask=".$IDTask." ");

	}
//---------------------------------------------------



}
?>