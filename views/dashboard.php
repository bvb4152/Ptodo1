
<?php

$Dashb = new DashBoard();

//echo '<pre>'.var_export($_REQUEST).'</pre>';
//echo '<pre>'.var_export($Dashb->aProjects).'</pre>';

 ?>

<table width=100% height=100% align="center" border=0 >
<tr><td><?php echo $Dashb->msg; ?> </td><td> </td> </tr>
<tr> 

<!-- List Project -->
    <td align="left" width=20% valign=top style="padding-left: 10px;">
    <?php
    if (@$_REQUEST["arhiv"]!="1")
    echo ''.
        '<a href="index.php?action=dashboard&FilterProject=today">Today</a><br>'.
        '<a href="index.php?action=dashboard&FilterProject=SevenDays">Next 7 days</a><br>'.
        '';
    ?>
       <a href="index.php?action=dashboard&FilterProject=all<?php echo '&arhiv='.@$_REQUEST["arhiv"] ?>"  >All Projects</a><br>
    <br>
    <br>
     
       <table border=0 ID="tProject" >
     <?php

      foreach ($Dashb->aProjects as $row) {
          
          if (@$_REQUEST["projectevent"]=="edit"  && $_REQUEST["idproject"]==$row["IDproject"] )
          { 
            //edit form
            echo '<form action="index.php?action=dashboard&FilterProject='.$_REQUEST['FilterProject'].'" method="POST">';
            echo '<tr><td colspan=2>';
            echo '<input type="text" required size="5" name="ProjectName"   value="'.$row["Name"].'" >';
            echo '<input type="color"  name="ProjectColor" value="'.$row["color"].'">';
            echo '<input type="Submit" Name="Submit" value="Save">';
            echo '<input type="hidden" Name="idproject" value="'.$row["IDproject"].'">';
            echo '<input type="hidden" Name="projectevent" value="save">';
            echo '</tr>';
            echo '</form>';
            

          }
          else {
          
          if ($row["CT"]>0) $row["CT"]=" (".$row["CT"].")";
          echo'<tr><td><font color="'.$row["color"].'"> &#9679</font> <a href="index.php?action=dashboard&arhiv='.@$_REQUEST["arhiv"].'&FilterProject='.$row["IDproject"].'">'.$row["Name"].$row["CT"].'</a></td>'.
          '<td>';
          
           if (@$_REQUEST["arhiv"]!="1")
           echo  
          '<font size=-4 >'.
             ' <a href="index.php?action=dashboard&FilterProject='.$_REQUEST['FilterProject'].'&idproject='.$row["IDproject"].'&projectevent=edit">Edit</a>'.
             ' <a href="index.php?action=dashboard&FilterProject='.$_REQUEST['FilterProject'].'&idproject='.$row["IDproject"].'&projectevent=del">Del</a>'.
          '</font>';
          

          echo '</td>'.
               '</tr>';
          }

         }


     ?>
      </table>

     <br>
     <br>
     <br>
     <?php  if (@$_REQUEST["arhiv"]!="1") {?>
     <table width=100%  ID="TaddP" Name="TaddP" border=0 style="">
     <form action="index.php?action=dashboard<?php echo '&FilterProject='.$_REQUEST['FilterProject'] ?>" method="POST">
     <tr><td><b>Add Project</b></td></tr>
     <tr><td><input type="text"   name="ProjectName"  required placeholder="Name Project"  value="" ></td></tr>
     <tr><td><input type="color"  name="ProjectColor" required placeholder="Color"  value="">
             <input type="Submit" Name="Submit" value="Add">
     </td></tr>
     <tr><td></td></tr>
     <input type="hidden" Name="event" value="addProject">

     </form>
     </table>

     <?php }  ?>

     </td>
 



 <!-- List Task -->
    <td align="left" valign=top  width=80% style="padding-left: 30px;" > &nbsp;
     
    <table width=100%  ID="TListTask"   border=0 style="">
    <tr>
       <td><i>Task</td>
       <td></td>
       <td><i>Deadline, day</td>
       <td><i>Project</td>
       <td></td>
    </tr>
    
     <?php

      foreach ($Dashb->aTasks as $row) {

     if (@$_REQUEST["taskevent"]=="edit"  && $_REQUEST["idtask"]==$row["IDTask"] )
     {

            //edit form
            echo '<form action="index.php?action=dashboard&FilterProject='.$_REQUEST['FilterProject'].'" method="POST">';
            echo '<tr><td colspan=5>';
            echo '<input type="text" required size="5" name="TaskName"   value="'.$row["tasksName"].'" >';
            $Dashb->ListProject($row["IDproject"]) ; 
            $Dashb->ListTasksPriority($row["IDTasksPriority"]);

            echo '<input type="date" Name="Date" value="'.$row["DeadLine"].'"> ';
            echo '<input type="Submit" Name="Submit" value="Save">';
            echo '<input type="hidden" Name="IDTask" value="'.$row["IDTask"].'">';
            echo '<input type="hidden" Name="taskevent" value="save">';
            echo '</tr>';
            echo '</form>';

     }

      else {
            //overtime
            $mday=(int)ceil( (strtotime($row["DeadLine"])-time())/(60*60*24));
            if ($mday<0) $line_color='style="color:red;"';
                    else $line_color='';
            echo '<tr '.$line_color.' ">'.
                    '<td id="TDtasks" ><font color="'.$row["prioritycolor"].'"><b title="'.$row["priorityname"].'">&#9632;</b></font>'.' <big>'.$row["tasksName"].'</big></td>';
               echo '<td id="TDtasks" >';
                      if (@$_REQUEST["arhiv"]!="1")
                      echo ' <a href="index.php?action=dashboard&FilterProject='.$_REQUEST['FilterProject'].'&idtask='.$row["IDTask"].'&taskevent=done">Done</a>'.'';
              echo '</td>';
            
            echo '<td id="TDtasks"  title="'.$row["DeadLine"].'" > '.$mday.'</td>'.
                    '<td id="TDtasks" ><font color="'.$row["projectColor"].'"> &#9679</font> '.$row["projectsName"].' </td>'.
                    '<td id="TDtasks" > &nbsp;';
                      
                     if (@$_REQUEST["arhiv"]!="1")
                     echo '<font size=-4 >'.
                          ' <a href="index.php?action=dashboard&FilterProject='.$_REQUEST['FilterProject'].'&idtask='.$row["IDTask"].'&taskevent=edit">Edit</a>'.
                          ' <a href="index.php?action=dashboard&FilterProject='.$_REQUEST['FilterProject'].'&idtask='.$row["IDTask"].'&taskevent=del">Del</a>'.
                     '</font>';

            echo '</td>'.
                '</tr>';
           }            

         }




     ?>



    <tr>
       <td colspan=5>
           
            <?php  if (@$_REQUEST["arhiv"]!="1") {?>
            <table width=100%  ID="TaddP" Name="TaddP" border=0 style="">
            <form action="index.php?action=dashboard<?php echo '&FilterProject='.$_REQUEST['FilterProject'] ?>" method="POST">
            <tr><td><b>Add task</b></td></tr>
            <tr><td><input type="text"   name="TaskName"  required placeholder="Name Task"  value="" >
                    <?php $Dashb->ListProject() ?>
                    <?php $Dashb->ListTasksPriority() ?>
                    <?php //$Dashb->ListTasksStatus() ?>
                    <input type="date" Name="Date" >
                    <input type="hidden" Name="event" value="addTask">
                    <input type="Submit" Name="Submit" value="Add">

            </td></tr>
            </form>
            </table>
            <?php }  ?>

       </td>
    </tr>


  


     </td>

</tr>
</table>





