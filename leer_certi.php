<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<!--<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />-->
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Leer Certificado</title>
</head>

<body>
<?php
//funcion para encontrar el numero de veces que aparece la cadena by linkgl
function contar($palabra,$ruta)
{
  $contador=0; //seteamos contador a 0
  $archivo=$ruta; //obtenemos el texto del archivo
  while(strpos($archivo,$palabra)!=false) //si todavia hay palabras
  {
    $buscar=strpos($archivo,$palabra); //buscamos si esta la palabra en alguna posiciophpn
    $archivo=substr($archivo,$buscar+strlen($palabra)); //si es asi cortamos la palabra
    $contador++; //incrementamos el contador
  }
  return $contador;
}

//uso

	$texto1="";
//  $ar=fopen("c:\\sysvol\\appl\\folio\certi.txt","r") or
  $ar=fopen("c:\\certi.txt","r") or
    die("No se pudo abrir el archivo");
  while (!feof($ar))
  {
    $linea=fgets($ar);
    $lineasalto=nl2br($linea);
    $texto1=$texto1.$lineasalto;
  }
  fclose($ar);
  
//  echo "<br /> ".contar("LUIS A.",$texto1)."<br /> ";
  $texto1= iconv("CP850","ISO-8859-1", $texto1); //FUNCION PHP 5.0 EN ADELANTE
  $texto1= str_replace('Ð','Ñ',$texto1); //Ñ
  $texto1= str_replace('±','ñ',$texto1); //ñ
  $texto1= str_replace('Â ','á',$texto1); //á
  $texto1= str_replace('','é',$texto1); //é
  $texto1= str_replace('Âí','í',$texto1); //í
  $texto1= str_replace('¾','ó',$texto1); //ó
  $texto1= str_replace('·','ú',$texto1); //ú
  
echo "<p>".$texto1."</p>";
?>
</body>
</html>