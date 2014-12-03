<!-- CERTIFICACION DE GRAVAMEN 2 PÁGINAS -->
<!doctype html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>CERTIFICADOS GRAVAMENES</title>
<style type="text/css">
body {
	font-family: arial;
	font-size: 14px;
}
#cuerpo {
/*	border: 1px solid #000000; */
	position: relative;
	z-index: 1;
		@page { size 8.5in 13in}
		font-family: arial;


	margin-left: 2em;
	margin-right: 1em;
	height: 100%;
	width: 45em;
		text-align: justify;

}
#vistobueno {
/*	border: 1px solid #000000; */
	margin-top: -118px;
	margin-left: 100px;
	height: 100px;
	width: 115px;
	z-index: 2;

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
	margin-left: 28em;
	text-align: center;
}
.printx {page-break-after:always} /*salto de pagina*/

</style>
</head>
<body>
		<div id="cuerpo">
<?php 
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
	$texto = str_replace("H","",$texto);
	$texto = str_replace(" CONSERVADOR DE BIENES RAICES","<div class='titulo'><h1><b><u>CONSERVADOR DE BIENES RAICES DE CHILLAN</u></b></h1></div><br><br><br>",$texto);
	$texto = str_replace("--------------------------H","",$texto);
	$texto = str_replace(" CHILLAN ","",$texto);
	$texto = str_replace("================================","",$texto);
	$espacios="";
	for ($i=0; $i <=102 ; $i++) { 
		$espacios=$espacios."&nbsp;";
	}
	$texto = str_replace("GFolio :",$espacios."Folio :",$texto);
	$texto = str_replace(" C E R T I F I C A D O S ",$imagen."<div class='titulo'><h3><b><u>C E R T I F I C A D O S</u></b></h3></div><br>",$texto);
	$texto = str_replace("A nombre de :","A nombre de:</br><strong>",$texto);
	$texto = str_replace("Revisados","<br/></strong>Revisados",$texto);
	$texto = str_replace("&*&","<br/>*",$texto);

	$texto = str_replace("período.-","período.-<br/>",$texto);
	$texto = str_replace("propiedad.-","propiedad.-<br/>",$texto);
	$texto = str_replace(".-&",".-<br/>",$texto);
	$texto = str_replace("aguas.-","aguas.-<br/>",$texto);

	$onda="";
	for ($i=0; $i <=78 ; $i++) { 
		$onda=$onda."~";
	}

	$texto = str_replace(",,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,",$onda,$texto);
	$texto = str_replace("BIEN FAMILIAR","<div class='titulo'><h3><b><u>BIEN FAMILIAR</u></b></h3></div>",$texto);
	$texto = str_replace("-------------","",$texto);
	$texto = str_replace("CHILLAN,","<strong>CHILLAN,</strong>",$texto);
	$texto = str_replace("LUIS A. GONZALEZ ALVARADO","<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><div class='firma'>LUIS A. GONZALEZ ALVARADO<br></div>",trim($texto));
	$texto = str_replace("Conservador - Archivero","<div class='firma'>Conservador - Archivero</div><br><br>",trim($texto));
	$texto = str_replace("(*SALTO*)","<p class='printx'></p>",$texto);
	$texto = str_replace(".-.-",".-",$texto);
 
	return $texto;

}
header('Content-Type: text/html; charset=UTF-8'); 
//$archivo=fopen("y:\\rsilva\\raul1.txt", "r") or die("Problemas al abrir el Archivo");
$archivo=fopen("\\\\192.168.0.253\\appl\\folio2\\certi.txt", "r") or die("Problemas al abrir el Archivo");
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


