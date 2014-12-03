<!-- CERTIFICACION DE VIGENCIA 1 PÁGINA (SIN CONFORME A SU MATRIZ) -->
<!doctype html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>CERTIFICADOS VIGENCIAS Y GRAVAMENES</title>
<style type="text/css">
body {
	font-family: arial;
	font-size: 14px;
}
#cuerpo {
/*	border: 1px solid #000000; */
	@page { size 8.5in 13in}
		font-family: arial;

	margin-left: 8em;
	margin-right: 40em;
	height: 100%;
	width: 30em;
		text-align: justify;

}
#vistobueno {
/*	border: 1px solid #000000; */
	margin-top: -82px;
	margin-left: -40px;
	height: 100px;
	width: 115px;
}
#vistobueno img {
	height: 70%;
	width: 95%;
}
.titulo {
	text-align: center;
}
.firma {
/*	border: 1px solid #000000; */
	margin-left: 8em;
	text-align: center;
}
.printx {page-break-after:always} /*salto de pagina*/

</style>
</head>
<body>
		<div id="cuerpo">
<?php 
//$_SESSION['usuario'] = "gmc";    // GUSTAVO MANRIQUEZ
$_SESSION['usuario'] = "rsilva"; 
$usuario = $_SESSION['usuario'];
function acentos($texto) {
//	setlocale(LC_CTYPE, 'nl_BE.utf8');
//	$texto = mb_convert_encoding($texto, "CP852", "UTF-8");
	$texto_final = iconv('CP850', 'ASCII//TRANSLIT', $texto);
	return $texto_final;
}
function acentos2($texto) {
	$imagen="<div id='vistobueno'><img id='vistobueno_img' src='imagen/".$_SESSION['usuario'].".jpg' alt='imagen'/></div>";
	$texto = str_replace("'a","á",$texto);
	$texto = str_replace("'e","é",$texto);
	$texto = str_replace("'i","í",$texto);
	$texto = str_replace("'o","ó",$texto);
	$texto = str_replace("'u","ú",$texto);
	$texto = str_replace("~n","ñ",$texto);
	$texto = str_replace("'A","Á",$texto);
	$texto = str_replace("'E","É",$texto);
	$texto = str_replace("'I","Í",$texto);
	$texto = str_replace("'O","Ó",$texto);
	$texto = str_replace("'U","Ú",$texto);
	$texto = str_replace("~N","Ñ",$texto);
	$texto = str_replace("G ","",$texto);
	$texto = str_replace("C","",$texto);
	$texto = str_replace("CERTIFICADO DE INSCRIPCION","<div class='titulo'><b><u>CERTIFICADO DE INSCRIPCION</u></b></div><br><br><br>".$imagen,$texto);
	$texto = str_replace("--------------------------H","",$texto);
	$texto = str_replace("CHILLAN, H","<br/><br/><strong>CHILLAN</strong>, ",$texto);
	$texto = str_replace("CERTIFICADO DE VIGENCIA","<div class='titulo'><b><u>CERTIFICADO DE VIGENCIA</u></b></div><br><br/><br/>",$texto);
	$texto = str_replace("G*","*",$texto);
	$texto = str_replace("------------------------H","",$texto);
	$texto = str_replace("H","",$texto);
	$texto = str_replace("LUIS A. GONZALEZ ALVARADO","<br/><br/><br/><br/><br/><br/><br/><br/><br/><div class='firma'>LUIS A. GONZALEZ ALVARADO<br></div>",trim($texto));
	$texto = str_replace("Conservador - Archivero","<div class='firma'>Conservador - Archivero</div><br><br>",trim($texto));
	$texto = str_replace("(*SALTO*)","<p class='printx'></p>",$texto);
	$texto = str_replace(".-.-",".-",$texto);
//	$texto = str_replace(".-",".-<br/>",$texto);
	$texto = str_replace("*","<br/>*",$texto);
	$texto = str_replace("Por no existir","<br/>Por no existir",$texto);

	return $texto;

}
header('Content-Type: text/html; charset=UTF-8'); 
//$archivo=fopen("y:\\rsilva\\raul1.txt", "r") or die("Problemas al abrir el Archivo");
$archivo=fopen("\\\\192.168.0.252\\inscripciones\\".$usuario."\\".$usuario."1.txt", "r") or die("Problemas al abrir el Archivo");
$x=0;
$texto1="";
while(!feof($archivo)) {
	$x++;
	$traer=acentos(fgets($archivo));
	$saltodelinea=$traer; //nl2br($traer);
	$texto_final= trim(acentos2(($saltodelinea)));
	$texto1=$texto1." ".$texto_final;

}
echo "<p>".$texto1."</p>";

?>	
</div>
</body>
</html>


