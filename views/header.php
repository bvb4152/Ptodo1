<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <link href="css/main.css" rel="stylesheet" type="text/css" />

    <title>TODO</title>
  </head>
  <body>
<table width=100% border=0 cellspacing="0" cellpadding="0" >
<tr ID="TopLine" >
<td><h1>TODO</h1></td>	
<td align="right"> 
	
<?php 
  

  if (($_REQUEST["action"]=="dashboard") &&  @$_REQUEST["arhiv"]=="1" )
  	echo '<a href="index.php?action=dashboard&arhiv=0">Now</a> ';
  else 
  	echo '<a href="index.php?action=dashboard&arhiv=1">Arhiv</a> ';
?>

</td>	
<td align="right"> 

<?php

if ($auth->GetAuthStatus()) echo '<a href="index.php?action=logout">LogOut</a>';

?>
	&nbsp;&nbsp;&nbsp;&nbsp;</td>	

</tr>
</table>

