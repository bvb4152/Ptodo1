
<?php

$u = new RegisterUser();
      
 ?>

<table width=100% align="center" border=0 >
<tr> <td align="center"> <h2>Register new user</h2></td></tr>
<tr> <td align="center"> &nbsp;</td></tr>
<tr>
<td align="center"> 
    <?php if ($u->RegistredStatus==1) { ?>

   <big><font color=green> User registred, please  <a href="index.php?action=login">Login</a>  </font><big>

   <?php } else {?>    
    <table>
    <form action="index.php?action=register" method="POST">

    <tr> <td align="center"  colspan=2 > <small> If you registred please <a href="index.php?action=login">Login</a> </small></td></tr>

     <tr>
     	<td><input type="text" name="Name" required placeholder="Name" value="<?php echo $u->u_name; ?>"></td>
     </tr>
     <tr>
     	<td><input type="email"  name="email" required placeholder="Email"  value="<?php echo $u->u_email; ?>"></td>
     </tr>

     <tr>
     	<td><input type="password" name="password" required placeholder="Password" value="<?php echo $u->u_pass; ?>"></td>
     </tr>

     <tr>
     	<td><input type="password" name="cpassword" required placeholder="Confirm password" value="<?php echo $u->u_cpass; ?>"></td>
     </tr>

     <tr>
     	<td  align="center">
     	<input type="hidden" Name="event" value="Register">
     	<input type="Submit" Name="Submit" value="Register">
     	</td>
     </tr>

    </form>
    </table>

    <?php }?>    

<tr> <td align="center"> &nbsp;</td></tr>

<tr> <td align="center"><?php echo $u->msg; ?> </td></tr>

</td>
</tr>
</table>



