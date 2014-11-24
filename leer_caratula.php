<?php 
require_once('Connections/gestor.php');
//$caratula=$_POST['caratula'];
$caratula="59208";
$query = "SELECT * FROM caratula WHERE caratula='$caratula' LIMIT 1";
$result = mysql_query($query);
$result = mysql_fetch_assoc($result);
echo $result['caratula']."<br>";
echo $result['email']."<br>";
