
<?php

$u = new Login();
      
 ?>

<table width=100% align="center" border=0 >
<tr> <td align="center"> <h2>Login</h2></td></tr>
<tr> <td align="center"> &nbsp;</td></tr>
<tr>
<td align="center"> 

    <table>
    <form action="index.php?action=login" method="POST">

    <tr> <td align="center"  colspan=2 > <small> If you new user <a href="index.php?action=register">SignUp</a> </small></td></tr>

     <tr>
     	<td><input type="email"  name="email" required placeholder="Email"  value="<?php echo $u->u_email; ?>"></td>
     </tr>

     <tr>
     	<td><input type="password" name="password" required placeholder="Password" value="<?php echo $u->u_pass; ?>"></td>
     </tr>

     <tr>
     	<td  align="center">
     	<input type="hidden" Name="event" value="Login">
     	<input type="Submit" Name="Submit" value="Login">
     	</td>
     </tr>

    </form>
    </table>


<tr> <td align="center"> &nbsp;</td></tr>

<tr> <td align="center"><?php echo $u->msg; ?> </td></tr>

</td>
</tr>
</table>



