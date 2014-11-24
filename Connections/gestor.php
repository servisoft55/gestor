<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_gestor = "localhost";
$database_gestor = "gestor";
$username_gestor = "root";
$password_gestor = "";
$gestor = mysql_pconnect($hostname_gestor, $username_gestor, $password_gestor) or trigger_error(mysql_error(),E_USER_ERROR); 
mysql_select_db($database_gestor, $gestor);
?>