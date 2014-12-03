
<?php 
$var1="alarmarsp@gmail.com";
$var2="Correo gmail raul";
$var3="Este es el mensaje"

//$foo = "<a href='mailto:youremail@mail.com?from=contacto@cbrchillan.cl&body=Mensaje del Correo&attachment="."C:\\xampp\\htdocs\\gestor\\firmados\\2j0YFxTf1385567218_firmado.pdf"."'>Tu correo</a>";  
?>

<a href='mailto:<?php echo $var1; ?>?subject=<?php echo $var2; ?>&body=<?php echo $var3; ?> &attachment=""c:\vcredist.bmp""'>Enviar correo</a>


