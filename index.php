<img src="imagen/firma.jpg" width="180" height="110">
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Sistema Documental Firma Eletrónica</title>
<script type="text/javascript">
function ajaxFunction() {
  var xmlHttp;
   
  try {
   
    xmlHttp=new XMLHttpRequest();
    return xmlHttp;
  } catch (e) {
    
    try {
      xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
      return xmlHttp;
    } catch (e) {
      
	  try {
        xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
        return xmlHttp;
      } catch (e) {
        alert("Tu navegador no soporta AJAX!");
        return false;
      }}}
}




function Enviar(_pagina,capa) {
    var ajax;
    ajax = ajaxFunction();
    ajax.open("POST", _pagina, true);
    ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    ajax.onreadystatechange = function() {
		if (ajax.readyState==1){
			document.getElementById(capa).innerHTML = " Aguarde por favor...";
			     }
		if (ajax.readyState == 4) {
		   
                document.getElementById(capa).innerHTML=ajax.responseText; 
		     }}
			 
	ajax.send(null);
} 

function Codigobarras(_pagina,capa) {
    var ajax;
    ajax = ajaxFunction();
    ajax.open("POST", _pagina, true);
    ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    ajax.onreadystatechange = function() {
      if (ajax.readyState==1){
          document.getElementById(capa).innerHTML = " Aguarde por favor...";
      }
      if (ajax.readyState == 4) {
          document.location.href = document.location.href;
      }
    }
       



  ajax.send(null);
}


</script>
<style type="text/css">
img{border:none;}
a{color:#000; text-decoration:none;}
a:hover{text-decoration:underline;}
body{background:#fff;
font:14px Arial, Helvetica, sans-serif;
margin:0;}

#contenedor{width:950px;
margin: 0px auto;
overflow:hidden;
}
#loading{
 text-align:center; 
background:#6CBF19; 
color:#000; 
width:30%;
margin:0px auto;
  -moz-border-radius-bottomright:5px;
  -moz-border-radius-bottomleft:5px;
  -webkit-border-bottom-right-radius:5px;
  -webkit-border-bottom-left-radius:5px;

}
#loading2{
 text-align:center; 
background:#000000; 
color:#fff; 
width:30%;
margin:0px auto;
  -moz-border-radius-bottomright:5px;
  -moz-border-radius-bottomleft:5px;
  -webkit-border-bottom-right-radius:5px;
  -webkit-border-bottom-left-radius:5px;

}
#contenido{
float:left;
padding:5px;
width:750px;
background:#F2F2F2;
}
#enlaces{float:left;}
#encabezado{
background:#999;
list-style:none;
  font-size:14px;
  text-align:center;
   color:#fff;
   }
ul{
margin-top:-10px;
width:150px;
padding:10px;
list-style:none;
} 
  
li{
padding:2px;
margin:3px 0px;
width:150px;
border:1px solid #000000;
}
li:hover{background:#EFFCE0;}

span.test { direction: rtl; unicode-bidi:bidi-override; } 

li:first-child{
font:bold 15px Geneva,Georgia;
color:#CCCCCC;
background:#666666;
text-transform:uppercase;
}
#tabla1 {
  float: left;
}


</style>
<body>
<script type="text/javascript">
	function ver(nombre_archivo) {
		<CENTER>
	<EMBED SRC="escaneados/"+nombre_archivo"+.pdf" WIDTH=750 HEIGHT=300 HREF="escaneados/"+nombre_archivo+".pdf"><BR>
	<I>"DOCUMENTO REVISADO : "+nombre_archivo</I>
	</CENTER>

	}
</script>

<table border="1" id="tabla1" >
  <tr>
    <th scope="col">Ver</th>
    <th scope="col">Nombre</th>
    <th scope="col">Proceso</th>
    <th scope="col">enviar</th>
    <th scope="col">Certificar Vigencia</th>
  </tr>

<?php 
$dir0 = "\\\\192.168.0.253\\users\\MVASQUEZ\\BOLETAS\\"; //CARPETA BOLETAS SIN PROCESAR Z:\gestor\enviados
$dir1 = "./escaneados/"; //CARPETA ESCANEADOS
$dir2 = "./firmar/"; //CARPETA FIRMAR
$dir3 = "./firmados/"; //CARPETA FIRMADOS
//$dir4 = "./enviados/"; //CARPETA ENVIADOS POR CORREO ELECTRÓNICO
$directorio0=opendir($dir0); 
$directorio1=opendir($dir1); 
$directorio2=opendir($dir2); 
$directorio3=opendir($dir3); 
//$directorio4=opendir($dir4); 



while ($archivo = readdir($directorio0)){ 
  if($archivo=='.' or $archivo=='..'){ 
    echo ""; 
  }else { 

    if(file_exists($dir0.$archivo)) {
      echo $archivo;
    } 
  }
}



echo "<span class='texto_menu_Titulo'>GESTOR DOCUMENTOS FIRMA ELECTRONICA</span>"; 
echo "<br><br>"; 
while ($archivo = readdir($directorio1)){ 
	if($archivo=='.' or $archivo=='..'){ 
 		echo ""; 
 	}else { 
 		$enlace1 = $dir1.$archivo; 
		//CONDICIONAL PARA SABER SI EL DOCUMENTO ESTA EN LA CARPETA ESCANEADOS
    if(file_exists($enlace1)) {
      $firmado="<a href=".'"'."javascript:Codigobarras('codigobarras.php?path1=$dir1&nombre=$archivo','procesado')".'"'." title=".'"'."Generar Código Barras".'"'.">Cod.Barras</a>";
    } 
		 ?>
 <tr>
    <td><div id="procesado"><a href="javascript:Enviar('pdf.php?path1=<?php echo $dir1.'&nombre='.$archivo ?>','contenido')" title="Archivo PDF">PDF</a></div></td>
    <td><?php echo $archivo;?></td>
    <td><?php echo $firmado;?></td>
    <td><a href='enviar.php'><?php echo $var = ($firmado=="NO FIRMADO") ? '' : 'Enviar';?><br></a></td>
    <td><a href='enviar.php'><?php echo $var = ($firmado=="NO FIRMADO") ? 'Certificar' : '';?><br></a></td>
  </tr>
       <?php
	 } 
} 
while ($archivo = readdir($directorio2)){ 
	if($archivo=='.' or $archivo=='..'){ 
 		echo ""; 
 	}else { 
 		$enlace2 = $dir2.$archivo; 
		//CONDICIONAL PARA SABER SI EL DOCUMENTO ESTA EN LA CARPETA FIRMAR 
		if(file_exists($enlace2)) {
			$firmado="FIRMAR";
		} 
		 ?>
 <tr>
    <td><a href="javascript:Enviar('pdf.php?path1=<?php echo $dir2.'&nombre='.$archivo ?>','contenido')" title="Archivo PDF">PDF</a></td>
    <td><?php echo $archivo;?></td>
    <td><?php echo $firmado;?></td>
    <td><a href='enviar.php?nombre=<?php echo $archivo;?>'><?php echo 'Enviar';?><br></a></td>
    <td></td>
  </tr>
       <?php
	 } 
} 
while ($archivo = readdir($directorio3)){ 
  if($archivo=='.' or $archivo=='..'){ 
    echo ""; 
  }else { 
    $enlace3 = $dir3.$archivo; 
    //CONDICIONAL PARA SABER SI EL DOCUMENTO ESTA EN LA CARPETA FIRMADOS 
    if(file_exists($enlace3)) {
      $firmado="FIRMADO";
    } 
     ?>
 <tr>
    <td><a href="javascript:Enviar('pdf.php?path1=<?php echo $dir3.'&nombre='.$archivo ?>','contenido')" title="Archivo PDF">PDF</a></td>
    <td><?php echo $archivo;?></td>
    <td><?php echo $firmado;?></td>
    <td><a href='enviar.php?nombre=<?php echo $archivo;?>'><?php echo 'Enviar';?><br></a></td>
    <td></td>
  </tr>
       <?php
   } 
}
/*while ($archivo = readdir($directorio4)){ 
	if($archivo=='.' or $archivo=='..'){ 
 		echo ""; 
 	}else { 
 		$enlace4 = $dir4.$archivo; 
		//CONDICIONAL PARA SABER SI EL DOCUMENTO ESTA EN LA CARPETA ENVIADO 
		if(file_exists($enlace4)) {
			$firmado="ENVIADO";
		} 
		 ?>
 <tr>
    <td><a href="javascript:Enviar('pdf.php?path1=<?php echo $dir4.'&nombre='.$archivo ?>','contenido')" title="Archivo PDF">PDF</a></td>
    <td><?php echo $archivo;?></td>
    <td><?php echo $firmado;?></td>
    <td><a href='enviar.php'><?php echo $var = ($firmado=="ENVIADO") ? '' : 'Enviar';?><br></a></td>
    <td></td>
  </tr>
       <?php
	 } 
} */
closedir($directorio1); 
closedir($directorio2); 
closedir($directorio3);
//closedir($directorio4);
?> 

</table>
<div id="contenido">
              <p><em><strong>INFORMACIÓN DEL ARCHIVO PDF</strong></em></p>
</div>


<!--<div>
<object data="files/MANUAL ALARMA MIRAX.pdf" type="application/pdf" width="800" height="600">
  alt : <a href="files/MANUAL ALARMA MIRAX.pdf">archivo.pdf</a>
</object>
</div>
 --><script type="text/javascript">
//	location.reload();
//$('a.media').media({width:300, height:200});
</script>
 

</body>

