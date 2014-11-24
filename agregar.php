<?php require_once('Connections/gestor.php'); 
$caratula=$_GET['caratula']; 
  $origen = "C:/xampp/htdocs/gestor/escaneados/".$caratula;
  $destino = "C:/xampp/htdocs/gestor/firmar/".$_POST['pdf'];
//  $origen = "C:/apache/htdocs/gestor/escaneados/".$caratula;
//  $destino = "C:/apache/htdocs/gestor/firmar/".$_POST['pdf'];
	if(file_exists($origen)) {	  
	  rename($origen, $destino );
	} else {
		echo "Sin archivo PDF!!!";
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Asignación de Carátulas</title>
<link href="css/estilo2.css" rel="stylesheet" type="text/css">
<script type="text/javascript">
function volver() {
	document.location.href="index.php";
}
function grabar() {
	document.form1.pdf.value=document.form1.caratula.value+'.pdf';
}
</script>
</head>

<body>
<div id="cajon1">
<object data="escaneados/<?php echo $caratula; ?>" width="500" height="375" type="application/pdf">
alt : <a href="escaneados/<?php echo $caratula; ?>">archivo.pdf</a>
</object>
</div>

<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <div id="tabla">
  <table width="400" >
  <p align="center"><strong>Asignar : <?php echo $caratula; ?></strong></p>
    <tr >
    </tr>
    <tr >
      <td nowrap="nowrap" align="right">Caratula:</td>
      <td><input type="text" name="caratula" value="" size="32" /></td>
    </tr>
    <tr >
      <td nowrap="nowrap" align="right">Fecha:</td>
      <td><input type="date" name="fecha" value="" size="32" /></td>
    </tr>
    <tr >
      <td nowrap="nowrap" align="right">Observacion:</td>
      <td><input type="text" name="observacion" value="" size="32" /></td>
      <td><input name="pdf" type="hidden" value="" /></td>
    </tr>
    <tr >
      <td nowrap="nowrap" align="right">Tipo:</td>
      <td><label for="tipo"></label>
        <select name="tipo" id="tipo">
          <option value="1">Con privilegio</option>
          <option value="2">Con dificultad</option>
      </select></td>
    </tr>
    <tr >
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" value="Insertar registro" onclick="grabar()"/>
        <label>
          <input type="button" name="button" id="button" value="Volver" onclick="volver()"/>
        </label></td>
    </tr>
  </table></div>
  
  <input type="hidden" name="MM_insert" value="form1" />
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
?>
